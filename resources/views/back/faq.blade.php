@extends('back.layouts.main')

@section('title', 'Shop Admin')

@section('nav_faq', 'active')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    @if (session('msg'))
        <div class="alert {{ session()->get('msg')['type'] }}" role="alert">
            {{ session()->get('msg')['content'] }}
        </div>
    @endif

    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">常見問題</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('admin.faq.create') }}" class="btn btn-primary btn-icon-split mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">新增問題</span>
            </a>
            @if (count($faqs) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered text-center" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-left">問題</th>
                                <th>狀態</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqs as $faq)
                                <tr>
                                    <td class="text-left">{{ $faq->question }}</td>
                                    @if ($faq->status)
                                        <td class="text-success">顯示</td>
                                    @else 
                                        <td class="text-danger">隱藏</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('admin.faq.edit', $faq->fid) }}" class="btn btn-primary">
                                            <span class="text">編輯</span>
                                        </a>
                                        <form method="POST" action="{{ route('admin.faq.destroy', $faq->fid) }}" class="d-inline-block">
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