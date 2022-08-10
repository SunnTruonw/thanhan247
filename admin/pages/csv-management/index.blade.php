@php
use App\Models\Condition\Condition;
use App\Models\OrderManagement\OrderManagement;
@endphp

@extends('admin.layouts.main')

@section('title', 'Danh sách csv')

@section('content')
<style>
    .table td, .table th{
        font-size: 12px;
    }
</style>
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>"csv","key"=>"Danh sách csv"])
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    {{-- @isset($conditions)
                        <div class="col-sm-12">
                            <div class="list-count">
                                <div class="row">
                                    @foreach ($conditions as $condition)
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-{{ $condition->color }}"><i
                                                        class="fas fa-calculator"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">{{ $condition->name }} </span>
                                                    <span
                                                        class="info-box-number"><strong>{{ $condition->order ? $condition->order->count('condition_id') : 0 }}</strong>
                                                        / tổng số {{ $total }}</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endisset --}}

                    <div class="col-sm-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Danh sách đơn hàng</h3>
                            </div>
                            <div class="card-tools w-60">
                                <form action="{{ route('admin.csv-management.index') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                
                                                <div class="form-group col-md-2 mb-0">
                                                    <input id="end_date" name="end_date" type="date"
                                                        class="form-control" placeholder="mm/dd/yyyy"
                                                        value="{{ request('end_date') }}">
                                                </div>
                                                <div class="form-group col-md-2 mb-0">
                                                    <input id="customer_name" name="customer_name" type="text"
                                                        class="form-control" placeholder="Tài khoản"
                                                        value="{{ request('customer_name') }}">
                                                </div>

                                                <div class="form-group col-md-4 mb-0" style="min-width:100px;">
                                                    <select id="status" name="status" class="form-control">
                                                        <option value="">Tình trang </option>
                                                        @foreach ($listStatus as $status)
                                                        <option value="{{ $status['status'] }}" {{ $status['status']==$statusCurrent? 'selected':'' }}> {{ $status['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-2 text-center">
                                                    <button type="submit" class="btn btn-success">Tìm kiếm</button>
                                                    <a href="{{ route('admin.csv-management.index') }}"
                                                        class="btn btn-danger">Hủy bỏ</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="text-nowrap">Tài khoản KH</th>
                                            <th class="text-nowrap">Địa chỉ</th>
                                            <th class="text-nowrap">Trạng thái</th>
                                            <th class="text-nowrap" >Hoạt động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {{dd($orders)}} --}}
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{$order->id}}</td>
                                                <td class="id">{{ $order->users->username }}</td>
                                                {{-- <td class="text-nowrap"><a data-toggle="collapse" href="#collapseExample{{$order->id}}" role="button" aria-expanded="false" aria-controls="collapseExample{{$order->id}}">{{ substr_replace($order->users->address, "...", 300) }}</a>
                                                    <div class="collapse" id="collapseExample{{$order->id}}">
                                                        <div class="card card-body">
                                                          {{$order->users->address}}
                                                        </div>
                                                    </div>
                                                </td>  --}}
                                                <td class="text-nowrap">
                                                    {{$order->users->address}}
                                                </td> 
                                                <td class="text-nowrap status-2" data-url="{{ route('admin.csv-management.update',['id'=>$order->id]) }}">
                                                    @include('admin.components.status-2',[
                                                        'dataStatus' => $order,
                                                        'listStatus'=>$listStatus,
                                                    ])
                                                 </td>
                                                <td class="text-nowrap">
                                                    {{-- <a class="btn btn-sm btn-info" id="btn-load-transaction-detail"
                                                        href="{{ route('admin.csv-management.show', ['id' => $order->id]) }}"><i
                                                            class="fas fa-eye"></i></a> --}}
                                                        <a data-url="{{route('csv_management.delete.csv.product',['id'=>$order->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i>
                                                        </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-7 mt-3 pl-3">
                                    <div id="dataTable_info" role="status" aria-live="polite" class="dataTables_info">
                                        Show：{{ $orders->firstItem() }} / {{ $orders->lastItem() }}
                                    </div>
                                </div>
                                <div class="col-md-5 text-center pr-3">
                                    <div class="d-inline-block float-right">
                                        {{ $orders->links() }}
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
    {{-- delete item --}}
    <div class="modal fade" id="deleteItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" id="deleteItemAction" class="form-submit">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteItemText">Xóa đơn hàng</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0" id="deleteItemMessage">sau khi xóa đơn hàng bạn không thể khôi phục nó.
                            Vẫn xóa?</span>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center col-12">
                            <button class="btn btn-secondary btn-sm " type="button" data-dismiss="modal">Hủy bỏ</button>
                            <button class="btn btn-danger btn-sm btn-submit" type="submit">Xóa</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

   
@endsection
@section('js')
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
        alert("Vui lòng chọn ít nhất một bản ghi để chuyển đổi.");  
    }  else {  
            if(confirm("Bạn có chắc chắn không, bạn muốn chuyển đổi các bản ghi đã chọn?")){  
                //var strIds = idsArr.join(","); 
                var condition_id = $('#condition_id').val();
                // 'ids='+strIds

                //console.log('ids='+strIds);

                $.ajax({
                url: "{{ route('multiple_order_delete') }}",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {idsArr:idsArr, condition_id : condition_id} ,
                success: function (data) {
                    // console.log(data);
                    if (data['status']==true) {
                            $(".checkbox:checked").each(function() {  
                            // $(this).parents("tr").remove();
                            $('input[type=checkbox]').prop('checked', false);
                            location.reload();
                            
                            // $(this).parents("tr").reset();
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
    <script>
        $('.btnDelete1').click(function(e) {
            $('#deleteItemAction').attr('action', $(this).attr('data-action'));
            $($(this).attr('data-target')).modal('show');
        })

        $('.btnChangeShipper').click(function(e) {
            $('#changeShipperAction').attr('action', $(this).attr('data-action'));
            $($(this).attr('data-target')).modal('show');
        })

        $('.btnChangeCondition').click(function(e) {
            $('#changeConditionAction').attr('action', $(this).attr('data-action'));
            $('#conditionId').val($(this).attr('data-value')).change();
            $($(this).attr('data-target')).modal('show');
        })

        $('.btnChangeDeft').click(function(e) {
            $('#changeDebtAction').attr('action', $(this).attr('data-action'));
            $($(this).attr('data-target')).modal('show');
        })

        $('.btnChangeRefund').click(function(e) {
            $('#changeRefundAction').attr('action', $(this).attr('data-action'));
            $($(this).attr('data-target')).modal('show');
        })

        $("#start_date, #end_date").on('keydown keyup', function (e) {
            return false;
        });
        if ($("#start_date").val().length > 0) {
            $("#end_date").attr("min", $("#start_date").val());
        }
        $("#start_date").change(function() {
            $("#end_date").attr("min", $("#start_date").val());
        });
        if ($("#end_date").val().length > 0) {
            $("#start_date").attr("max", $("#end_date").val());
        }
        $("#end_date").change(function() {
            $("#start_date").attr("max", $("#end_date").val());
        });

        $(document).on('change','.select_change', function() {
            let value = $(this).val();
            if(value == 6 || value == 7 || value == 5){
                $("#ghi_chu").html('<input type="text" class="form-control" name="note2" placeholder="Ghi chú..." />');
            }
            else{
                $("#ghi_chu").text('');
            }
            
        });
    </script>
@endsection
