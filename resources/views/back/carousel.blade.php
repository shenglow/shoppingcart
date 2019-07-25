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
            <h6 class="m-0 font-weight-bold text-primary">輪播設定</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('admin.carousel.create') }}" class="btn btn-primary btn-icon-split mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">新增輪播內容</span>
            </a>
            @if (count($carousels) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered text-center" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="40%">照片</th>
                                <th width="30%">網址</th>
                                <th width="10%">狀態</th>
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carousels as $carousel)
                                <tr>
                                    <td><img src="{{ asset($carousel->image) }}" alt="Carousel" class="img-thumbnail"></td>
                                    <td class="align-middle">{{ $carousel->href }}</td>
                                    @if ($carousel->status)
                                        <td class="text-success align-middle">顯示</td>
                                    @else 
                                        <td class="text-danger align-middle">隱藏</td>
                                    @endif
                                    <td class="align-middle">
                                        <a href="{{ route('admin.carousel.edit', $carousel->carousel_id) }}" class="btn btn-primary">
                                            <span class="text">編輯</span>
                                        </a>
                                        <form method="POST" action="{{ route('admin.carousel.destroy', $carousel->carousel_id) }}" class="d-inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger">
                                                <span class="text">刪除</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>查無資料</p>
            @endif
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection