<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $categories = Category::all();
        $arr_categories = array();

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
        } else {
            $allCart = array();
        }
        $topCart = array('count' => $count, 'total' => '$'.number_format($total));

        return view('front.shopping-cart', [
            'user' => $user,
            'categories' => $arr_categories,
            'topCart' => $topCart,
            'allCart' => $allCart
        ]);
    }

    /**
     * Store a product to cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // init return value
        $err = 'false';
        $err_msg = '';
        $result = array();

        $rules = [
            'pid' => 'required|integer',
            'psid' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ];

        $messages = [
            '*.required' => '內容不合法',
            '*.integer' => '內容不合法',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // 暫時不做動作
        } else {
            $product = ProductSpecification::with('product')
                       ->where('pid', '=', $request->input('pid'))
                       ->where('psid', '=', $request->input('psid'))
                       ->first();

            if (!empty($product)) {
                $psid = $product->psid;
                $remain_quantity = $product->quantity;
                $quantity = $request->input('quantity');
                if ($request->session()->has('cart.'.$psid)) {
                    $cart = $request->session()->get('cart.'.$psid);
                    $cart['quantity'] += $quantity;
                    $cart['total'] = $cart['quantity'] * $cart['price'];
                    $quantity = $cart['quantity'];
                } else {
                    $cart = array(
                        'pid' => $product->product->pid,
                        'name' => $product->product->name,
                        'price' => $product->product->price,
                        'cid' => $product->product->cid,
                        'description' => $product->product->description,
                        'path' => $product->product->path,
                        'image' => $product->product->image,
                        'specification' => $product->specification,
                        'remain_quantity' => $remain_quantity,
                        'quantity' => $quantity,
                        'total' => ($quantity * $product->product->price)
                    );
                }

                if ($quantity <= $remain_quantity) {
                    $request->session()->put('cart.'.$psid, $cart);

                    $count = 0;
                    $total = 0;
                    $allCart = $request->session()->get('cart');
                    if (is_array($allCart)) {
                        foreach($allCart as $key => $value) {
                            $count++;
                            $total += $value['total'];
                        }
                    }
                    $result = array('count' => $count, 'total' => '$'.number_format($total));
                } else {
                    $err = 'true';
                    $err_msg = '庫存不足';
                }
            }
        }

        return array('err' => $err, 'err_msg' => $err_msg, 'result' => $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $psid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $psid)
    {
        // init return value
        $err = 'false';
        $err_msg = '';
        $result = array();

        $rules = [
            'quantity' => 'required|integer',
        ];

        $messages = [
            '*.required' => '內容不合法',
            '*.integer' => '內容不合法',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // 暫時不做動作
        } else {
            if ($request->session()->has('cart.'.$psid)) {
                $cart = $request->session()->get('cart.'.$psid);
                $cart['quantity'] = $request->input('quantity');
                $cart['total'] = $cart['quantity'] * $cart['price'];
                $quantity = $cart['quantity'];

                $request->session()->put('cart.'.$psid, $cart);
            } else {
                // 暫時不做動作
            }
        }

        $count = 0;
        $total = 0;
        $itemTotal = 0;
        $allCart = $request->session()->get('cart');
        if (is_array($allCart)) {
            foreach($allCart as $key => $value) {
                $count++;
                $total += $value['total'];
                if ($key == $psid) $itemTotal = $value['total'];
            }
        }
        $result = array('count' => $count, 'total' => '$'.number_format($total), 'itemTotal' => '$'.number_format($itemTotal));

        return array('err' => $err, 'err_msg' => $err_msg, 'result' => $result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $psid
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $psid)
    {
        $request->session()->forget('cart.'.$psid);

        // init return value
        $err = 'false';
        $err_msg = '';

        $count = 0;
        $total = 0;
        $allCart = $request->session()->get('cart');
        if (is_array($allCart)) {
            foreach($allCart as $key => $value) {
                $count++;
                $total += $value['total'];
            }
        }
        $result = array('count' => $count, 'total' => '$'.number_format($total));

        return array('err' => $err, 'err_msg' => $err_msg, 'result' => $result);
    }
}
