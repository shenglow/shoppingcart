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
            <h6 class="m-0 font-weight-bold text-primary">商品管理</h6>
        </div>
        <div class="card-body">
            <form method='GET' action="{{ route('admin.product.index') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="c_name">類別</label>
                            <select class="form-control" name="c_name" id="c_name">
                                <option></option>
                                @foreach($categories as $key => $category)
                                    <option @if($c_name == $key) selected @endif>{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="c_subname">子類別</label>
                            <select class="form-control" name="c_subname" id="c_subname">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary btn-icon-split" id="search">
                            <span class="icon text-white-50">
                            <i class="fas fa-search"></i>
                            </span>
                            <span class="text">查詢</span>
                        </button>
                        <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">新增商品</span>
                        </a>
                    </div>
                </div>
            </form>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered text-center" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">名稱</th>
                            <th width="20%">類別</th>
                            <th width="20%">子類別</th>
                            <th width="10%">價格</th>
                            <th width="20%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product_list)
                            @foreach ($product_list['products'] as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product_list->name }}</td>
                                    <td>{{ $product_list->subname }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        <a href="{{ route('admin.product.edit', $product->pid) }}" class="btn btn-primary">
                                            <span class="text">編輯</span>
                                        </a>
                                        <a href="{{ route('admin.product.destroy', $product->pid) }}" class="btn btn-danger">
                                            <span class="text">刪除</span>
                                        </a>
                                        <a href="#" class="btn btn-danger">
                                            <span class="text">下架</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection

@section('custom_script')
<script>
    //dynamic change select's item
    $(document).ready(function() {

        // category list
        let category = {!! json_encode($categories) !!};
        @if (!empty($c_subname))
        let c_subname = '{!! $c_subname !!}';
        @endif

        if ($("#c_name").val() !== '') {
            var value = $("#c_name").val();
            var subselect = $("#c_subname");

            subselect.empty();
            $("<option />").html('').appendTo(subselect);

            $.each(category[value], function() {
                if (this.subname == c_subname) {
                    $("<option />")
                    .attr("value", this.cid)
                    .attr("selected", '')
                    .html(this.subname)
                    .appendTo(subselect);
                } else {
                    $("<option />")
                    .attr("value", this.cid)
                    .html(this.subname)
                    .appendTo(subselect);
                }
            });
        }
    
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
    });

    // redirect with variable
    $('#search').click(function() {
        window.location = "{{ route('admin.product.index') }}" + '/' + $('#c_name option:selected').text() + '/' + $('#c_subname option:selected').text();
    });
</script>
@endsection