{{-- @extends('layouts.app') --}}
@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/auth.css') }}">
@endsection
@section('content')
    {{-- <div class="text-left wrap-breadcrumbs">
        <div class="breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <ul>
                            <li class="breadcrumbs-item">
                                <a href="{{ makeLink('home') }}"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="breadcrumbs-item active"><a href="{{ makeLink('register') }}">Đăng ký</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="block-register">
        {{-- @include('frontend.partials.header-1') --}}
        <div class="container">
            <div class="row">
                <div class="col-md-12 padding_none">
                    <div class="box-auth" id="register">
                        <div class="box-center__body">
                            <div class="box-center__form auth">
                                <div class="auth-left">
                                    <div class="auth-image">
                                        <img src="{{ asset(optional($data)->image_path) }}" alt="{{ optional($data)->name }}">
                                    </div>
                                    <div class="auth-title">{{ optional($data)->name }}</div>
                                    <div class="auth-info">
                                        {!!  optional($data)->description  !!}
                                    </div>
                                    <div class="auth-action">
                                        <a href="{{ route('login') }}" class="btn btn-blue">Đăng nhập</a>
                                    </div>
                                    <div class="auth-title mt-4">Đăng ký với:</div>
                                    <div class="auth-social">
                                        <a href="{{ route('login.social', ['social' => 'facebook']) }}" class="btn btn-blue">
                                        <i class="fab fa-facebook-f"></i>Đăng ký với Facebook</a>
                                        <a href="{{ route('login.social', ['social' => 'google']) }}" class="btn btn-red">
                                        <i class="fab fa-google"></i> Đăng ký với Google</a>
                                    </div>
                                </div>
                                <div class="auth-right">
                                    <div class="auth-title">Bạn chưa có tài khoản:</div>
                                    <div class="auth-form">
                                        <form action="{{ route('register') }}" method="POST">
                                            @csrf
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="" class="">Tên đăng nhập <span class=" red">*</span></label>
                                                <input type="text" placeholder="(Lưu ý: không được có khoảng trắng hoặc ký tự đặc biệt)" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="email" autofocus>
                                                @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="password">Mật khẩu <span class="red">*</span></label>
                                                <input id="password" type="password" placeholder="Mật khẩu"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="new-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="password-confirm">Nhập lại mật khẩu <span
                                                        class="red">*</span></label>

                                                <input id="password-confirm" placeholder="Nhập lại mật khẩu" type="password"
                                                    class="form-control" name="password_confirmation" required
                                                    autocomplete="new-password">
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="">Họ và tên <span class=" red">*</span></label>
                                                <input id="name" type="text" placeholder="Họ và tên"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" required autocomplete="name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="">Email <span class="red">*</span></label>
                                                <input type="text" placeholder="Nhập email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                            <div class="form-group dieuchinh">
                                                <label for="">Số điện thoại <span class="red">*</span></label>
                                                <input type="text" placeholder="Nhập số điện thoại"
                                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                    value="{{ old('phone') }}" required>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group dieuchinh">
                                                <label for="">Ngày sinh <span class="red">*</span></label>
                                                <input type="date"
                                                    class="form-control  @error('date_birth') is-invalid @enderror"
                                                    value="{{ old('date_birth') }}" name="date_birth"
                                                    placeholder="Ngày sinh">
                                                @error('date_birth')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- <div class="form-group">
                                                <label for="">Bạn muốn trở thành <span
                                                        class="red">*</span></label>

                                                <input type="text"
                                                    class="form-control  @error('you_become') is-invalid @enderror"
                                                    value="{{ old('you_become') }}" name="you_become"
                                                    placeholder="Bạn muốn trở thành">
                                                @error('you_become')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div> --}}

                                            {{-- <div class="form-group">
                                                <label for="">Sở thích <span class="red">*</span></label>
                                                <textarea class="form-control  @error('info_more') is-invalid @enderror"
                                                    cols="30" rows="2" placeholder="Sở thích của bạn"
                                                    name="info_more">{{ old('info_more') }}</textarea>
                                                @error('info_more')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div> --}}
                                            <div class="form-group checkbox">
                                                <input type="checkbox" name="checkrobot" class="btn-checkbox">
                                                <label for="accept-policy">Tôi đã đọc và đồng ý với <a
                                                        href="{{ optional($data)->slug }}" target="_blank">điều khoản sử
                                                        dụng</a> của cộng đồng</label>
                                                @error('checkrobot')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-submit">
                                                <button type="submit" class="btn btn-primary">Đăng ký</button>
                                            </div>
                                        </form>
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
    {{-- <script>
        var htmlA = '<div class="box-address"><h3>Bất động sản bạn quan tâm</h3>' +
            '<div class="form-group">' +
            '<div class="item_col_left">' +
            ' <label for="">Tỉnh/Thành phố</label>' +
            '  </div>' +
            ' <div class="item_col_right">' +
            '  <select name="city_id" required id="city" class="form-control" value="' + "{{ old('city_id') }}" +
            '" data-url="' + "{{ route('ajax.address.districts') }}" + '">' +
            ' <option value="">Chọn tỉnh/thành phố</option>' +
            "{!! $cities !!}" +
            '  </select>' +
            '  </div>' +
            '</div>' +
            '<div class="form-group">' +
            '<div class="item_col_left">' +
            '<label for="">Quận/huyện</label>' +
            '</div>' +
            '<div class="item_col_right">' +
            '<select name="district_id" required id="district" class="form-control" value="' +
            "{{ old('district_id') }}" + '" data-url="' + "{{ route('ajax.address.communes') }}" + '">' +
            ' <option value="">Chọn quận/huyện</option>' +
            ' </select>' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<div class="item_col_left">' +
            '<label for="">Tài chính</label>' +
            '</div>' +
            '<div class="item_col_right">' +
            '<input id="" type="text" placeholder="Tài chính" class="form-control ' + "@error('tai_chinh') is-invalid @enderror" +
            '" name="tai_chinh" value="' + "{{ old('tai_chinh') }}" + '" required autocomplete="tai_chinh" >' +
            '</div>' +
            '</div>' +
            ' </div>';
        //  htmlA=view('frontend.components.auth-address',['cities'=>$cities])->render();
        // console.log( $('.load-address').html());
        // $('.load-address').html(htmlA);
        $(document).on('change', '.changeType', function() {
            let val = $(this).val();
            if (val == 1) {
                $('.load-address').html(htmlA);
            } else {
                $('.load-address').html('');
            }
        });
    </script> --}}
@endsection
