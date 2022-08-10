@extends('frontend.layouts.main')
@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <div class="form-buy">
                            <h2 class="title-form">
                                Thông tin đặt mua
                            </h2>
                            <form action="" method="POST" role="form">
                                <div class="form-group">
                                    <label for="">Họ và tên</label>
                                    <input type="text" class="form-control" id="" placeholder="Họ và tên">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" id="" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="">Số điện thoại</label>
                                    <input type="email" class="form-control" id="" placeholder="Số điện thoại">
                                </div>
                                <div class="form-group">
                                    <label for="">Tỉnh/Thành phố</label>
                                    <select name="city" id="city" class="form-control" required="required" data-url="{{ route('ajax.address.districts') }}">
                                        <option value="">Chọn tỉnh/thành phố</option>
                                        {!! $cities !!}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Quận/huyện</label>
                                    <select name="district" id="district" class="form-control" required="required" data-url="{{ route('ajax.address.communes') }}">
                                        <option value="">Chọn quận/huyện</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Xã/phường/thị trấn </label>
                                    <select name="commune" id="commune" class="form-control" required="required">
                                        <option value="">Chọn xã/phường/thị trấn</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">Panel title</h3>
                            </div>
                            <div class="panel-body">
                                Panel content
                            </div>
                            <a data-url="{{ route('cart.clear') }}" class="btn btn-danger clear-cart mb-4">Clear toàn bộ</a>
                            @include('frontend.components.cart-component')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('frontend/js/load-address.js') }}"></script>
@endsection
