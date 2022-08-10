@extends('frontend.layouts.main')
@section('content')
<style>
	body {
		font-family: 'Open Sans', sans-serif;
		background-color: #fff!important;
	}
	@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap');
	.card-header {
		text-align: left;
		text-transform:uppercase;
		font-weight: 700;
		font-size: 20px;
		border: none;
		padding: 20px 0 5px 0 ;
	}
	.navbar-brand {
		font-size: 25px;
		font-weight:700;
	}
	.container {
	}
	.form-control {
		height: 40px !important;
		border-radius: 16px !important;
		font-size: 14px;
		background: white !important;
	}
	.card {
		padding: 30px;
		border-radius: 8px;
		margin-top: 30px;
		margin-bottom: 30px;
		background: var(--white);
		border: 1px solid #e8e8e8;
	}
	.card p {
		text-align: center;
		font-size: 15px;
		color: #c60001;
		font-weight: 600;
	}
	.card-header {
		background: #fff;
		text-align: center;
		color: #333;
	}
	.card-body {
	}
	.navbar-light .navbar-brand {
		color: #0b8189
	}
	label:not(.form-check-label):not(.custom-file-label) {
		font-weight: 600;
		display: inline-block;
		font-size: 14px;
	}
	.btn-primary {
		background: #ff000f;
		border: 0;
		padding: 5px 20px;
		width: 100%;
		border-radius: 16px;
		margin-bottom: 20px;
	}
	.btn-link {
		font-weight: 400;
		color: #ff000f;
		font-size: 15px;
		text-decoration: none;
	}

    .dky{
        font-size: 15px;
    }

    .dky a{
       color: #ff000f; 
    }

    .dky a:hover{
        text-decoration: underline;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #8b6546;
        border-color: #8b6546;
    }
	.main_login {
		background: #f5f6f7
	}
    
    .col-form-label{
        padding-bottom: 3px;
    }
	.wrap-breadcrumbs {
		margin-bottom: 0px;
	}
</style>
<div class="text-left wrap-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <ul class="breadcrumb">
                    <li class="breadcrumbs-item">
                        <a href="{{ makeLink('home') }}">Trang chủ</a>
                    </li>
                    <li class="breadcrumbs-item"><a href="javascript:;" class="currentcat">Đăng nhập</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="main_login">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6 col-md-6">
				<div class="card">
					<div class="card-header">Đăng nhập tài khoản</div>
					<p>Chào ngày mới! Cùng chốt nhiều đơn hôm nay nhé!</p>
					<div class="card-body">
						@isset($url)
						<form method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
						@else
						<form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
						@endisset
						{{-- <form method="POST" action="{{ route('login') }}"> --}}
							@csrf

							<div class="form-group row">
								<label for="username" class="col-md-12 col-form-label">Tài khoản</label>

								<div class="col-md-12">
									<input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Nhập tên tài khoản của bạn" required autocomplete="username" autofocus>

									@error('username')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="form-group row">
								<label for="password" class="col-md-6 col-form-label">Mật khẩu</label>
								@if (Route::has('password.request'))
								<a class="col-md-6" href="{{ route('password.request') }}" style="float: right; text-align: right; color: rgb(255, 99, 57); text-decoration: none; font-size: 13px; line-height: 30px;">Quên mật khẩu?</a>
									@endif
								<div class="col-md-12">
									<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Nhập mật khẩu của bạn" required autocomplete="current-password">
									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							{{--<div class="form-group row">
								<div class="col-md-12">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
										<label class="form-check-label" for="remember">
											Nhớ mật khẩu
										</label>
									</div>
								</div>
							</div>--}}

							<div class="form-group row mb-0">
								<div class="col-md-12 ">
									<button type="submit" class="btn btn-primary">
										Đăng Nhập
									</button>
									<div class="dky mt-2">
										<p>Bạn chưa có tài khoản <a href="{{ route('register') }}">Đăng ký ngay</a>.</p>
								   </div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
