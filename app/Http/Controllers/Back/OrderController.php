<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderProduct;

class OrderController extends Controller
{
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();

        return view('back.order', ['user' => $this->user, 'orders' => $orders]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $oid
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $oid)
    {
        $order = Order::find($oid);
        if ($order === null) {
            $msg = array('content' => '查無此訂單', 'type' => 'alert-danger');
            $request->session()->flash('msg', $msg);

            return redirect()->back();
        }

        $orderProducts = OrderProduct::with('product', 'specification')->where('oid', '=', $oid)->get();
        return view('back.order-detail', ['user' => $this->user, 'order' => $order, 'orderProducts' => $orderProducts]);
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $rules = [
            'order' => 'required',
            'action' => 'required',
        ];

        $messages = [
            'order.required' => '缺少必要資料',
            'action.required' => '缺少必要資料',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $err = 'false';
        $err_msg = array();
        if ($validator->fails()) {
            $err = 'true';
            foreach ($validator->errors()->all() as $message) {
                if (!in_array($message, $err_msg)) $err_msg[] = $message;
            }

            $msg = array('content' => implode(',', $err_msg), 'type' => 'alert-danger');
            $request->session()->flash('msg', $msg);
        } else {
            $status = '';
            switch ($request->input('action')) {
                case 'cancel':
                    $status = 'cancel';
                    break;
                case 'shipped':
                    $status = 'shipped';
                    break;
                default:
                    break;
            }

            if (is_array($request->input('order')) && $status != '') {
                foreach($request->input('order') as $oid) {
                    $order = Order::find($oid);
                    if ($order !== null) {
                        $order->status = $status;
                        $order->save();
                    }
                }
            }

            $msg = array('content' => '修改成功', 'type' => 'alert-success');

            $request->session()->flash('msg', $msg);
        }

        return array('err' => $err);
    }
}
