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
            <h6 class="m-0 font-weight-bold text-primary">類別設定</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-icon-split mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">新增商品類別</span>
            </a>
            @if (count($categories) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>類別名稱</th>
                                <th>子類別名稱</th>
                                <th class="text-center">顯示熱門商品</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->subname }}</td>
                                    @if ($category->show_popular)
                                        <td class="text-center text-success">啟用</td>
                                    @else 
                                        <td class="text-center text-danger">停用</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No category</p>
            @endif
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection