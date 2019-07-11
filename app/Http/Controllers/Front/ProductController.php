<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Show index page
     */
    public function index($cid, $perpage = 10)
    {
        $user = Auth::user();

        $categories = Category::all();
        $arr_categories = array();

        foreach($categories as $category) {
            $arr_categories[$category->name][] = array(
                'cid' => $category->cid,
                'subname' => $category->subname
            );
        }

        $popular_products = Category::with('products')
            ->where('show_popular', true)
            ->where('cid', $cid)
            ->get()
            ->map(function($category) {
                $category->setRelation('products', $category->products->sortByDesc('created_at')->take(3));
                return $category;
        });

        $products = Product::where('cid', $cid)->paginate($perpage);

        return view('front.product-lists', [
            'user' => $user,
            'categories' => $arr_categories,
            'popular_products' => $popular_products,
            'cid' => $cid,
            'products' => $products
        ]);
    }
}
