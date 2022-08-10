@extends('admin.layouts.main_full')
@section('title',"Chi tiết đơn hàng")


@section('css')
   <style>
        .container-cart{
            max-width: 600px;
        }
        .template-search{
            background: #eee;
        }
        .title-cart{
            font-size: 15px;
            font-weight: 600;
            margin: 0;
            margin-bottom: 20px;
        }
        .bg-cart{
            background: #fff;
        }
        .sucess-order{
            display: block;
            overflow: hidden;
            background-color: #f5f5f5;
            text-align: center;
            padding: 10px 0;
            color: #34c772;
            font-size: 25px;
            font-weight: bold;
        }
        .order-content{
            padding: 10px 30px;
        }
        .order-content .infor-order{}
        .thank-you{}
        .order-content  .list-infor{
            display: block;
            overflow: hidden;
            background-color: #f3f3f3;
            padding:10px;
        }
        .order-content  .list-infor li{
            line-height: 25px;
            padding: 5px 0;
        }
        .order-content  .list-infor li span{
            font-weight: 600;
            color: #000;
        }
        .order-content  .total-price{
            color: red;
        }
        .order-content  .total-price span{

        }
        .buy-more{}
        .buy-more a{
            overflow: hidden;
            border: 1px solid #288ad6;
            color: #288ad6;
            background-color: #fff;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 20px;
            width: 100%;
        }
        .order-item h4{
            margin: 0;
            font-size: 12px;
            font-weight: bold;
        }
        .title-order{
            font-size: 18px;
            font-weight: bold;

        }
   </style>
@endsection
@section('content')

        <div class="main">
            <div class="container container-cart">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="bg-cart mt-5 mb-5">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="order-content">

                                        <div class="infor-order mb-3">
                                            <div class="text-center mb-3 title-order" style="font-size:25px;">
                                             Thông tin đơn hàng
                                            </div>
                                            <ul class="list-infor">
                                                <li><span>Người nhận hàng </span> {{ $data->name }}</li>
                                                <li><span>Giao đến </span> {{ $data->address_detail }}, {{ $data->commune->name }}, {{ $data->district->name }}, {{ $data->city->name }}.</li>
                                                <li class="total-price"><span>Tổng tiền </span> {{ number_format($data->total) }}</li>
                                            </ul>
                                          <div class="list-order-product pt-4 pb-4">
                                            <div class="title-order  mb-3">
                                                Danh sách sản phẩm đã đặt
                                            </div>
                                            <div class="">


                                                <table class="table table-bordered">
                                                    <thead class="thead-dark">
                                                      <tr>
                                                        <th scope="col">STT</th>
                                                        <th scope="col">Tên sản phẩm</th>
                                                        <th scope="col">Giá cũ</th>
                                                        <th scope="col">Giảm giá</th>
                                                        <th scope="col">Giá sau cùng</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data->orders as $orderItem)
                                                        <tr>
                                                            <th scope="row">{{ $loop->index+1 }}</th>
                                                            <td>{{ $orderItem->name }}</td>
                                                            <td>{{ $orderItem->old_price." ".$unit  }}</td>
                                                            <td>{{ $orderItem->sale."%" }}</td>
                                                            <td> <strong style="color: red">{{ $orderItem->new_price." ".$unit }}</strong></td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <th scope="row" colspan="5" class="text-right">Tổng giá trị: <strong style="color: red">{{ $data->total." ".$unit }}</strong></th>
                                                        </tr>
                                                    </tbody>
                                                  </table>



                                            </div>
                                          </div>
                                         </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection





@section('js')

@endsection
