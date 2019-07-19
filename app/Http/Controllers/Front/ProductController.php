<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\ProductReview;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Validator;

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
            if ($category->cid == $cid) $arr_categories[$category->name]['cid'] = $cid;
            $arr_categories[$category->name]['subcategory'][] = array(
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

        return view('front.product-lists', [
            'user' => $user,
            'categories' => $arr_categories,
            'popular_products' => $popular_products,
            'cid' => $cid,
            'products' => $products,
            'topCart' => $topCart
        ]);
    }

    /**
     * Show product page
     */
    public function showProduct($cid, $pid)
    {
        $user = Auth::user();

        $categories = Category::all();
        $arr_categories = array();

        foreach($categories as $category) {
            if ($category->cid == $cid) $arr_categories[$category->name]['cid'] = $cid;
            $arr_categories[$category->name]['subcategory'][] = array(
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

        $product = Product::find($pid);

        $specification = Product::find($pid)->specification;

        $reviews = ProductReview::with('user')->where('pid', $pid)->orderBy('created_at', 'desc')->get();

        $in_wishlist = '';
        if (Auth::check()) {
            $wishlist = Wishlist::where([
                ['id', '=', $user->id],
                ['pid', '=', $pid],
            ])->get();
            $in_wishlist = (count($wishlist) > 0) ? 'disabled' : '';
        }
        
        return view('front.product', [
            'user' => $user,
            'categories' => $arr_categories,
            'popular_products' => $popular_products,
            'cid' => $cid,
            'product' => $product,
            'specification' => $specification,
            'reviews' => $reviews,
            'in_wishlist' => $in_wishlist,
            'topCart' => $topCart
        ]);
    }

    /**
     * add a review
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int $pid
     * @return \Illuminate\Http\Response
     */
    public function addReview(Request $request, $pid)
    {
        $user = Auth::user();

        $rules = [
            'review' => 'required',
        ];

        $messages = [
            'review.required' => '請輸入評論內容',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $err = 'false';
        $err_msg = '';
        $reviews = array();
        if ($validator->fails()) {
            $err = 'true';
            foreach ($validator->errors()->all() as $message) {
                $err_msg .= (empty($err_msg)) ? $message : ' , '.$message;
            }
        } else {
            $product_review = new ProductReview;

            $product_review->pid = $pid;
            $product_review->id = $user->id;
            $product_review->review = $request->input('review');

            $product_review->save();

            $reviews = ProductReview::with('user')->where('pid', $pid)->orderBy('created_at', 'desc')->get();
            $review_html = view('front.template.review', ['reviews' => $reviews])->render();
        }

        return array('err' => $err, 'err_msg' => $err_msg, 'review' => $review_html);
    }
}
