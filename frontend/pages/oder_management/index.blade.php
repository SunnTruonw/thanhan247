@extends('frontend.layouts.main-profile')
@section('css')
<style>
    .box {
        padding-right: 0px;
        width: 134px;
    }
    .table-responsive {
        font-size: 13px;
    }
    .form-control {
        font-size: 14px;
    }

    .info-box {
        box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
        border-radius: 0.25rem;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 1rem;
        min-height: 30px;
        padding: 0.5rem;
        position: relative;
        width: 100%;
    }

    div.scroll-condition {
        overflow: auto;
        white-space: nowrap;
    }

    div.scroll-condition div {
        display: inline-block;
        color: white;
        font-size: 14px;
        text-align: center;
        text-decoration: none;
        margin: 0;
        padding: 3px 0;
        box-shadow: unset;
    }
    .taodonhang {
        background: #f49624;
        border-radius:5px;
        display: inline-block;
        color: #fff;
        padding: 5px 20px;
    }

    .wrap-btn-total{
        display: flex;
        flex-wrap: wrap;
    }

    .btn-total {
        border-radius: 5px;
        display: inline-block;
        color: #fff;
        padding: 5px 20px;
        flex: 1 1 45%;
    }

    .mtM-5{
        margin: 5px;
    }

    .btn-total a{
        color: #fff !important;
    }
    
    .taodonhang a {
        color: #fff !important;
    }
    .titlequanly {
        color: #333;
        text-align: left;
        text-transform: uppercase;
        font-size: 18px;
        line-height: 40px;
        margin: 0;
    }
    .btn-success {
        background: #8a5e3b;
        border: #8a5e3b;
        font-size: 14px;
        padding: 6px 25px;
    }
    .btn-danger {
        font-size: 14px;
        padding: 6px 25px;
    }
    #dataTable_info {
        font-size: 14px;
    }
</style>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-9">
                    <h6 class="titlequanly">Quản lý đơn hàng</h6>
                    <div class="wrap-btn-total">
                        <div class="btn-total total-root bg-danger mtM-5">
                            <a class="text-decoration-none ">
                                Tổng: {{number_format($totalRoot)}} đ/tổng số {{$totalSingle}}
                            </a>
                        </div>

                        <div class="btn-total total-root bg-info mtM-5">
                            <a class="text-decoration-none ">
                                Tổng ship: {{number_format($totalShip)}} đ/tổng số {{$totalSingle}}
                            </a>
                        </div>
    
                        <div class="btn-total total-payed bg-success mtM-5">
                            <a class="text-decoration-none ">
                                Đã thanh toán: {{number_format($totalThanhToan)}} đ/tổng số {{$totalSingle}}
                            </a>
                        </div>
    
                        <div class="btn-total total-no bg-primary mtM-5">
                            <a class="text-decoration-none">
                                Còn nợ: {{number_format($totalRoot - $totalThanhToan)}} đ/tổng số {{$totalSingle}}
                            </a>
                        </div>

                        
                    </div>
                </div>
                <div class="col-3 text-right">
					<div class="taodonhang">
						<a href="{{ route('order_management.create') }}" class="text-decoration-none text-success ">
							<i class="fas fa-plus-square"></i>
							{{ __('order_management.create_order.title') }}
						</a>
					</div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="scroll-condition mb-4">
                @foreach ($conditions as $condition)
                    <div class="box">
                        <div class="info-box bg-{{ $condition->color }}">
                            <div class="info-box-content">
                                <span class="info-box-text">{{ $condition->name }}
                                </span>
                                @if ($totalOrderForCondition)
                                    @foreach ($totalOrderForCondition as $totalOrder)
                                        @if ($totalOrder->condition_id === $condition->id)
                                            <span
                                                class="info-box-number"><strong>{{ $totalOrder->total }}</strong></span>
                                        @endif
                                    @endforeach
                                @else
                                    <span>0</span>
                                @endif
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div id="dataTable_filter" class="text-start">
                        <form action="{{ route('order_management.index') }}" method="GET" id="form-search">
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                            <input name="search" type="text" class="form-control" placeholder="Từ khóa"
                                                value="{{ request('search') }}">
                                        </div>
                                        <div class="form-group col-md-2 mb-0">
                                            <input type="date" class="form-control @error('start') is-invalid  @enderror"
                                                placeholder="Từ ngày" id="" name="start" value="{{ $start ?? '' }}">
                                            @error('start')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                              
                                        <div class="form-group col-md-2 mb-0">

                                            <input type="date" class="form-control @error('end') is-invalid  @enderror"
                                                placeholder="Đến ngày" id="" name="end" value="{{ $end }}">
                                            @error('end')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                            <input id="id" name="id" type="text" class="form-control" placeholder="ID"
                                                value="{{ request('id') }}">
                                        </div>
                                        <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                            <select id="condition_id" name="condition_id" class="form-control">
                                                <option value="">Tình trang đơn hàng</option>
                                                @foreach ($conditions as $condition)
                                                    <option value="{{ $condition->id }}" @if (!empty(request('condition_id')))
                                                        {{ request('condition_id') == $condition->id ? ($selected = 'selected') : '' }}
                                                @endif
                                                >
                                                {{ $condition->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3 text-right">
                                    <button type="submit" class="btn btn-success">Tìm kiếm</button>
                                    <a href="{{ route('order_management.index') }}" class="btn btn-danger">Hủy bỏ</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('order_management.id') }}</th>
                            <th class="text-nowrap">{{ __('order_management.order_code') }}</th>
                            <th class="text-nowrap">Ngày tạo đơn</th>
                            <th class="text-nowrap">{{ __('order_management.customer_name') }}</th>
                            <th class="text-nowrap">{{ __('order_management.address') }}</th>
                            <th class="text-nowrap">{{ __('order_management.real_money') }}</th>
                            <th class="text-nowrap">{{ __('order_management.shipping_fee') }}</th>
                            <th class="text-nowrap">{{ __('order_management.total_money') }}</th>

                            <th class="text-nowrap">{{ __('order_management.condition') }}</th>
                            <th class="text-nowrap">{{ __('order_management.refund') }}</th>
                            <th class="text-nowrap">{{ __('order_management.note') }}</th>
                            <th class="text-nowrap">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td class="id">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->customer_address }}</td>
                                <td>{{ number_format($order->real_money) }}đ</td>

                                <td>{{ number_format($order->shipping_fee) }}đ</td>
                                <td>{{ number_format($order->total_money) }}đ</td>

                                <td> <span
                                        class="text text-{{ $order->condition->color }} bold">{{ $order->condition->name }}</span>
                                        @if($order->note2)
                                        <p style="font-size: 11px; color: red">({{$order->note2}})</p>
                                        @endif
                                </td>
                                <td> <span
                                        class="text text-{{ $order->refund == 0 ? 'danger' : 'success' }} bold">{{ $order->refund == 0 ? 'Chưa hoàn tiền' : 'Đã hoàn tiền' }}</span>
                                </td>
                                <td>{{ $order->note }}</td>
                                <td style="text-align: center">
                                    @if($order->condition->id == 1)
                                        <a data-url="{{route('order_management.delete.order.manage',['id'=>$order->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i>
                                        </a>
                                    @else
                                    
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mt-3">
                <div class="col-md-7 mt-3">
                    <div id="dataTable_info" role="status" aria-live="polite" class="dataTables_info">
                        Show：{{ $orders->firstItem() }} / {{ $orders->lastItem() }} | Total: {{ $total }}
                    </div>
                </div>
                <div class="col-md-5 text-center">
                    <div class="d-inline-block float-right">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script>
    $(document).on("click", ".lb_delete", actionDelete);

    function actionDelete(event) {

        event.preventDefault();
        let urlRequest = $(this).data("url");
        let mythis = $(this);
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa',
            text: "Bạn sẽ không thể khôi phục điều này",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {

                            mythis.parents("tr").remove();
                        }
                    },
                    error: function() {

                    }
                });
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
            }
        })
    }
</script>
@endsection
