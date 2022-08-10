@extends('layouts.admin')
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
	}
	.navbar-brand {
		font-size: 25px;
		font-weight:700; 
	}
	.container {
	}
	.card {
		background: #eee;
		margin-top: 50px;
	}
	.card-header {
		background: #0b8189;
		text-align: center;
		color: #fff;
	}
	.card-body {
	}
	.navbar-light .navbar-brand {
		color: #0b8189
	}
	label:not(.form-check-label):not(.custom-file-label) {
		font-weight: 600;
	}
	.btn-primary {
		background: #0b8189;
		border: 0;
		padding: 5px 20px;
	}
	.btn-link {
		font-weight: 400;
		color: #0b8189;
		font-size: 15px;
		text-decoration: none;
	}


    @media (max-width: 550px){
        .wrap-slide-home{
            display: none;
        }
    }


</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Đăng nhập hệ thống quản trị</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Use Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Mật khẩu</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Ghi nhớ đăng nhập
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Đăng Nhập
                                </button>
                                @if (Route::has('admin.password.request'))
                                    <a class="btn btn-link" href="{{ route('admin.password.request') }}">
                                        Quên mật khẩu?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
