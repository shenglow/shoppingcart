<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Account Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating admins for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest:web')->except('logout');
    }

    /**
     * Show account index page
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
        }
        $topCart = array('count' => $count, 'total' => '$'.number_format($total));

        return view('front.account', [
            'user' => $user,
            'topCart' => $topCart
        ]);
    }

    /**
     * Show edit account form
     */
    public function showEditAccountForm()
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
        }
        $topCart = array('count' => $count, 'total' => '$'.number_format($total));

        return view('front.account-edit', [
            'user' => $user,
            'topCart' => $topCart
        ]);
    }

    /**
     * Validate required fields and update account info
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editAccount(Request $request)
    {
        $user = Auth::user();

        if (empty($request->input('original_password'))) {
            $rules = [
                'email' => 'required|email',
            ];
    
            $messages = [
                'email.required' => 'E-Mail為必填欄位',
                'email.email' => 'E-Mail格式不正確',
            ];
        } else {
            $rules = [
                'email' => 'required|email',
                'new_password' => 'required_with:original_password|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
                'repeat_password' => 'required_with:original_password|min:8|same:new_password',
            ];
    
            $messages = [
                'email.required' => 'E-Mail為必填欄位',
                'email.email' => 'E-Mail格式不正確',
                'new_password.regex' => '新密碼必須包含大小寫字母,數字,特殊符號',
                '*.required_with' => '新密碼為必填欄位',
                '*.min' => '新密碼最少8位數',
                'repeat_password.same' => '密碼不一致',
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        $arr_msg = array();
        if ($validator->fails()) {
            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                if (!in_array($message, $arr_msg)) $arr_msg[] = $message;
            }
        } else {
            $users = User::where('email', '=', $request->input('email'))->where('id', '!=', $user->id)->get();
            if (count($users) > 0) {
                $arr_msg[] = 'E-Mail已被使用';
            }

            if (!empty($request->input('original_password'))) {
                if (!Hash::check($request->input('original_password'), $user->password)) {
                    $arr_msg[] = '舊密碼不正確';
                }
            }
        }

        if (count($arr_msg) > 0) {
            $msg = array('content' => '修改失敗: '.implode(',', $arr_msg), 'type' => 'alert-danger');
            Session::flash('msg', $msg);
            return redirect()->route('account.edit')->withInput();
        } else {
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('new_password'));
            $user->save();

            $msg = array('content' => '修改成功', 'type' => 'alert-success');
            Session::flash('msg', $msg);
            return redirect()->route('account.index');
        }
    }

    /**
     * Show login form
     */
    public function showUserLoginForm()
    {
        return view('front.login');
    }

    /**
     * Validate required fields and authenticate user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userLogin(Request $request)
    {
        $arr_msg = array();

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $messages = [
            'username.required' => 'username 為必填欄位',
            'password.required' => 'password 為必填欄位',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                $arr_msg[] = $message;
            }
        } else {
            if (Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password], $request->get('remember'))) {
                return redirect('/');
            }

            $arr_msg[] = '使用者名稱或密碼錯誤';
        }

        $msg = array('content' => '登入失敗: '.implode(',', $arr_msg), 'type' => 'alert-danger');
        Session::flash('msg', $msg);
        return back()->withInput($request->only('username', 'remember'));
    }

    /**
     * Show register form
     */
    public function showUserRegisterForm()
    {
        return view('front.register');
    }

    /**
     * Validate required fields and register user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userRegister(Request $request)
    {
        $arr_msg = array();

        $rules = [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            're-password' => 'required|same:password',
        ];

        $messages = [
            'username.required' => 'username 為必填欄位',
            'email.required' => 'email 為必填欄位',
            'email.email' => 'email 格式不正確',
            'password.required' => 'password 為必填欄位',
            'password.min' => 'password 最少8位數',
            're-password.required' => 'password 為必填欄位',
            're-password.same' => '密碼不一致',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                $arr_msg[] = $message;
            }
        } else {
            $user = User::firstOrCreate(
                ['username' => $request->input('username'), 'email' => $request->input('email')],
                ['password' => bcrypt($request->input('password'))]
            );

            if (!$user->wasRecentlyCreated) {
                $arr_msg[] = '使用者名稱或Email已存在';
            }
        }

        if (count($arr_msg) > 0) {
            $msg = array('content' => '註冊失敗: '.implode(',', $arr_msg), 'type' => 'alert-danger');
            Session::flash('msg', $msg);
            return redirect('register')->withInput();
        } else {
            return redirect('login');
        }
    }

    /**
     * Use default logout function to log the user out of the application but override redirect path
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->to('/');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('front.forgot-password');
    }

    /**
     * Reset random password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        $arr_msg = array();

        $rules = [
            'username' => 'required',
            'email' => 'required|email',
        ];

        $messages = [
            'username.required' => 'username 為必填欄位',
            'email.required' => 'email 為必填欄位',
            'email.email' => 'email 格式不正確',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                $arr_msg[] = $message;
            }
        } else {
            $users = User::where('username', '=', $request->input('username'))->where('email', '=', $request->input('email'))->get();
            if (count($users) <= 0) {
                $arr_msg[] = 'username或email不正確';
            } else {
                foreach($users as $user) {
                    $randomPassword = str_random(16);
                    $user->password = bcrypt($randomPassword);
                    $user->save();

                    Mail::to($user->email)->send(new ForgotPassword($user->username, $randomPassword));
                }
            }
        }

        if (count($arr_msg) > 0) {
            $msg = array('content' => '重設失敗: '.implode(',', $arr_msg), 'type' => 'alert-danger');
            Session::flash('msg', $msg);
            return redirect('forgotpassword')->withInput();
        } else {
            return redirect('login');
        }
    }

    /**
     * List order
     */
    public function listOrder()
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
        }
        $topCart = array('count' => $count, 'total' => '$'.number_format($total));

        $orders = Order::where('id', '=', $user->id)->orderBy('created_at', 'desc')->get();

        return view('front.account-listorder', [
            'user' => $user,
            'topCart' => $topCart,
            'orders' => $orders
        ]);
    }

    /**
     * Show order detail
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  integer $oid
     * 
     * @return \Illuminate\Http\Response
     */
    public function showOrder(Request $request, $oid)
    {
        $user = Auth::user();

        $order = Order::find($oid);
        if ($order === null || $order->id != $user->id) {
            $msg = array('content' => '查無此訂單', 'type' => 'alert-danger');
            $request->session()->flash('msg', $msg);

            return redirect()->route('account.order');
        }

        $orderProducts = OrderProduct::with('product', 'specification')->where('oid', '=', $oid)->get();

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

        return view('front.account-listorder-detail', [
            'user' => $user,
            'topCart' => $topCart,
            'order' => $order,
            'orderProducts' => $orderProducts
        ]);
    }
}
