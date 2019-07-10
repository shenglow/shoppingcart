<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class WebsiteController extends Controller
{
    /**
     * Show index page
     */
    public function index()
    {
        $user = Auth::user();

        $products = Product::where('is_enable', true)->orderBy('created_at', 'desc')->take(10)->get();

        return view('front.index', ['user' => $user, 'products' => $products,]);
    }
}
