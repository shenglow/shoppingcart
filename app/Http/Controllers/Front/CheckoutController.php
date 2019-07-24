<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductSpecification;

class CheckoutController extends Controller
{
    /**
     * Show index page
     */
    public function index()
    {
        $user = Auth::user();

        $count = 0;
        $total = 0;
        $allCart = session('cart');
        if (is_array($allCart)) {
            foreach($allCart as $key => $value) {
                $count++;
                $total += $value['total'];
            }
        } else {
            return redirect()->route('shoppingcart.index');
        }
        $topCart = array('count' => $count, 'total' => '$'.number_format($total));

        return view('front.checkout', [
            'user' => $user,
            'topCart' => $topCart,
            'allCart' => $allCart
        ]);
    }

    /**
     * Confirm checkout to create new order
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
        $rules = [
            'orderer_name' => 'required',
            'orderer_email' => 'required|email',
            'orderer_tel' => 'required',
            'orderer_add' => 'required',
            'recipient_name' => 'required_without:sync_info,on',
            'recipient_email' => 'required_without:sync_info,on|email',
            'recipient_tel' => 'required_without:sync_info,on',
            'recipient_add' => 'required_without:sync_info,on',
        ];

        $messages = [
            '*.required' => '請輸入所有必要資料',
            '*.required_without' => '請輸入所有必要資料',
            '*.email' => 'email不合法',
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

            return redirect('/checkout')->withInput();
        } else {
            $user = Auth::user();

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

            DB::beginTransaction();
            try {
                $order = new Order;
                $order->id = $user->id;
                $order->orderer_name = $request->input('orderer_name');
                $order->orderer_email = $request->input('orderer_email');
                $order->orderer_tel = $request->input('orderer_tel');
                $order->orderer_add = $request->input('orderer_add');
                $order->recipient_name = $request->input('recipient_name');
                $order->recipient_email = $request->input('recipient_email');
                $order->recipient_tel = $request->input('recipient_tel');
                $order->recipient_add = $request->input('recipient_add');
                $order->status = 'pending';
                $order->save();

                foreach($allCart as $key => $value) {
                    $specification = ProductSpecification::find($key);
                    if ($specification === null) {
                        throw new Exception('查無商品');
                    } else {
                        if ($specification->quantity >= $value['quantity']) {
                            $specification->quantity -= $value['quantity'];
                            $specification->save();

                            $orderProduct = new OrderProduct;
                            $orderProduct->oid = $order->oid;
                            $orderProduct->pid = $value['pid'];
                            $orderProduct->psid = $key;
                            $orderProduct->quantity = $value['quantity'];
                            $orderProduct->price = $value['price'];
                            $orderProduct->pid = $value['pid'];
                            $orderProduct->save();
                        } else {
                            throw new Exception('商品:'.$value['name'].' - '.$value['specification'].' 的庫存不足.');
                        }
                    }
                }

                DB::commit();

                // delete cart content
                $request->session()->forget('cart');
            } catch (\Exception $e) {
                DB::rollback();
                $msg = array('content' => $e->getMessage(), 'type' => 'alert-danger');
                $request->session()->flash('msg', $msg);

                return redirect('/checkout')->withInput();
            }

            return redirect('/');
        }
    }
}
