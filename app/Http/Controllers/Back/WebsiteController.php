<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Carbon\Carbon;

class WebsiteController extends Controller
{
    /**
     * Show index page
     */
    public function index()
    {
        $user = Auth::user();

        $monthly = 0;
        $annual = 0;
        $pendingOrders = Order::where('status', '=', 'pending')->count();
        $overview = array(
            'Jan' => 0,
            'Feb' => 0,
            'Mar' => 0,
            'Apr' => 0,
            'May' => 0,
            'Jun' => 0,
            'Jul' => 0,
            'Aug' => 0,
            'Sep' => 0,
            'Oct' => 0,
            'Nov' => 0,
            'Dec' => 0
        );

        $m_start = Carbon::now()->startOfMonth();
        $m_end = Carbon::now()->endOfMonth();
        $monthOrders = Order::with('products')->whereBetween('created_at', [$m_start, $m_end])->where('status', '=', 'shipped')->get();
        if (count($monthOrders) > 0) {
            foreach($monthOrders as $order) {
                foreach($order->products as $product) {
                    $monthly += ($product->quantity * $product->price);
                }
            }
        }

        $y_start = Carbon::now()->startOfYear();
        $y_end = Carbon::now()->endOfYear();
        $annualOrders = Order::with('products')->whereBetween('created_at', [$y_start, $y_end])->where('status', '=', 'shipped')->get();
        if (count($annualOrders) > 0) {
            foreach($annualOrders as $order) {
                $tmp_month = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->getTranslatedShortMonthName('ddd');
                foreach($order->products as $product) {
                    $overview[$tmp_month] += ($product->quantity * $product->price);
                    $annual += ($product->quantity * $product->price);
                }
            }
        }
        // dd(array_keys($overview));
        return view('back.index', [
            'user' => $user,
            'monthly' => $monthly,
            'annual' => $annual,
            'pendingOrders' => $pendingOrders,
            'overviewKey' => array_keys($overview),
            'overviewValue' => array_values($overview)
        ]);
    }
}
