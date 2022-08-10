@extends('admin.layouts.main')
@section('title', 'Sửa chi tiết đơn hàng')
@section('css')
    <style>
        .help-block.error-help-block {
            color: red
        }

    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>"Chi tiết đơn hàng","key"=>"Cập nhật chi tiết đơn hàng"])
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.order_management.update-order_management', ['id' => $order_management->id]) }}" method="POST" id="form-create-shipper">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Cập nhật Chi tiết đơn hàng</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Mã đơn hàng
                                                    <span class="text-danger"></span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" name="order_code" value="{{ $order_management->order_code }}"
                                                        class="form-control" disabled="disabled">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Tiền cả COD
                                                    <span class="text-danger"></span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" name="total_money" value="{{ number_format($order_management->total_money) ?? old('total_money') }}"
                                                        class="form-control total_money product_money">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Tổng phí ship
                                                    <span class="text-danger"></span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" name="shipping_fee" value="{{ number_format($order_management->shipping_fee) ?? old('shipping_fee') }}"
                                                        class="form-control shipping_fee product_money">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Tiền gốc
                                                    <span class="text-danger"></span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" name="real_money"
                                                        value="{{ number_format($order_management->real_money) ?? old('real_money') }}" class="form-control product_money">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Tổng KL
                                                    <span class="text-danger"></span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" name="package_sum_mass" value="{{ $order_management->package_sum_mass ?? old('package_sum_mass') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Chiều dài
                                                    <span class="text-danger"></span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" name="package_long" value="{{ $order_management->package_long ?? old('package_long') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Chiều rộng
                                                    <span class="text-danger"></span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" name="package_wide" value="{{ $order_management->package_wide ?? old('package_wide') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Chiều cao
                                                    <span class="text-danger"></span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" name="package_high" value="{{ $order_management->package_high ?? old('package_high') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-12 text-center">
                                                    <button type="submit" class="btn btn-primary">
                                                        Xác nhận
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

<script>
    // let sumMass = [];
    // let sumMoney = [];
    // setInterval(() => {
    //     sumMass = [];
    //     sumMoney = []
    //     setTotalMass();
    //     setTotalMoney();
    //     $('.total_money').val(formatCurrency(Number($('.real_money').val().replace(/[^0-9\.]+/g,"")) + Number($('.shipping_fee').val().replace(/[^0-9\.]+/g,""))));
    // }, 2000);

    // function setTotalMass() {
    //     return new Promise(async (resolve) => {
    //         const check = $('.product_mass');
    //         if (check.length > 0) {
    //             check.each(function(key, mass) {
    //                 const qty = $(mass).closest('.product').find('.product_qty');
    //                 sumMass.push($(mass).val() * $(qty).val());
    //             });
    //             let total = 0;
    //             for (let i = 0; i < sumMass.length; i++) {
    //                 total += sumMass[i] << 0;
    //             }
    //             $('.package_sum_mass').val(total / 1000);
    //             const url = `/order-management/shipping-fee/${$('.package_sum_mass').val()}`;
    //             $.ajaxSetup({
    //                 headers: {
    //                     'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //                 }
    //             });
    //             $.ajax({
    //                 url: url,
    //                 method: 'get',
    //                 success: function(respone) {
    //                     $('.shipping_fee').val(formatCurrency(parseFloat(respone[0])))
    //                 },
    //                 error: function(err) {
    //                     console.log(err);
    //                 }
    //             });
    //         } else {
    //             await timeOut();
    //             resolve(await setTotalMass());
    //         }
    //     });
    // }

    // function setTotalMoney() {
    //     return new Promise(async (resolve) => {
    //         const productMoney = $('.product_money');
    //         if (productMoney.length > 0) {
    //             productMoney.each(function(key, money) {
    //                 const qty = $(money).closest('.product').find('.product_qty');
    //                 sumMoney.push(Number($(money).val().replace(/[^0-9\.]+/g,"")) * $(qty).val());
    //             });
    //             let total = 0;
    //             for (let i = 0; i < sumMoney.length; i++) {
    //                 total += sumMoney[i] << 0;
    //             }
    //             $('.real_money').val(formatCurrency(total));
    //         } else {
    //             await timeOut();
    //             resolve(await setTotalMoney());
    //         }
    //     });
    // }

    $('.product_money').on('change', function() {
        $(this).val(formatCurrency(parseFloat($(this).val())));

        // let money_ship = $('.shipping_fee').val();
        // let total = $(this).val();
        // let totalRoot = total + money_ship;
        

        // $('.total_money').val(formatCurrency(parseFloat(totalRoot)));
    })

    // function timeOut(ms = Math.random() * 10 * 1000) {
    //     return new Promise((resolve) => setTimeout(resolve, ms));
    // }

    function formatCurrency(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    }

</script>
@endsection
