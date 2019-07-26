@extends('back.layouts.main')

@section('title', 'Shop Admin')

@section('extra_meta')
<!-- provide the csrf token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('nav_order', 'active')

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

    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">訂單管理</h6>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                    <button type="button" class="btn btn-primary" id="cancel" data-url="{{ route('admin.order') }}">
                        <span class="text">取消</span>
                    </button>
                    <button type="button" class="btn btn-primary" id="shipped" data-url="{{ route('admin.order') }}">
                        <span class="text">已出貨</span>
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="order_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="2%"></th>
                            <th width="12%">訂單編號</th>
                            <th width="13%">訂購日期</th>
                            <th width="15%">收件人姓名</th>
                            <th width="15%">收件人電話</th>
                            <th width="20%">收件人地址</th>
                            <th width="10%">狀態</th>
                            <th width="13%"></th>
                        </tr>
                    </thead>
                    
                </table>
            </div>
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
    $(document).ready(function() {
        // set cancel to all checked order
        $('#cancel').on('click', function() {
            // get all checked order's id
            var order = $('input[name="order[]"]:checked').map(function() {
                return $(this).val();
            }).get();
            var url = $(this).attr("data-url");
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.postJSON(url, { _token : CSRF_TOKEN , order : order , action : 'cancel' }, function(data) {
                location.reload();
            })
            return false;
        });

        // set shipped to all checked order
        $('#shipped').on('click', function() {
            // get all checked order's id
            var order = $('input[name="order[]"]:checked').map(function() {
                return $(this).val();
            }).get();
            var url = $(this).attr("data-url");
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.postJSON(url, { _token : CSRF_TOKEN , order : order , action : 'shipped' }, function(data) {
                location.reload();
            })
            return false;
        });

        $('#order_table').DataTable({
            "order": [[1, 'asc']],
            "columnDefs": [
                { "orderable": false, "targets": [0, 7] },
                { "className": "align-middle", "targets": "_all" },
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
            "searching": false,
            "bLengthChange": false,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.order') }}",
            "columns": [
                {
                    data: 'oid',
                    name: 'oid',
                    orderable: false,
                    searchable: false,
                    "render": function (data) {
                        return '<input type="checkbox" name="order[]" value="' + data + '">'
                    }
                },
                {data: 'oid', name: 'oid', searchable: false},
                {data: 'created_at', name: 'created_at', searchable: false},
                {data: 'recipient_name', name: 'recipient_name', searchable: false},
                {data: 'recipient_tel', name: 'recipient_tel', searchable: false},
                {data: 'recipient_add', name: 'recipient_add', searchable: false},
                {
                    data: 'status',
                    name: 'status',
                    searchable: false,
                    "render": function(data) {
                        switch(data) {
                            case 'pending':
                                return '處理中';
                            case 'shipped':
                                return '已出貨';
                            case 'cancel':
                                return '取消';
                            default:
                                return '未知';
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    "render": function (data) {
                        return '<a href="/admin/order/' + data + '" class="btn btn-primary"><span class="text">訂單明細</span></a>';
                    }
                }
            ]
        });
    });
</script>
@endsection