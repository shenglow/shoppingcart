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
            <h6 class="m-0 font-weight-bold text-primary">常見問題 - 新增問答</h6>
        </div>
        <div class="card-body">
            <form method='POST' action="{{ route('admin.faq.store') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="question"><span class="text-danger">*</span>問題</label>
                            <textarea class="form-control form-control-user" name="question" id="question" rows="4">{{ old('question') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="answer"><span class="text-danger">*</span>答案</label>
                            <textarea class="form-control form-control-user" name="answer" id="answer" rows="4">{{ old('answer') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="checkbox" name="status" id="status" @if(old('status')) checked @endif>
                            <label for="status">是否顯示</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">新增問答</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection