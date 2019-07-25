@extends('back.layouts.main')

@section('title', 'Shop Admin')

@section('nav_category', 'active')

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
                    <table class="table table-bordered text-center" id="category_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>類別名稱</th>
                                <th>子類別名稱</th>
                                <th>顯示熱門商品</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="align-middle">{{ $category->name }}</td>
                                    <td class="align-middle">{{ $category->subname }}</td>
                                    @if ($category->show_popular)
                                        <td class="text-success align-middle">啟用</td>
                                    @else 
                                        <td class="text-danger align-middle">停用</td>
                                    @endif
                                    <td class="align-middle">
                                        <a href="{{ route('admin.category.edit', $category->cid) }}" class="btn btn-primary">
                                            <span class="text">編輯</span>
                                        </a>
                                        <form method="POST" action="{{ route('admin.category.destroy', $category->cid) }}" class="d-inline-block">
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
// Call the dataTables jQuery plugin
$(document).ready(function() {
    $('#category_table').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": 3 }
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
        }
    });
});
</script>
@endsection