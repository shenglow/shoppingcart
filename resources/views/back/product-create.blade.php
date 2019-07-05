@extends('back.layouts.main')

@section('title', 'Shop Admin')

@section('nav_product', 'active')

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
            <h6 class="m-0 font-weight-bold text-primary">商品管理 - 新增商品</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name"><span class="text-danger">*</span>名稱</label>
                            <input type="text" class="form-control form-control-user" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="price"><span class="text-danger">*</span>價格</label>
                            <input type="text" class="form-control form-control-user" name="price" id="price">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="c_name"><span class="text-danger">*</span>類別</label>
                            <select class="form-control" name="c_name" id="c_name">
                                <option></option>
                                @foreach($categories as $key => $category)
                                    <option>{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="c_subname"><span class="text-danger">*</span>子類別</label>
                            <select class="form-control" name="c_subname" id="c_subname">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row align-items-end">
                    <div class="col-6">
                        <div class="form-group">
                            <label>規格</label>
                            <input type="text" class="form-control form-control-user" name="specification[]">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>數量</label>
                            <input type="text" class="form-control form-control-user" name="quantity[]">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-icon-split" id="add_fields">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">新增</span>
                </button>
                <hr>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="description"><span class="text-danger">*</span>簡述</label>
                            <textarea class="form-control form-control-user" name="description" id="description" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="detail">詳細說明</label>
                            <textarea class="form-control form-control-user" name="detail" id="detail" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="image"><span class="text-danger">*</span>照片</label>
                            <input type="file" name="image[]" id="image" multiple>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row float-right">
                    <div class="col">
                        <button type="submit" class="btn btn-primary ">
                            <span class="text">新增</span>
                        </button>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
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

@section('custom_script')
<script>
    //dynamic change select's item
    let category = {!! json_encode($categories) !!};

    $("#c_name").change(function() {
        var value = $(this).val();
        var subselect = $("#c_subname");

        subselect.empty();
        $("<option />").html('').appendTo(subselect);

        $.each(category[value], function() {
            $("<option />")
            .attr("value", this.cid)
            .html(this.subname)
            .appendTo(subselect);
        });
    });

    //dynamic add spec fields
    $("#add_fields").click(function() {
        $(this).before('<div class="row align-items-end"><div class="col-6"><div class="form-group"><label>規格</label><input type="text" class="form-control form-control-user" name="specification[]"></div></div><div class="col-6"><div class="form-group"><label>數量</label><input type="text" class="form-control form-control-user" name="quantity[]"></div></div></div>');
    });

    
</script>
@endsection