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
            <h6 class="m-0 font-weight-bold text-primary">常見問題 - 修改問答</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.faq.update', $faq->fid) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="question"><span class="text-danger">*</span>問題</label>
                            <textarea class="form-control form-control-user" name="question" id="question" rows="4">{{ $faq->question }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="answer"><span class="text-danger">*</span>答案</label>
                            <textarea class="form-control form-control-user" name="answer" id="answer" rows="4">{{ $faq->answer }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="checkbox" name="status" id="status" @if($faq->status) checked @endif>
                            <label for="status">是否顯示</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row float-right">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <span class="text">修改</span>
                        </button>
                        <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary">
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