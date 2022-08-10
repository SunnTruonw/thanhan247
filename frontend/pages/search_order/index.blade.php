@extends('frontend.layouts.main')

@section('title', __('search.ket_qua_tim_kiem'))
@section('keywords', __('search.ket_qua_tim_kiem'))
@section('description', __('search.ket_qua_tim_kiem'))
@section('image', asset(optional($header['seo_home'])->image_path))
@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="text-left wrap-breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <ul class="breadcrumb">
                                <li class="breadcrumbs-item">
                                    <a href="{{ makeLink('home') }}">{{ __('home.home') }}</a>
                                </li>
                                <li class="breadcrumbs-item"><a href=""
                                        class="currentcat">{{ __('search.tim_kiem') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrap-content-main wrap-template-product template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            @if ($orders->count() > 0)
                                <h3 class="title-template">{{ __('search.ket_qua_tim_kiem') }} </h3>
                                <div class="table-responsive">
                                    <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('order_management.id') }}</th>
                                                <th class="text-nowrap">{{ __('order_management.order_code') }}</th>
                                                <th class="text-nowrap">{{ __('order_management.customer_name') }}</th>
                                                <th class="text-nowrap">{{ __('order_management.address') }}</th>
                                                <th class="text-nowrap">{{ __('order_management.total_money') }}</th>
                                                <th class="text-nowrap">{{ __('order_management.shipping_fee') }}</th>
                                                <th class="text-nowrap">{{ __('order_management.real_money') }}</th>
                                                <th class="text-nowrap">{{ __('order_management.condition') }}</th>
                                                <th class="text-nowrap">{{ __('order_management.refund') }}</th>
                                                <th class="text-nowrap">{{ __('order_management.note') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->order_code }}</td>
                                                    <td>{{ $order->customer_name }}</td>
                                                    <td>{{ $order->customer_address }}</td>
                                                    <td>{{ number_format($order->total_money) }}đ</td>
                                                    <td>{{ number_format($order->shipping_fee) }}đ</td>
                                                    <td>{{ number_format($order->real_money) }}đ</td>
                                                    <td> <span
                                                            class="text text-{{ $order->condition->color }} bold">{{ $order->condition->name }}</span>
                                                    </td>
                                                    <td> <span
                                                            class="text text-{{ $order->refund == 0 ? 'danger' : 'success' }} bold">{{ $order->refund == 0 ? 'Chưa hoàn tiền' : 'Đã hoàn tiền' }}</span>
                                                    </td>
                                                    <td>{{ $order->note }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-7 mt-3">
                                        <div id="dataTable_info" role="status" aria-live="polite" class="dataTables_info">
                                            Show：{{ $orders->firstItem() }} / {{ $orders->lastItem() }} | Total: {{ $orders->total() }}
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-center">
                                        <div class="d-inline-block float-right">
                                            {{ $orders->links() }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <h3 class="title-template">{{ __('search.ket_qua_tim_kiem') }} </h3>
                                <p>Không có kết quả tìm kiếm phù hợp</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
