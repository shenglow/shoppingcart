@extends('front.layouts.auth')

@section('title', 'Shop UI')

@section('content')
<!-- Outer Row -->
<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3">
        <div class="jumbotron margin-top-10 margin-bottom-10 br-5">
            <!-- Nested Row -->
            <div class="row">
                <div>
                    <div>
                        <div class="text-center">
                            <h1 class="margin-bottom-20">忘記密碼?</h1>
                        </div>
                        @if (session('msg'))
                            <div class="alert {{ session()->get('msg')['type'] }}" role="alert">
                                {{ session()->get('msg')['content'] }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('forgotpassword') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="username" class="form-control br-10" name="username" placeholder="Username" value="{{ old('username') }}">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control br-10" name="email" placeholder="Email Address" value="{{ old('email') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block br-10">重設密碼</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ url('register') }}">建立帳號!</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ url('login') }}">已經有帳號?登入!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection