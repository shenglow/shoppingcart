@extends('front.layouts.auth')

@section('title', 'Shop UI')

@section('content')
<!-- Outer Row -->
<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3">
        <div class="jumbotron margin-top-10 margin-bottom-10 br-5">
            <!-- Nested Row -->
            <div class="row">
                <div class="text-center">
                    <h1 class="margin-bottom-20">歡迎光臨!</h1>
                </div>
                @if (session('msg'))
                    <div class="alert {{ session()->get('msg')['type'] }}" role="alert">
                        {{ session()->get('msg')['content'] }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="username" class="form-control br-10" name="username" placeholder="Username" value="{{ old('username') }}">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control br-10" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <div class="small">
                            <input type="checkbox" name="remember">
                            <label for="customCheck">Remember Me</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block br-10">登入</button>
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="{{ url('forgotpassword') }}">忘記密碼?</a>
                </div>
                <div class="text-center">
                    <a class="small" href="{{ url('register') }}">建立帳號!</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection