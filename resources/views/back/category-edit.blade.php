@extends('back.layouts.main')

@section('title', 'Shop Admin')

@section('nav_category', 'active')

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
            <h6 class="m-0 font-weight-bold text-primary">類別設定 - 修改類別</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.category.update', $category->cid) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="name"><span class="text-danger">*</span>類別名稱</label>
                            <input type="text" class="form-control form-control-user" name="name" id="name" value="{{ $category->name }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="subname"><span class="text-danger">*</span>子類別名稱</label>
                            <input type="text" class="form-control form-control-user" name="subname" id="subname" value="{{ $category->subname }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="checkbox" name="show_popular" id="show_popular" @if($category->show_popular) checked @endif>
                            <label for="show_popular">是否顯示熱門商品</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row float-right">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <span class="text">修改</span>
                        </button>
                        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">
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