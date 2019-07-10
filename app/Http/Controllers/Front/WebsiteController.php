<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

class WebsiteController extends Controller
{
    /**
     * Show index page
     */
    public function index()
    {
        $user = Auth::user();

        $new_products = Product::where('is_enable', true)->orderBy('created_at', 'desc')->take(10)->get();

        $categories = Category::all();
        $arr_categories = array();

        foreach($categories as $category) {
            $arr_categories[$category->name][] = array(
                'cid' => $category->cid,
                'subname' => $category->subname
            );
        }

        return view('front.index', ['user' => $user, 'new_products' => $new_products, 'categories' => $arr_categories,]);
    }
}
