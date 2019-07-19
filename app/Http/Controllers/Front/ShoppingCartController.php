<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Validator;

class ShoppingCartController extends Controller
{
    /**
     * Store a product to cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->session()->flush();

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
                        'specification' => $product->specification,
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
}
