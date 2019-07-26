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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // process datatables ajax request
        if ($request->ajax()) {
            // request data
            $start = $request->input('start');
            $length = $request->input('length');
            $columns = $request->input('columns');
            $order = $request->input('order');
            $search = $request->input('search');

            $orderBy = $columns[$order[0]['column']]['name'];
            $orderType = $order[0]['dir'];
            switch ($orderBy) {
                case 'oid':
                case 'created_at':
                case 'recipient_name':
                case 'recipient_tel':
                case 'recipient_add':
                case 'status':
                    $orderBy = $orderBy;
                    break;
            }

            // get data
            $orders = Order::orderBy($orderBy, $orderType)
                      ->offset($start)
                      ->limit($length)
                      ->get();

            // count total record
            $total = $orders->count();

            foreach ($orders as $order) {
                $result[] = array(
                    'oid' => $order->oid,
                    'created_at' => date("Y-m-d H:i:s", strtotime($order->created_at)),
                    'recipient_name' => $order->recipient_name,
                    'recipient_tel' => $order->recipient_tel,
                    'recipient_add' => $order->recipient_add,
                    'status' => $order->status,
                    'action' => $order->oid
                );
            }

            $response = array();
            $response['success'] = true;
            $response['recordsTotal'] = $total;
            $response['recordsFiltered'] = $total;
            $response['data'] = $result;
            return json_encode($response);
        }

        return view('back.order', [
            'user' => $this->user
        ]);
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
