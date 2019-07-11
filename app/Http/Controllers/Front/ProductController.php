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
    public function index($cid, $order = 'default', $perpage = 10)
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

        $arr_order = array();
        switch ($order) {
            case 'name-asc':
                $arr_order['name'] = 'asc';
                break;
            case 'name-desc':
                $arr_order['name'] = 'desc';
                break;
            case 'price-asc':
                $arr_order['price'] = 'asc';
                break;
            case 'price-desc':
                $arr_order['price'] = 'desc';
                break;
            default:
                $arr_order['created_at'] = 'desc';
                break;
        }

        $query = Product::where('cid', $cid);
        foreach ($arr_order as $key => $value) {
            $query->orderBy($key, $value);
        }
        $products = $query->paginate($perpage);

        return view('front.product-lists', [
            'user' => $user,
            'categories' => $arr_categories,
            'popular_products' => $popular_products,
            'cid' => $cid,
            'products' => $products
        ]);
    }
}
