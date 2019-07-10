<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use Session;

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
        $this->middleware('guest:web')->except('logout');
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
}
