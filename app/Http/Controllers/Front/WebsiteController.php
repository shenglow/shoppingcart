<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Carousel;

class WebsiteController extends Controller
{
    /**
     * Show index page
     */
    public function index()
    {
        $user = Auth::user();

        $carousels = Carousel::where('status', '=', true)->get();

        $new_products = Product::where('is_enable', true)->orderBy('created_at', 'desc')->take(10)->get();

        $categories = Category::all();
        $arr_categories = array();
        
        $popular_products = Category::with('products')->where('show_popular', true)->get()->map(function($category) {
            $category->setRelation('products', $category->products->where('is_enable', true)->sortByDesc('views')->take(3));
            return $category;
        });

        foreach($categories as $category) {
            $arr_categories[$category->name]['subcategory'][] = array(
                'cid' => $category->cid,
                'subname' => $category->subname
            );
        }

        $count = 0;
        $total = 0;
        $allCart = session('cart');
        if (is_array($allCart)) {
            foreach($allCart as $key => $value) {
                $count++;
                $total += $value['total'];
            }
        }
        $topCart = array('count' => $count, 'total' => '$'.number_format($total));

        return view('front.index', [
            'user' => $user,
            'carousels' => $carousels,
            'new_products' => $new_products,
            'categories' => $arr_categories,
            'popular_products' => $popular_products,
            'topCart' => $topCart
        ]);
    }
}
