@extends('back.layouts.main')

@section('title', 'Shop Admin')

@section('nav_product', 'active')

@section('custom_css')
<!-- Custom styles for this page -->
<link href="{{ asset('back/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

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
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-icon-split mb-3">
                <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
                </span>
                <span class="text">新增商品</span>
            </a>
            @if (count($products) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="product_table" width="100%" cellspacing="0">
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
                                        <td class="align-middle">{{ $product->name }}</td>
                                        <td class="align-middle">{{ $product_list->name }}</td>
                                        <td class="align-middle">{{ $product_list->subname }}</td>
                                        <td class="align-middle">${{ number_format($product->price) }}</td>
                                        <td class="align-middle">
                                            <a href="{{ route('admin.product.edit', $product->pid) }}" class="btn btn-primary">
                                                <span class="text">編輯</span>
                                            </a>
                                            @if ($product->is_enable)
                                                <a href="{{ route('admin.product.changestatus', [$product->pid, 0]) }}" class="btn btn-danger">
                                                    <span class="text">下架</span>
                                                </a>
                                            @else
                                                <a href="{{ route('admin.product.changestatus', [$product->pid, !$product->is_enable]) }}" class="btn btn-success">
                                                    <span class="text">上架</span>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ asset('back/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('back/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    //dynamic change select's item
    $(document).ready(function() {
        $('#product_table').DataTable({
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ],
            "language": {
                "decimal":        "",
                "emptyTable":     "查無資料",
                "info":           "顯示 _START_ 至 _END_ 項結果, 共 _TOTAL_ 項",
                "infoEmpty":      "顯示 0 至 0 項結果, 共 0 項",
                "infoFiltered":   "(從 _MAX_ 項結果中過濾)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "顯示 _MENU_ 項結果",
                "loadingRecords": "載入中...",
                "processing":     "處理中...",
                "search":         "搜尋:",
                "zeroRecords":    "查無符合的項目",
                "paginate": {
                    "next":       "下一頁",
                    "previous":   "上一頁"
                }
            },
        });
    });
</script>
@endsection