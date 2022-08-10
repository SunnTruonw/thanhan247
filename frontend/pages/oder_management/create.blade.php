<?php
use App\Models\City;
?>
@extends('frontend.layouts.main-profile')
@section('title', 'Tạo đơn hàng')
@section('css')
    <style>
        .help-block.error-help-block {
            color: red
        }
		.titlequanly {
			color: #333;
			text-align: left;
			text-transform: uppercase;
			font-size: 18px;
			line-height: 40px;
			margin: 0;
		}
    </style>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-6">
                    <h6 class="titlequanly">{{ __('order_management.create_order.title') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('order_management.store') }}" method="post" id="form-create-order"
                enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="row info_customer">
                        <div class="col-xd-12 col-md-6">
                            <div class="mt-3">
                                <label for="phone">Số điện thoại</label>
                                <input type="number" class="form-control" name="customer_phone" placeholder="Nhập số điện thoại">
                            </div>
                            
							<div class="mt-3">
                                <label for="phone">Họ tên</label>
                                <input type="text" class="form-control" name="customer_name" placeholder="Nhập họ tên">
                            </div>
                            <div class="mt-3">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control" name="customer_address" placeholder="Nhập địa chỉ">
                            </div>
                            
                        </div>
                        <div class="col-xd-12 col-md-6">
                            <div class="mt-3">
                                <label>Tỉnh/thành phố</label>
                                <select name="city" class="form-control city" id="cities" class="cities">
                                    <option value="">Tỉnh/thành phố</option>
                                    {{-- <option value="Hà Nội">Hà Nội</option> --}}
                                    
                                    @foreach ($cities as $city)
                                        @if($city->id == 1)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3">
                                <label>Quận</label>
                                <select name="district" class="form-control" id="" class="district">
                                    <option value="">Chọn Quận</option>
                                    {{-- <option value="Quận Ba Đình">Quận Ba Đình</option>
                                    <option value="Quận Hoàn Kiếm">Quận Hoàn Kiếm</option>
                                    <option value="Quận Tây Hồ">Quận Tây Hồ</option>
                                    <option value="Quận Long Biên">Quận Long Biên</option>
                                    <option value="Quận Cầu Giấy">Quận Cầu Giấy</option>
                                    <option value="Quận Đống Đa">Quận Đống Đa</option>
                                    <option value="Quận Hai Bà Trưng">Quận Hai Bà Trưng</option>
                                    <option value="Quận Hoàng Mai">Quận Hoàng Mai</option>
                                    <option value="Quận Thanh Xuân">Quận Thanh Xuân</option>
                                    <option value="Quận Hà Đông">Quận Hà Đông</option>
                                    <option value="Quận Bắc Từ Liêm">Quận Bắc Từ Liêm</option>
                                    <option value="Quận Nam Từ Liêm">Quận Nam Từ Liêm</option> --}}
                                </select>
                            </div>
                            <div class="mt-3">
                                <label>Phường/xã</label>
                                <select name="wards" id="" class="form-control" class="wards">
                                    <option value="">Phường/xã</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <h5 style="color: chocolate">Sản phẩm</h5>
                        </div>
                        <div class="col-6 text-right align-items-center">
                            <a href="#" class="text-decoration-none text-success sp_cosan"><i class="fas fa-plus-square"></i> Sp có
                                sẵn
                            </a>
                        </div>
                    </div>
                    <!-- ========================================= PRODUCT ========================================= -->
                    <div class="product-parent listProItem">
                        <div class="product proItem">
                            <div class="ml-1 pick-image-container">
                                <label for="" class="package-pick-image">
                                    <input class="image_pro" type="file" name="product_image[]" id="">
                                    <div>Up ảnh</div>
                                </label>
                            </div>
                            <div class="ml-2 pick-name">
                                <input type="text" name="product_title[]" value="{{ old('product_title') }}" class="form-control" placeholder="Nhập tên sản phẩm" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            {{-- <div class="ml-2 pick-code">
                                <input type="text" class="form-control" placeholder="Nhập mã sản phẩm" aria-label="Small" name="product_code[]"
                                        value="{{ old('product_code[]') }}" aria-describedby="inputGroup-sizing-sm">
                            </div> --}}
                            <div class="ml-3 pick-price">
                               
                                <input type="text" class="form-control product_money" aria-label="Small" name="product_money[]" placeholder="Nhập số tiền" value="{{ old('product_money[]') }}"
                                    aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="ml-3 pick-weight">
                                <div class="package-title">KL (gam)</div>
                                <input type="text" class="form-control product_mass" aria-label="Small"
                                        name="product_mass[]" value="{{ old('product_mass[]') }}"
                                        aria-describedby="inputGroup-sizing-sm" placeholder="0">
                            </div>
                            <div class="ml-2 pick-quantity">
                                <div class="package-title">SL</div>
                                
                                <input type="text" class="form-control product_qty" aria-label="Small"
                                        name="product_qty[]" value="{{ old('product_qty[]') }}"
                                        aria-describedby="inputGroup-sizing-sm" placeholder="1">
                                
                            </div>
                            <div style="width: 20px" class="ml-2 mt-1">
                                <div class="input-group input-group-sm">
                                    <div class="clone">
                                        <i class="text-success  fas fa-plus-square"></i>
                                    </div>
                                </div>
                            </div>
                            <div style="width: 20px" class="mt-1">
                                <div class="input-group input-group-sm">
                                    <div class="remove d-none">
                                        <i class="text-secondary fas fa-minus-square"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ========================================= PRODUCT : END ========================================= -->

                    <!-- ========================================= PACKAGE INFOMATION ========================================= -->
                    <div class="row">
                        <div class="col-6">
                            <h5 style="color: chocolate">Thông tin gói hàng</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="info_packet">
                                <div class="item">
                                    <div class="package-title">Tổng KL(gam)</div>
                                    <input type="text" class="form-control package_sum_mass" aria-label="Small"
                                        aria-describedby="inputGroup-sizing-sm" readonly placeholder="500"
                                        name="package_sum_mass" value="{{ old('package_sum_mass') }}">
                                </div>
                                <div class="item">
                                    <div class="package-title">Dài</div>
                                    <input type="text" class="form-control package_long" aria-label="Small"
                                        aria-describedby="inputGroup-sizing-sm" placeholder="500"
                                        name="package_long" value="{{ old('package_long') }}">
                                </div>
                                <div class="item">
                                    <div class="package-title">Rộng</div>
                                    <input type="text" class="form-control" aria-label="Small"
                                    aria-describedby="inputGroup-sizing-sm" placeholder="10" name="package_wide"
                                    value="{{ old('package_wide') }}">
                                </div>
                                <div class="item">
                                    <div class="package-title">Cao</div>
                                    <input type="text" class="form-control" aria-label="Small"
                                    aria-describedby="inputGroup-sizing-sm" placeholder="10" name="package_high"
                                    value="{{ old('package_high') }}">
                                </div>
                            </div>
                        </div>
        
                    </div>
                    <!-- ========================================= PACKAGE INFOMATION : END ========================================= -->

                    <div class="row mt-3 box_total">
                        <div class="col-xs-12 col-sm-4">
                            <label for="">Tổng tiền gốc</label>
                            <input type="text" class="form-control real_money" name="real_money" readonly
                                value="{{ old('real_money') }}">
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <label for="">Phí ship</label>
                            <input type="text" class="form-control shipping_fee" name="shipping_fee" readonly
                                value="{{ old('shipping_fee') }}">
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <label for="">Tổng tiền thu hộ</label>
                            <input type="text" class="form-control total_money" name="total_money" readonly
                                value="{{ old('total_money') }}">
                        </div>
                    </div>
                    <hr class="mt-5">
                    <div class="row">
                        <div class="col-6">
                            <h5 style="color: chocolate">Lưu ý - ghi chú</h5>
                        </div>
                    </div>
                    <div class="row box_note">
                        {{-- <div class="col-xs-12 col-sm-6">
                            <label for="">Lưu ý khi giao hàng</label>
                            <div class="form-group">
                                <input class="form-control" id="exampleFormControlTextarea1" name="note_delivery"
                                    value="{{ old('note_delivery') }}">
                            </div>
                            <label for="">Thêm mã đơn khách hàng</label>
                            <div class="form-group">
                                <input class="form-control" id="exampleFormControlTextarea1" name="customer_code"
                                    value="{{ old('customer_code') }}">
                            </div>
                        </div> --}}
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Ghi chú</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                    name="note">{{ old('note') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Tải file đính kèm</label>
                                <input type="file" style="width:200px" id="image" class="form-control-file img-load-input borderz" name="file">
                            </div>
                            <img id="preview-image-before-upload" class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 120px;object-fit:cover; max-width: 160px;">
                        </div>

                    </div>


                </div>
                <div class="row justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary">Tạo đơn</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\Frontend\CreateOrderRequest', '#form-create-order') !!}

    <script type="text/javascript">
      
        $(document).ready(function (e) {
         
           
           $('#image').change(function(){
                    
            let reader = new FileReader();
         
            reader.onload = (e) => { 
         
              $('#preview-image-before-upload').attr('src', e.target.result); 
            }
         
            reader.readAsDataURL(this.files[0]); 
           
           });
           
        });
        
        </script>
    <script>
        $('#cities').change(async function(e) {
            e.preventDefault();
            const idCity = $(this).find(":checked").val();
            const url = `/order-management/district/${idCity}`;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'get',
                success: function({
                    data
                }) {
                    $('select[name="district"]').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $('select[name="district"]').change(async function(e) {
            e.preventDefault();
            const idDistrict = $(this).find(":checked").val();
            const url = `/order-management/wards/${idDistrict}`;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'get',
                success: function({
                    data
                }) {
                    $('select[name="wards"]').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $('.clone').click(function() {
            if ($('.clone').length > 1) {
                $(this).closest('.product').find('.remove').removeClass('d-none');
            };
            $(this).closest('.product').clone(true).appendTo('.product-parent');
        });

        $('.remove').click(function() {
            $(this).closest('.product').remove();
        });

        let sumMass = [];
        let sumMoney = [];
        setInterval(() => {
            sumMass = [];
            sumMoney = []
            setTotalMass();
            setTotalMoney();
            $('.total_money').val(formatCurrency(Number($('.real_money').val().replace(/[^0-9\.]+/g,"")) + Number($('.shipping_fee').val().replace(/[^0-9\.]+/g,""))));
        }, 2000);

        function setTotalMass() {
            return new Promise(async (resolve) => {
                const check = $('.product_mass');
                if (check.length > 0) {
                    check.each(function(key, mass) {
                        const qty = $(mass).closest('.product').find('.product_qty');
                        sumMass.push($(mass).val() * $(qty).val());
                    });
                    let total = 0;
                    for (let i = 0; i < sumMass.length; i++) {
                        total += sumMass[i] << 0;
                    }
                    $('.package_sum_mass').val(total / 1000);
                    const url = `/order-management/shipping-fee/${$('.package_sum_mass').val()}`;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        method: 'get',
                        success: function(respone) {
                            $('.shipping_fee').val(formatCurrency(parseFloat(respone[0])))
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                } else {
                    await timeOut();
                    resolve(await setTotalMass());
                }
            });
        }

        function setTotalMoney() {
            return new Promise(async (resolve) => {
                const productMoney = $('.product_money');
                if (productMoney.length > 0) {
                    productMoney.each(function(key, money) {
                        const qty = $(money).closest('.product').find('.product_qty');
                        sumMoney.push(Number($(money).val().replace(/[^0-9\.]+/g,"")) * $(qty).val());
                    });
                    let total = 0;
                    for (let i = 0; i < sumMoney.length; i++) {
                        total += sumMoney[i] << 0;
                    }
                    $('.real_money').val(formatCurrency(total));
                } else {
                    await timeOut();
                    resolve(await setTotalMoney());
                }
            });
        }

        $('.product_money').on('change', function() {
            $(this).val(formatCurrency(parseFloat($(this).val())))
        })

        function timeOut(ms = Math.random() * 10 * 1000) {
            return new Promise((resolve) => setTimeout(resolve, ms));
        }

        function formatCurrency(n) {
            return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        }

    </script>

@endsection
