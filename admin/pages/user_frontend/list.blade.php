@extends('admin.layouts.main')
@section('title', 'danh sach nhân viên')

@section('css')
    <link rel="stylesheet" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">

        @include('admin.partials.content-header',['name'=>" Admin User","key"=>"Danh sách thành viên"])

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('alert'))
                            <div class="alert alert-success">
                                {{ session('alert') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-warning">
                                {{ session('error') }}
                            </div>
                        @endif
                        <a href="{{ route('admin.user_frontend.create') }}" class="btn  btn-info btn-md mb-2">+ Thêm
                            mới</a>
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <div class="card-tools w-100 mb-3">
                                    {{-- action="{{ route('admin.user_frontend.index') }}" --}}
                                    <form action="{{ route('admin.user_frontend.index')}}" method="GET">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="form-group col-md-3 mb-0">
                                                        <input id="keyword" value="{{ $keyword }}" name="keyword"
                                                            type="text" class="form-control keyword" placeholder="Từ khóa">
                                                        <div id="keyword_feedback" class="invalid-feedback">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                        <select id="order" name="order_with" class="form-control order_with">
                                                            <option value="">-- Sắp xếp theo --</option>
                                                            <option value="dateASC"
                                                                {{ $order_with == 'dateASC' ? 'selected' : '' }}>Ngày tạo
                                                                tăng
                                                                dần</option>
                                                            <option value="dateDESC"
                                                                {{ $order_with == 'dateDESC' ? 'selected' : '' }}>Ngày tạo
                                                                giảm
                                                                dần</option>
                                                            <option value="usernameASC"
                                                                {{ $order_with == 'usernameASC' ? 'selected' : '' }}>
                                                                Username
                                                                A-> Z</option>
                                                            <option value="usernameDESC"
                                                                {{ $order_with == 'usernameDESC' ? 'selected' : '' }}>
                                                                Username
                                                                Z -> A</option>
                                                            <option value="activeDESC"
                                                                {{ $order_with == 'activeDESC' ? 'selected' : '' }}>Trạng
                                                                thái
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                        <select id="" name="date_payment" class="form-control date_payment">
                                                            <option value="">-- Lọc theo ngày trong tuần --</option>
                                                            <option value="Thứ 2">Thứ 2</option>
                                                            <option value="Thứ 3">Thứ 3</option>
                                                            <option value="Thứ 4">Thứ 4</option>
                                                            <option value="Thứ 5">Thứ 5</option>
                                                            <option value="Thứ 6">Thứ 6</option>
                                                            <option value="Thứ 7">Thứ 7</option>
                                                            <option value="Chủ nhật">Chủ nhật</option>
                                                        </select>
                                                    </div>
                                                    {{-- <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                <select id="" name="fill_action" class="form-control">
                                                    <option value="">-- Lọc --</option>
                                                    <option value="userNoActive" {{ $fill_action=='userNoActive'? 'selected':'' }}>Thành viên chưa kích hoạt</option>
                                                    <option value="userActive" {{ $fill_action=='userActive'? 'selected':'' }}>Thành viên đã kích hoạt</option>
                                                    <option value="userActiveKey" {{ $fill_action=='userActiveKey'? 'selected':'' }}>Thành viên bị khóa</option>
                                                </select>
                                            </div> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-1 mb-0">
                                                <button type="submit" class="btn btn-success w-100" id="btn-search">Search</button>
                                            </div>
                                            <div class="col-md-1 mb-0">
                                                <a class="btn btn-danger w-100"
                                                    href="{{ route('admin.user_frontend.index') }}">Reset</a>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                            <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                                <div class="count">
                                    Tổng số bản ghi <strong>{{ $users->count() }}</strong> / {{ $totalUser }}
                                </div>
                            </div>

                            <div class="card-body table-responsive p-0 lb-list-category">
                                <table class="table table-head-fixed" style="font-size:13px;">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="check_all"></th>
                                            <th>Mã KH</th>
                                            <th>Tài khoản</th>
                                            <th>Họ và tên</th>
                                            <th>Email</th>
                                            <th>TKNH</th>
                                            <th>Công nợ</th>
                                            <th>Phí ship</th>
                                            <th>Hoàn tiền</th>
                                            <th>Ngày thanh toán</th>
                                            {{-- <th>Ghi chú</th> --}}
                                            <th >Hoạt động
                                                <span style="float: right">
                                                    <button class="btn btn-danger btn-xs delete-all" data-url=""><i class="far fa-trash-alt"></i></button>
                                                </span>
                                            </th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                        {{-- {{dd($item->order)}} --}}
                                            <tr>
                                                <td><input type="checkbox" class="checkbox" data-id="{{$item->id}}"></td>
                                                <td>TA_{{ $item->id }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td><a
                                                        href="{{ route('admin.user_frontend.detail', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                                </td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->stk }}</td>
                                                <td>{{ number_format($caculatorDebt[$key]) }}đ</td>
                                                <td>{{ number_format($caculatorShip[$key]) }}đ</td>
                                                <td>{{ number_format($caculatorRefund[$key]) }}đ</td>
                                                
                                                <td>{{ $item->date_payment }}</td>
                                                {{-- <td>{{ $item->points()->where(['type' => 1])->select(\App\Models\Point::raw('SUM(point) as total'))->first()->total }}
                                                </td> --}}
                                                {{-- @if(isset($item['points']))
                                                <td>
                                                @foreach($item['points'] as $value)
                                                    <p>{{$value->note}}</p>
                                                @endforeach
                                                @endif --}}
                                                <style>
                                                    .td a.btn{
                                                        margin-right: 5px;
                                                    }
                                                </style>
                                                <td style="width: 215px;display: flex;align-items: center;justify-content: right">
                                                    <a class="btn btn-sm btn-info" id="btn-load-transaction-detail"
                                                        data-url="{{ route('admin.user_frontend.loadUserDetail', ['id' => $item->id]) }}"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('admin.user_frontend.edit', ['id' => $item->id]) }}"><i
                                                            class="fas fa-edit"></i></a>
                                                    <a class="btn btn-sm btn-danger"
                                                        href="{{ route('admin.user_frontend.detail', ['id' => $item->id]) }}">Thanh toán</a>
                                                    <a data-url="{{route('admin.user_frontend.destroy',['id'=>$item->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-2 mb-3">
                                <div class="col-md-7 mt-3 pl-3">
                                    <div id="dataTable_info" role="status" aria-live="polite" class="dataTables_info">
                                        Show：{{ $users->firstItem() }} / {{ $users->lastItem() }} | Total:
                                        {{ $users->total() }}
                                    </div>
                                </div>
                                <div class="col-md-5 text-center pr-3">
                                    <div class="d-inline-block float-right">
                                        {{ $users->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="transactionDetail">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin chi tiết thành viên</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="content" id="loadTransactionDetail">

                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    {{-- <script src="{{asset('')}}"></script> --}}
    <script src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin_asset/ajax/deleteAdminAjax.js') }}"></script>
    <script>
        $(function() {
            $(document).on('click', '#btnTranferPoint', function() {
                event.preventDefault();
                let urlRequest = $(this).data("url");
                let title = '';
                title = 'Bạn có chắc chắn muốn bắn điểm';
                $this = $(this);
                Swal.fire({
                    title: title,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, next step!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: urlRequest,
                            success: function(data) {
                                if (data.code == 200) {
                                    $this.text('Đã bắn');
                                    $this.removeClass('btn-danger').addClass(
                                        'btn-info');
                                } else {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'warning',
                                        title: 'Bắn điểm không thành công',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#btnKeyUser', function() {
                event.preventDefault();
                let urlRequest = $(this).data("url");
                let title = '';

                let $this = $(this);
                if ($this.hasClass('key')) {
                    title = 'Bạn có chắc chắn muốn mở khóa thành viên';
                } else {
                    title = 'Bạn có chắc chắn muốn khóa thành viên';

                }

                let loadActive = $(this).parents('tr').find('.wrap-load-active');
                Swal.fire({
                    title: title,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, next step!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: urlRequest,
                            success: function(data) {
                                if (data.code == 200) {
                                    loadActive.html(data.html);

                                    if ($this.hasClass('key')) {
                                        $this.removeClass('key');
                                        $this.text('Khóa user');
                                    } else {
                                        $this.addClass('key');
                                        $this.text('Mở khóa');
                                    }
                                } else {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'warning',
                                        title: data.title,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            },
                            error: function(data) {

                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: "Khóa không thành công",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#check_all').on('click', function(e) {
        if($(this).is(':checked',true))  
        {
            $(".checkbox").prop('checked', true);  
            } else {  
            $(".checkbox").prop('checked',false);  
        }  
    });

    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#check_all').prop('checked',true);
            }else{
            $('#check_all').prop('checked',false);
        }
    });

    $('.delete-all').on('click', function(e) {
        var idsArr = [];  
        $(".checkbox:checked").each(function() {  
        idsArr.push($(this).attr('data-id'));
        console.log(idsArr);
    });  

    if(idsArr.length <=0)  {  
        alert("Vui lòng chọn ít nhất một bản ghi để xóa.");  
    }  else {  
            if(confirm("Bạn có chắc chắn không, bạn muốn xóa các danh mục đã chọn?")){  
                var strIds = idsArr.join(","); 
                $.ajax({
                url: "{{ route('user-frontend.multiple-delete') }}",
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: 'ids='+strIds,
                success: function (data) {
                    if (data['status']==true) {
                        $(".checkbox:checked").each(function() {  
                        $(this).parents("tr").remove();
                });
                alert(data['message']);
            } else {
                alert('Rất tiếc, đã xảy ra lỗi!!');
            }
        },
            error: function (data) {
                alert(data.responseText);
            }
        });
            }  
        }  
    });
    // $('[data-toggle=confirmation]').confirmation({
    //     rootSelector: '[data-toggle=confirmation]',
    //     onConfirm: function (event, element) {
    //     element.closest('form').submit();
    // }
    // });   
    });
    </script>

    {{-- <script>
         $(document).ready(function () {
            $( "#btn-search" ).click(function() {
                var keyword = $('.keyword').val();
                var order_with = $('.order_with').val();
                var date_payment = $('.date_payment').val();

                // alert(order_with);

                $.ajax({
                    url : "{{route('admin.user_frontend.filter_ajax')}}",
                    method : "POST",

                    data : {keyword : keyword,order_with : order_with,date_payment : date_payment},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success : function(data){
                    $('#filter_ajax').fadeIn();
                        $('#filter_ajax').html(data);
                    }
                });
                

                
            });
        });
    </script> --}}

@endsection
