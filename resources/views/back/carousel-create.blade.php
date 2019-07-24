@extends('back.layouts.main')

@section('title', 'Shop Admin')

@section('nav_carousel', 'active')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    @if (session('msg'))
        <div class="alert {{ session()->get('msg')['type'] }}" role="alert">
            {{ session()->get('msg')['content'] }}
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">輪播設定 - 新增輪播內容</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.carousel.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="image"><span class="text-danger">*</span>照片</label>
                            <input type="file" name="image" id="image">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="href">網址</label>
                            <input type="text" class="form-control form-control-user" name="href" id="href" value="{{ old('href') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="checkbox" name="status" id="status" @if(old('status')) checked @endif>
                            <label for="status">是否顯示</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row float-right">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <span class="text">新增</span>
                        </button>
                        <a href="{{ route('admin.carousel.index') }}" class="btn btn-secondary">
                            <span class="text">取消</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection