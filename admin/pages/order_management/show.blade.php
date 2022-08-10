@extends('admin.layouts.main')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Chi tiết khách hàng</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th class="text-nowrap">Tên khách hàng</th>
                                            <th class="text-nowrap">Số điện thoại</th>
                                            <th class="text-nowrap">Địa chỉ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>{{ $order->customer_phone }}</td>
                                            <td>{{ $order->customer_address }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Chi tiết đơn hàng</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th class="text-nowrap">Mã đơn hàng</th>
                                            <th class="text-nowrap">Tiền cả COD</th>
                                            <th class="text-nowrap">Tổng phí ship</th>
                                            <th class="text-nowrap">Tiền gốc</th>
                                            <th class="text-nowrap">Tổng KL</th>
                                            <th class="text-nowrap">Chiều dài</th>
                                            <th class="text-nowrap">Chiều rộng</th>
                                            <th class="text-nowrap">Chiều cao</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-nowrap">{{ $order->order_code }}</td>
                                            <td class="text-nowrap">{{ number_format($order->total_money) }}</td>
                                            <td class="text-nowrap">{{ number_format($order->shipping_fee) }}</td>
                                            <td class="text-nowrap">{{ number_format($order->real_money) }}</td>
                                            <td class="text-nowrap">{{ $order->package_sum_mass }}</td>
                                            <td class="text-nowrap">{{ $order->package_long }}</td>
                                            <td class="text-nowrap">{{ $order->package_wide }}</td>
                                            <td class="text-nowrap">{{ $order->package_high }}</td>
                                            <td class="text-nowrap">
                                                <a href="{{route('admin.order_management.edit',['id'=>$order->id])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12 col-sm-12">
                                <h5 style="color: chocolate">Dịch vụ gia tăng</h5>
                            </div>
                            <div class="col-xs-12 col-sm-12">
                                <div class="item">
                                    <input type="checkbox" name="giao_hang1" @if($order->giao_hang1 == 1) checked @endif readonly>
                                    <label>Giao hàng 1 phần chọn SP</label>
                                </div>
                                <div class="item">
                                    <input type="checkbox" name="giao_hang2" @if($order->giao_hang2 == 1) checked @endif readonly>
                                    <label>Giao hàng 1 phần đổi trả hàng</label>
                                </div>
                                <div class="item">
                                    <input type="checkbox" name="khong_giao" @if($order->khong_giao == 1) checked @endif readonly>
                                    <label>Không giao được thu: 15.000đ</label>
                                </div>
                            </div>
                            
                            <!-- /.card-body -->
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Chi tiết sản phẩm</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="text-nowrap">Mã sản phẩm</th>
                                            <th class="text-nowrap">Tên sản phẩm</th>
                                            <th class="text-nowrap">Số lượng</th>
                                            <th class="text-nowrap">KL</th>
                                            <th class="text-nowrap">Mã đơn hàng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderDetail as $detail)
                                            <tr>
                                                <td>{{ $detail->id }}</td>
                                                <td>{{ $detail->product_code }}</td>
                                                <td>{{ $detail->product_title }}</td>
                                                <td>{{ $detail->product_qty }}</td>
                                                <td>{{ $detail->product_mass }}</td>
                                                <td>{{ $detail->order_code }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-7 mt-3 pl-3">
                                    <div id="dataTable_info" role="status" aria-live="polite" class="dataTables_info">
                                        {{-- Show：{{ $orders->firstItem() }} / {{ $orders->lastItem() }} | Total: {{ $total }} --}}
                                    </div>
                                </div>
                                <div class="col-md-5 text-center pr-3">
                                    <div class="d-inline-block float-right">
                                        {{-- {{ $orders->links() }} --}}
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
