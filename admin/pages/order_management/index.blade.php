@php
use App\Models\Condition\Condition;
use App\Models\OrderManagement\OrderManagement;
@endphp

@extends('admin.layouts.main')

@section('title', 'Danh sách đơn hàng')

@section('content')
<style>
    .table td, .table th{
        font-size: 12px;
        text-align: center;
    }
    .text-mr{
        margin-right: 4px;
    }

    .gioi-han{
        display: block;
    width: 130px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    }

    .form-flex{
        flex : 1 1 150px;
        padding: 0 5px;
    }

    .text-primary{
        cursor: pointer;
    }

    .alert-danger-cus{
        color:red;
        font-size: 14px;
    }

    
</style>
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>"Đơn hàng","key"=>"Danh sách đơn hàng"])
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @isset($conditions)
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
                                    <!-- Tổng tiền cod -->
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-danger"><i class="fas fa-calculator"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Tổng tiền cod</span>
                                                <span class="info-box-number"><strong>{{number_format($totalCode)}}đ</strong>
                                                    / tổng số {{$total}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tổng tiền cod -->

                                    <!-- Tổng tiền Shi[] -->
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-dark"><i class="fas fa-calculator"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Tổng tiền ship</span>
                                                <span class="info-box-number"><strong>{{number_format($totalShip)}}đ</strong>
                                                    / tổng số {{$total}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tổng tiền Shi[] -->

                                    <!-- Tổng tiền thu -->
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-success"><i class="fas fa-calculator"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Tổng tiền thu</span>
                                                <span class="info-box-number"><strong>{{number_format($totalRoot)}}đ</strong>
                                                    / tổng số {{$total}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tổng tiền thu -->

                                </div>
                            </div>
                        </div>
                    @endisset

                    <div class="col-sm-12">
                        <div class="card card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Danh sách đơn hàng</h3>
                            </div>
                            <div class="card-tools w-60">
                                <form action="{{ route('admin.order_management.index') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="form-group text-mr form-flex" >
                                                    <div style="display: flex">
                                                        <select id="condition_id" name="condition_id" class="form-control" style="flex : 1;">
                                                            <option value="">Tình trang đơn hàng</option>
                                                            @foreach ($conditions as $condition)
                                                                <option value="{{ $condition->id }}" @if (!empty(request('condition_id')))
                                                                    {{ request('condition_id') == $condition->id ? ($selected = 'selected') : '' }}
                                                            @endif
                                                            >
                                                            Đơn hàng {{ $condition->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <div>
                                                            <button type="button" class="btn btn-danger btn-xs delete-all" data-url="">Cập nhật</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group text-mr form-flex">
                                                    <input id="start_date" name="start_date" type="date"
                                                        class="form-control" placeholder="mm/dd/yyyy" 
                                                        value="{{ request('start_date') }}">
                                                </div>
                                                <div class="form-group text-mr form-flex">
                                                    <input id="end_date" name="end_date" type="date"
                                                        class="form-control" placeholder="mm/dd/yyyy"
                                                        value="{{ request('end_date') }}">
                                                </div>
                                                {{-- <div class="form-group text-mr form-flex">
                                                    <input id="customer_name" name="customer_name" type="text"
                                                        class="form-control" placeholder="Tài khoản"
                                                        value="{{ request('customer_name') }}">
                                                </div> --}}
                                                <div class="form-group text-mr form-flex">
                                                    <input id="total_money" name="total_money" type="text"
                                                        class="form-control" placeholder="Tổng tiền"
                                                        value="{{ request('total_money') }}">
                                                </div>
                                                <div class="form-group text-mr form-flex">
                                                    <input id="ship_name" name="ship_name" type="text"
                                                        class="form-control" placeholder="Tên shipper"
                                                        value="{{ request('ship_name') }}">
                                                </div>
                                                
                                                <div class="form-group text-mr form-flex" style="min-width:100px;">
                                                    <input id="user_id" name="user_id" type="text" class="form-control"
                                                        placeholder="Mã khách hàng" value="{{ request('user_id') }}">
                                                </div>

                                                <div class="form-group text-mr form-flex" style="min-width:100px;">
                                                    <input id="name_user" name="name_user" type="text" class="form-control"
                                                        placeholder="Tài khoản" value="{{ request('name_user') }}">
                                                </div>
                                                

                                                <div class="form-group text-mr form-flex" style="min-width:100px;">
                                                    <select id="condition_id" name="condition_id" class="form-control">
                                                        <option value="">Tình trạng</option>
                                                        @foreach ($conditions as $condition)
                                                            <option value="{{ $condition->id }}" @if (!empty(request('condition_id')))
                                                                {{ request('condition_id') == $condition->id ? ($selected = 'selected') : '' }}
                                                        @endif
                                                        >
                                                        Đơn hàng {{ $condition->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="text-mr text-center form-flex">
                                                    <button type="submit" class="btn btn-success">Tìm kiếm</button>
                                                    <a href="{{ route('admin.order_management.index') }}"
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
                                            <th style="display: flex;
                                            align-items: center;
                                            justify-content: center;"><input type="checkbox" id="check_all">
                                            </th>
                                            <th>ID</th>
                                            <th class="text-nowrap">Mã KH</th>
                                            <th class="text-nowrap">Mã ĐH</th>
                                            <th class="text-nowrap">Ngày tạo đơn</th>
                                            <th class="text-nowrap">Tiền COD</th>
                                            <th class="text-nowrap">Tiền Ship</th>
                                            <th class="text-nowrap">Tổng tiền</th>
                                            <th class="">Địa chỉ</th>
                                            <th class="text-nowrap">Tài khoản</th>
                                            <th class="text-nowrap">Trạng thái</th>
                                            <th class="text-nowrap">Người giao hàng</th>
                                            <th></th>
                                            <th class="text-nowrap">Trạng thái thu tiền</th>
                                            <th class="text-nowrap">Thanh toán phí ship</th>
                        
                                            
                                            <th class="text-nowrap">Thanh toán</th>
                                            <th class="text-nowrap">Hoàn tiền hàng</th>
                                            {{-- <th>Thời gian</th> --}}
                                            <th class="text-nowrap" >Hoạt động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {{dd($orders)}} --}}
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td><input type="checkbox" class="checkbox" data-id="{{$order->id}}"></td>
                                                <td class="id">{{ $order->id }}</td>
                                                <td class="id">TA_{{ $order->user ? $order->user->id : '' }}</td>
                                                <td class="id">{{ $order->order_code }}</td>
                                                <td class="id">{{ $order->created_at->format('d/m/Y') }}</td>

                                                <td class="text-nowrap text-primary changeTotalCode" data-id_action="{{ $order->id }}"
                                                    data-text="url" data-target="#changeTotalCode{{ $order->id }}" data-action="{{ route('admin.order_management.update.total-code', ['id' => $order->id]) }}">
                                                    {{ number_format($order->real_money) }} đ
                                                </td>

                                                {{-- update total code --}}
                                                <div class="modal fade" id="changeTotalCode{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form action="" method="POST" id="changeTotalCodeAction_{{$order->id}}" class="form-submit" id="form-code">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteItemText">Thay đổi tiền Cod</h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <label>Tiền Cod</label>
                                                                        <input type="text" class="form-control" id="totalCode" name="totalCode" value="{{floatval($order->real_money)}}">
                                                                        <div class="form-err" id="errorTotalCode" style="display: none;">
                                                                            <div class="alert alert-danger-cus alert-des ">
                                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                                                <span class="text-total-code-error">Số tiền không hợp lệ</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="text-center col-12">
                                                                        <button class="btn btn-secondary btn-sm " type="button" data-dismiss="modal">Hủy bỏ</button>
                                                                        <button class="btn btn-danger btn-sm btn-submit btn-code" type="submit">Xác nhận</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <td class="text-nowrap text-primary changeTotalShipper" data-id_action="{{ $order->id }}"
                                                    data-text="url" data-target="#changeTotalShipper{{ $order->id }}" data-action="{{ route('admin.order_management.update.total-shipper', ['id' => $order->id]) }}">
                                                    {{ number_format($order->shipping_fee) }} đ
                                                </td>

                                                {{-- update total shipper --}}
                                                <div class="modal fade" id="changeTotalShipper{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form action="" method="POST" id="changeTotalShipperAction_{{$order->id}}" class="form-submit" id="form-ship">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteItemText">Thay đổi tiền ship</h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <label>Tiền ship</label>
                                                                        <input type="text" class="form-control" id="totalCod" name="totalCod" value="{{floatval($order->shipping_fee)}}">
                                                                        <div class="form-err" id="errorTotalCod" style="display: none;">
                                                                            <div class="alert alert-danger-cus alert-des ">
                                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                                                <span class="text-total-cod-error">Số tiền không hợp lệ</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="text-center col-12">
                                                                        <button class="btn btn-secondary btn-sm " type="button" data-dismiss="modal">Hủy bỏ</button>
                                                                        <button class="btn btn-danger btn-sm btn-submit" type="submit">Xác nhận</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <td class="text-nowrap">
                                                    @php
                                                        $totalPro = $order->real_money+ $order->shipping_fee;

                                                    @endphp
                                                    {{ number_format($totalPro) }} đ
                                                </td>


                                                {{-- <td class="text-nowrap "><a class="gioi-han" data-toggle="collapse" href="#collapseExample{{$order->id}}" role="button" aria-expanded="false" aria-controls="collapseExample{{$order->id}}">{{ $order->customer_address }}</a>
                                                    <div class="collapse" id="collapseExample{{$order->id}}">
                                                        <div class="card card-body">
                                                          {{$order->customer_address}}
                                                        </div>
                                                    </div>
                                                </td>  --}}

                                                <td class="text-nowrap text-primary gioi-han changeAddressCustomer" data-id_action="{{ $order->id }}"
                                                    data-text="url" data-target="#changeAddressCustomer{{ $order->id }}" data-action="{{ route('admin.order_management.update.address-customer', ['id' => $order->id]) }}">
                                                    {{$order->customer_address}}
                                                </td>

                                                {{-- update address customer  --}}
                                                <div class="modal fade" id="changeAddressCustomer{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form action="" method="POST" id="changeAddressCustomerAction_{{$order->id}}" class="form-submit">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteItemText">Thay đổi địa chỉ</h5>
                                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <label>Địa chỉ</label>
                                                                            <input type="text" class="form-control" name="customer_addressM" value="{{$order->customer_address}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <div class="text-center col-12">
                                                                            <button class="btn btn-secondary btn-sm " type="button" data-dismiss="modal">Hủy bỏ</button>
                                                                            <button class="btn btn-danger btn-sm btn-submit" type="submit">Xác nhận</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                
                                                
                                                {{-- <td class="text-nowrap">
                                                    {{ $order->customer_name }}</td> --}}
                                                <td class="text-nowrap">
                                                    {{ $order->user ? $order->user->name : '' }}
                                                    {{-- {{$order->users->name}} --}}
                                                </td>
                                                
                                                
                                                {{-- {{dd($order->first)}} --}}
                                                <td class="text-nowrap condition text-{{ $order->condition->color }}">
                                                    {{-- @if ($order->condition_id === Condition::ORDER_DESTROY || $order->condition_id === Condition::ORDER_COMPLETE || $order->condition_id === Condition::ORDER_LOST)
                                                        <button class="btn btn btn-{{ $order->condition->color }}">
                                                            {{ $order->condition->name }}
                                                        </button>
                                                    @else --}}
                                                        <button title="changeShipper"
                                                            class="btn btn btn-{{ $order->condition->color }} btnChangeCondition"
                                                            data-id="{{ $order->id }}" data-target="#changeCondition"
                                                            data-value="{{ $order->condition->id }}"
                                                            data-action="{{ route('admin.order_management.update', ['id' => $order->id]) }}" id="changeState">
                                                            {{ $order->condition->name }}
                                                        </button>
                                                        @if($order->note2)
                                                            <p style="font-size: 11px; color: red">({{$order->note2}})</p>
                                                        @endif
                                                    {{-- @endif --}}
                                                </td>

                                                <td>{{ $order->shipper ? $order->shipper->name : '' }}</td>
                                                <td>
                                                    <button title="changeShipper"
                                                        class="btn btn btn-outline-danger btn-last btnChangeShipper"
                                                        data-id="{{ $order->id }}" data-target="#changeShipper"
                                                        data-text="url"
                                                        data-action="{{ route('admin.order_management.update.shipper', ['id' => $order->id]) }}">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </button>
                                                </td>
                                                {{-- <td class="wrap-load-hot" data-url="{{ route('admin.order_management.load.status-order',['id'=>$order->id]) }}">
                                                    @include('admin.components.load-change-status-order',['data'=>$order,'type'=>'sản phẩm'])
                                                </td>
                                                <td class="wrap-load-hot" data-url="{{ route('admin.order_management.load.status-order-ship',['id'=>$order->id]) }}">
                                                    @include('admin.components.load-change-status-order-ship',['data'=>$order,'type'=>'sản phẩm'])
                                                </td> --}}

                                                <td>
                                                    <button  class="btn btn btn-info">
                                                        {{$order->status == 1 ? 'Thu hộ' : 'Không thu hộ'}}
                                                    </button>
                                                </td>

                                                <td>
                                                    <button  class="btn btn btn-info">
                                                        {{$order->status_ship == 1 ? 'Khách trả' : 'Shop trả'}}
                                                    </button>
                                                </td>

                                                <td class="text-nowrap">
                                                    @if ($order->debt == OrderManagement::PAID)
                                                        <button class="btn btn btn-light }}">
                                                            Đã thanh toán
                                                        </button>
                                                    @else
                                                        <button class="btn btn btn-dark btnChangeDeft"
                                                            data-id="{{ $order->id }}" data-target="#changeDebt"
                                                            data-text="url"
                                                            data-action="{{ route('admin.order_management.update.debt', ['id' => $order->id]) }}">
                                                            Chưa thanh toán
                                                        </button>
                                                    @endif
                                                </td>
                                                <td class="text-nowrap">
                                                    @if ($order->refund == OrderManagement::REFUNDED)
                                                        <button class="btn btn btn-success }}">
                                                            Đã hoàn tiền
                                                        </button>
                                                    @else
                                                        <button class="btn btn btn-danger btnChangeRefund"
                                                            data-id="{{ $order->id }}" data-target="#changeRefund"
                                                            data-text="url"
                                                            data-action="{{ route('admin.order_management.update.refund', ['id' => $order->id]) }}">
                                                            Chưa hoàn tiền
                                                        </button>
                                                    @endif
                                                </td>
                                                {{-- <td class="text-nowrap">{{ $order->created_at }}</td> --}}
                                                <td class="text-nowrap">
                                                    <a class="btn btn-sm btn-info" id="btn-load-transaction-detail"
                                                        href="{{ route('admin.order_management.show', ['id' => $order->id]) }}"><i
                                                            class="fas fa-eye"></i></a>
                                                    <button title="delete"
                                                        class="btn btn btn-outline-danger btn-last btnDelete1"
                                                        data-id="{{ $order->id }}" data-target="#deleteItem"
                                                        data-text="url"
                                                        data-action="{{ route('admin.order_management.destroy', ['id' => $order->id]) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-7 mt-3 pl-3">
                                    <div id="dataTable_info" role="status" aria-live="polite" class="dataTables_info">
                                        Show：{{ $orders->firstItem() }} / {{ $orders->lastItem() }} | Total:
                                        {{ $total }}
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

    

    {{-- update shipper for order --}}
    <div class="modal fade" id="changeShipper" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" id="changeShipperAction" class="form-submit">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteItemText">Thay đổi người giao hàng</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label>Chọn người giao hàng</label>
                            <select name="shipper_id" id="shipperId" class="form-control">
                                @foreach ($shippers as $shipper)
                                    <option value="{{ $shipper->id }}">{{ $shipper->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center col-12">
                            <button class="btn btn-secondary btn-sm " type="button" data-dismiss="modal">Hủy bỏ</button>
                            <button class="btn btn-danger btn-sm btn-submit" type="submit">Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- change condtion order --}}
    <div class="modal fade" id="changeCondition" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" id="changeConditionAction" class="form-submit">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteItemText">Thay đổi trạng thái đơn hàng</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <label for="">Chọn trạng thái</label>
                        <select name="condition_id" id="conditionId" class="form-control select_change">
                            @foreach ($conditions as $condition)

                                <option value="{{ $condition->id }}" class="text-{{ $condition->color }}">
                                    {{ $condition->name }}
                                </option>
                                
                            @endforeach
                        </select>
                        
                        {{-- @if(isset($order->note2))
                            <div>
                                <input type="text" class="form-control" name="note2" value="{{$order->note2}}"  />
                            </div>
                        @endif --}}
                        <div id="ghi_chu"></div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center col-12">
                            <button class="btn btn-secondary btn-sm " type="button" data-dismiss="modal">Hủy bỏ</button>
                            <button class="btn btn-danger btn-sm btn-submit" type="submit">Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- change debt --}}
    <div class="modal fade" id="changeDebt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" id="changeDebtAction" class="form-submit">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeItemText">Cập nhật tiền thanh toán</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0" id="changeItemMessage">Bạn đã thanh toán thành công?</span>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center col-12">
                            <button class="btn btn-secondary btn-sm " type="button" data-dismiss="modal">Hủy bỏ</button>
                            <button class="btn btn-success btn-sm btn-submit" type="submit">Vâng</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- change refund --}}
    <div class="modal fade" id="changeRefund" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" id="changeRefundAction" class="form-submit">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeItemText">Cập nhật tiền hàng</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0" id="changeItemMessage">Bạn đã hoàn tiền hàng thành công?</span>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center col-12">
                            <button class="btn btn-secondary btn-sm " type="button" data-dismiss="modal">Hủy bỏ</button>
                            <button class="btn btn-success btn-sm btn-submit" type="submit">Vâng</button>
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

        $('.changeTotalShipper').click(function(e) {
            let idOrder = $(this).attr('data-id_action');
            let action = $(this).attr('data-action');
            // console.log(action, idOrder);
            $('#changeTotalShipperAction_'+ idOrder).attr('action', $(this).attr('data-action'));
            $($(this).attr('data-target')).modal('show');
        })

        $('.changeAddressCustomer').click(function(e) {
            let idOrder = $(this).attr('data-id_action');
            let action = $(this).attr('data-action');
            $('#changeAddressCustomerAction_'+ idOrder).attr('action', $(this).attr('data-action'));
            $($(this).attr('data-target')).modal('show');
        })


        $('.changeTotalCode').click(function(e) {
            let idOrder = $(this).attr('data-id_action');
            let action = $(this).attr('data-action');
            // console.log(action, idOrder);
            $('#changeTotalCodeAction_'+ idOrder).attr('action', $(this).attr('data-action'));
            $($(this).attr('data-target')).modal('show');
        })

        $('.totalVarient').keyup(function() {
            if($(this).val().length > 0){
                if(formatCurrency($(this).val()) == false){
                    $('.'+errorText).text('Tiền ship không hợp lệ');
                    $('#'+elementHide).show();
                    $('#'+elementHide).parent().children().addClass('is-invalid');
                }else{
                    $('#'+elementHide).hide();
                    $('#'+elementHide).parent().children().removeClass('is-invalid');
                }
            }else{
                $('.'+errorText).text('Thông tin bắt buộc');
                $('#'+elementHide).show();
                $('#'+elementHide).parent().children().addClass('is-invalid');
            }
        })

        

        // 

        function formatCurrency(total) {
            var neg = false;
            if(total < 0) {
                neg = true;
                total = Math.abs(total);
            }
            return (neg ? "-$" : '$') + parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
        }

        function validateTotalCod (totalCod)
        {
            var removeChar = function (strInput) {
                return strInput.replace(/(<([^>]+)>)/ig, "").replace(/!|@|\$|%|\^|\*|\(|\#|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\'||\"|\&|\#|\[|\]|~/g, "");
            }

            if(totalCod == '' || totalCod.replace(/\s/g, '').length < 1){
                $('#errorTotalCod').show();
                var errorTotalCod = false;
            }else{
                if(totalCod.length < 0 || !$.isNumeric(totalCod) || formatCurrency(totalCod) == false){
                    $('.text-total-cod-error').text('Số tiền không hợp lệ');
                    $('#errorTotalCod').show();
                    var errorTotalCod = false;
                }else{
                    $('#errorTotalCod').hide();
                }
            }

            if(errorCod == false){
                return false;
            }
        }


        function validateTotalCode (totalCode)
        {
            var removeChar = function (strInput) {
                return strInput.replace(/(<([^>]+)>)/ig, "").replace(/!|@|\$|%|\^|\*|\(|\#|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\'||\"|\&|\#|\[|\]|~/g, "");
            }

            if(totalCode == '' || totalCode.replace(/\s/g, '').length < 1){
                $('#errorTotalCode').show();
                var errorTotalCode = false;
            }else{
                if(totalCode.length < 0 || !$.isNumeric(totalCode) || formatCurrency(totalCode) == false){
                    $('.text-total-code-error').text('Số tiền không hợp lệ');
                    $('#errorTotalCode').show();
                    var errorTotalCode = false;
                }else{
                    $('#errorTotalCode').hide();
                }
            }

            if(errorTotalCode == false){
                return false;
            }
        }

        


        function keyUpValidate (elementKeyup, elementHide, elementName = false, extend = false, errorText, star = false,  invaliEmail = false)
        {
            var removeChar = function (strInput) {
                return strInput.replace(/(<([^>]+)>)/ig, "").replace(/!|@|\$|%|\^|\*|\(|\#|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\'||\"|\&|\#|\[|\]|~/g, "");
            }

            $(document).on('keyup', '#'+elementKeyup, function(){
                // console.log($(this).val());
                if($(this).val() != '' && $(this).val().replace(/\s/g, '').length > 0 && removeChar($(this).val()) != ''){
                    $('#'+elementHide).hide();
                    $('#'+elementHide).parent().children().removeClass('is-invalid');
                }else{
                    $('#'+elementHide).show();
                    $('#'+elementHide).parent().children().addClass('is-invalid');
                }

                //check totalCod
                if(extend == 'total-cod'){
                    if($(this).val().length > 0){
                        if(validateTotalCod($(this).val()) == false){
                            $('.'+errorText).text('Số tiền không hợp lệ');
                            $('#'+elementHide).show();
                            $('#'+elementHide).parent().children().addClass('is-invalid');
                        }else{
                            $('#'+elementHide).hide();
                            $('#'+elementHide).parent().children().removeClass('is-invalid');
                        }
                    }else{
                        $('.'+errorText).text('Thông tin bắt buộc');
                        $('#'+elementHide).show();
                        $('#'+elementHide).parent().children().addClass('is-invalid');
                    }
                }

                //check totalCod
                if(extend == 'total-code'){
                    if($(this).val().length > 0){
                        if(validateTotalCode($(this).val()) == false){
                            $('.'+errorText).text('Số tiền không hợp lệ');
                            $('#'+elementHide).show();
                            $('#'+elementHide).parent().children().addClass('is-invalid');
                        }else{
                            $('#'+elementHide).hide();
                            $('#'+elementHide).parent().children().removeClass('is-invalid');
                        }
                    }else{
                        $('.'+errorText).text('Thông tin bắt buộc');
                        $('#'+elementHide).show();
                        $('#'+elementHide).parent().children().addClass('is-invalid');
                    }
                }

            });
        }

        function callKeyUpValidate ()
        {
            //validate create comment
            keyUpValidate('totalCod', 'errorTotalCod', 'none', 'total-cod', 'text-total-cod-error');
            keyUpValidate('totalCode', 'errorTotalCode', 'none', 'total-code', 'text-total-code-error');
        }

        $(document).ready(function(){
            //keyup validate

            callKeyUpValidate();
        });

        
		$("#form-code").on("submit", function () {

			let totalCode = $('#totalCode').val();

            var validate = validateTotalCode(totalCode);

			if(validate == false){
				return false;
			}
        })

        $("#form-ship").on("submit", function () {

            let totalCod = $('#totalCod').val();

            var validate = validateTotalCod(totalCod);

            if(validate == false){
                return false;
            }
        })
        // 



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
        // if ($("#start_date").val().length > 0) {
        //     $("#end_date").attr("min", $("#start_date").val());
        // }
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
