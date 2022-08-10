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
		width: 100%;
		justify-content: center;
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
	.form-check {
		font-size: 14px;
	}
	.form-check a {
		color: #ff000f
	}
	.padding_none {
		padding: 10px 0;
		text-align: center;
	}
	.form-group select {
		height: 40px !important;
		border-radius: 16px !important;
		font-size: 14px;
		padding: 5px 10px;
		background: white !important;
		width: 100%;
		border: 1px solid #ced4da
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
                    <li class="breadcrumbs-item"><a href="javascript:;" class="currentcat">Đăng ký tài khoản</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="main_login">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10 col-md-10">
				<div class="card">
					{{-- <div class="card-header">{{ __('Register') }}</div> --}}
					<div class="card-header"> {{ isset($url) ? ucwords($url) : ""}} TẠO TÀI KHOẢN</div>
					<p>Thành An 247 Luôn đồng hành cùng bạn</p>
					<div class="card-body">
						{{-- <form method="POST" action="{{ route('register') }}"> --}}
						@isset($url)
						<form method="POST" action='{{ url("register/$url") }}' aria-label="{{ __('auth.register') }}">
						@else
						<form method="POST" action="{{ route('register') }}" aria-label="{{ __('auth.register') }}">
						@endisset
							@csrf
						<div class="row">
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group row">
									<label for="name" class="col-md-12 col-form-label">Mục đích sử dụng</label>
									<div class="col-md-12">
										<select>
											<option value="0">Vui lòng chọn mục đích sử dụng</option>
											<option value="1">Cá nhân</option>
											<option value="1">Cửa hàng/doanh nghiệp</option>
										</select>
										@error('name')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group row">
									<label for="name" class="col-md-12 col-form-label">Họ và tên</label>
									<div class="col-md-12">
										<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Nhập tên Họ và tên" required autocomplete="name" >
										@error('name')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group row">
									<label for="email" class="col-md-12 col-form-label">Email</label>
									<div class="col-md-12">
										<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Nhập Email" autocomplete="email">

										@error('email')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group row">
									<label for="phone" class="col-md-12 col-form-label">Số điện thoại</label>
									<div class="col-md-12">
										<input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Nhập Số điện thoại" autocomplete="phone">

										@error('phone')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group row">
									<label for="address" class="col-md-12 col-form-label">Địa chỉ</label>
									<div class="col-md-12">
										<input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" placeholder="Nhập địa chỉ" autocomplete="address">

										@error('address')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>
							</div>
							
							
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group row">
									<label for="stk" class="col-md-12 col-form-label">Số tài khoản</label>
									<div class="col-md-12">
										<input id="stk" type="text" class="form-control @error('stk') is-invalid @enderror" name="stk" value="{{ old('stk') }}" placeholder="Nhập tài khoản" required autocomplete="stk" autofocus>
										@error('stk')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>
							</div>
							
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group row">
									<label for="username" class="col-md-12 col-form-label">Tài khoản đăng nhập</label>
									<div class="col-md-12">
										<input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Nhập tài khoản" required autocomplete="username" autofocus>
										@error('username')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>
							</div>
							
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group row">
									<label for="username" class="col-md-12 col-form-label">Chọn ngân hàng</label>
									<div class="col-md-12">
										<select name="ctk" id="ctk" class="form-control" required>
											<option value="">Chọn loại ngân hàng</option>
											<option value="(AGRIBANK) Nông nghiệp và phát triển nông thôn Việt Nam">(AGRIBANK) Nông nghiệp và phát triển nông thôn Việt Nam</option>
											<option value="(BIDV) Đầu tư và phát triển Việt Nam">(BIDV) Đầu tư và phát triển Việt Nam</option>
											<option value="(VIETINBANK) Công thương Việt Nam">(VIETINBANK) Công Thương Việt Nam</option>
											<option value="(VPBANK) Việt Nam Thịnh Vượng">(VPBANK) Việt Nam Thịnh Vượng</option>
											<option value="(ABBANK) An Bình">(ABBANK) An Bình</option>
											<option value="(ACB) Á Châu">(ACB) Á Châu</option>
											<option value="(BAC A) Bắc Á">(BAC A) Bắc Á</option>
											<option value="(BAO VIET BANK) Bảo Việt">(BAO VIET BANK) Bảo Việt</option>
											<option value="(CAKE) CAKE BY VPBANK">(CAKE) CAKE BY VPBANK</option>
											<option value="(CBBANK) Ngân hàng Xây dựng">(CBBANK) Ngân hàng Xây dựng</option>
											<option value="(CIMB) CIMB Bank Việt Nam">(CIMB) CIMB Bank Việt Nam</option>
											<option value="(Co-opBank) Hợp tác xã Việt Nam">(Co-opBank) Hợp tác xã Việt Nam</option>
											<option value="(DBS) Ngân hàng DBS - Chi nhánh Hồ Chí Minh">(DBS) Ngân hàng DBS - Chi nhánh Hồ Chí Minh</option>
											<option value="(DONG A BANK) Đông Á">(DONG A BANK) Đông Á</option>
											<option value="(EXIMBANK) Xuất Nhập khẩu">(EXIMBANK) Xuất Nhập khẩu</option>
											<option value="(GPBANK) Dầu khí toàn cầu">(GPBANK) Dầu khí toàn cầu</option>
											<option value="(HD BANK) Phát triển TP.HCM">(HD BANK) Phát triển TP.HCM</option>
											<option value="(HLBANK) Hong Leong Việt Nam">(HLBANK) Hong Leong Việt Nam</option>
											<option value="(HSBC) TNHH MTV HSBC Việt Nam">(HSBC) TNHH MTV HSBC Việt Nam</option>
											<option value="(IBK Bank) Công nghiệp Hàn Quốc">(IBK Bank) Công nghiệp Hàn Quốc</option>
											<option value="(IVB) Trách nhiệm hữu hạn Indovina">(IVB) Trách nhiệm hữu hạn Indovina</option>
											<option value="(KBHN) Ngân hàng Kookmin - Chi nhánh Hà Nội">(KBHN) Ngân hàng Kookmin - Chi nhánh Hà Nội</option>
											<option value="(KBHN) Ngân hàng Kookmin - Chi nhánh Hà Nội">(KBHN) Ngân hàng Kookmin - Chi nhánh Hà Nội</option>
											<option value="(KBank) NGÂN HÀNG ĐẠI CHÚNG TNHH KASIKORNBANK - CHI NHÁNH THÀNH PHỐ HỒ CHÍ MINH">(KBank) NGÂN HÀNG ĐẠI CHÚNG TNHH KASIKORNBANK - CHI NHÁNH THÀNH PHỐ HỒ CHÍ MINH</option>
											<option value="(KBHN) Ngân hàng Kookmin - Chi nhánh Hà Nội">(KBHN) Ngân hàng Kookmin - Chi nhánh Hà Nội</option>
											{{--  --}}
											<option value="(TPBank) Ngân hàng TMCP Tiên Phong">(TPBank) Ngân hàng TMCP Tiên Phong</option><option value="(KBHN) Ngân hàng Kookmin - Chi nhánh Hà Nội">(KBHN) Ngân hàng Kookmin - Chi nhánh Hà Nội</option>
											<option value="(Đông Á Bank, DAB) Ngân hàng TMCP Đông Á">(Đông Á Bank, DAB) Ngân hàng TMCP Đông Á</option>
											<option value="(SeABank) TMCP Đông Nam Á">(SeABank) TMCP Đông Nam Á</option>
											
											<option value="(ABBANK) Ngân hàng TMCP An Bình">(ABBANK) Ngân hàng TMCP An Bình</option>
											<option value="(BacABank) Ngân hàng TMCP Bắc Á">(BacABank) Ngân hàng TMCP Bắc Á</option>
											<option value="(VietCapitalBank) Ngân hàng TMCP Bản Việt">(VietCapitalBank) Ngân hàng TMCP Bản Việt</option>
											<option value="(MSB) Ngân hàng TMCP Hàng hải Việt Nam">(MSB) Ngân hàng TMCP Hàng hải Việt Nam</option>
											<option value="(Techcombank, TCB) Ngân hàng TMCP Kỹ Thương Việt Nam">(Techcombank, TCB) Ngân hàng TMCP Kỹ Thương Việt Nam</option>
											<option value="(KienLongBank) Ngân hàng TMCP Kiên Long">(KienLongBank) Ngân hàng TMCP Kiên Long</option>
											<option value="(Nam A Bank) Ngân hàng TMCP Nam Á">(Nam A Bank) Ngân hàng TMCP Nam Á</option>
											<option value="(National Citizen Bank, NCB) Ngân hàng TMCP Quốc Dân">(National Citizen Bank, NCB) Ngân hàng TMCP Quốc Dân</option>

											<option value="(VPBank) Ngân hàng TMCP Việt Nam Thịnh Vượng">(VPBank) Ngân hàng TMCP Việt Nam Thịnh Vượng</option>
											<option value="(HDBank) Ngân hàng TMCP Phát triển Thành phố Hồ Chí Minh">(HDBank) Ngân hàng TMCP Phát triển Thành phố Hồ Chí Minh</option>
											<option value="(Orient Commercial Bank, OCB) Ngân hàng TMCP Phương Đông">(Orient Commercial Bank, OCB) Ngân hàng TMCP Phương Đông</option>
											<option value="(Military Bank, MB) Ngân hàng TMCP Quân đội">(Military Bank, MB) Ngân hàng TMCP Quân đội</option>
											<option value="(PVcombank) Ngân hàng TMCP Đại chúng">(PVcombank) Ngân hàng TMCP Đại chúng</option>
											<option value="(VIBBank, VIB) Ngân hàng TMCP Quốc tế Việt Nam">(VIBBank, VIB) Ngân hàng TMCP Quốc tế Việt Nam</option>
											<option value="(SCB) Ngân hàng TMCP Sài Gòn">(SCB) Ngân hàng TMCP Sài Gòn</option>
											<option value="(SGB) Ngân hàng TMCP Sài Gòn Công Thương">(SGB) Ngân hàng TMCP Sài Gòn Công Thương</option>
											<option value="(SHB) Ngân hàng TMCP Sài Gòn - Hà Nội">(SHB) Ngân hàng TMCP Sài Gòn - Hà Nội</option>
											<option value="(STB) Ngân hàng TMCP Sài Gòn Thương Tín">(STB) Ngân hàng TMCP Sài Gòn Thương Tín</option>
											<option value="(VAB) Ngân hàng TMCP Việt Á">(VAB) Ngân hàng TMCP Việt Á</option>
											<option value="(BVB) Ngân hàng TMCP Bảo Việt">(BVB) Ngân hàng TMCP Bảo Việt</option>

											<option value="(Petrolimex Group Bank, PG Bank) Ngân Hàng TMCP Xăng Dầu Petrolimex">(Petrolimex Group Bank, PG Bank) Ngân Hàng TMCP Xăng Dầu Petrolimex</option>
											<option value="(EIB) Ngân Hàng TMCP Xuất Nhập khẩu Việt Nam">(EIB) Ngân Hàng TMCP Xuất Nhập khẩu Việt Nam</option>
											<option value="(LPB) Ngân Hàng TMCP Bưu điện Liên Việt">(LPB) Ngân Hàng TMCP Bưu điện Liên Việt</option>
											<option value="(VCB) Ngân Hàng TMCP Ngoại thương Việt Nam">(VCB) Ngân Hàng TMCP Ngoại thương Việt Nam</option>
											<option value="(CTG) Ngân Hàng TMCP Công Thương Việt Nam">(CTG) Ngân Hàng TMCP Công Thương Việt Nam</option>
											<option value="(VBSP) Ngân hàng Chính sách xã hội">(VBSP) Ngân hàng Chính sách xã hội</option>
											<option value="(VDB) Ngân hàng Phát triển Việt Nam">(VDB) Ngân hàng Phát triển Việt Nam</option>
											<option value="(CB) Ngân hàng Thương mại TNHH MTV Xây dựng Việt Nam">(CB) Ngân hàng Thương mại TNHH MTV Xây dựng Việt Nam</option>
											<option value="(Oceanbank) Ngân hàng Thương mại TNHH MTV Đại Dương">(Oceanbank) Ngân hàng Thương mại TNHH MTV Đại Dương</option>

											<option value="(GPBank) Ngân hàng Thương mại TNHH MTV Dầu Khí Toàn Cầu">(GPBank) Ngân hàng Thương mại TNHH MTV Dầu Khí Toàn Cầu</option>
											
											<option value=" Ngân hàng Oversea-Chinese Banking Corporation LTD"> Ngân hàng Oversea-Chinese Banking Corporation LTD</option>
											<option value="Ngân hàng Phát triển Châu Á và Việt Nam">Ngân hàng Phát triển Châu Á và Việt Nam</option>
											<option value=" Ngân hàng Phát triển Hàn Quốc (Hàn Quốc) tại Việt Nam"> Ngân hàng Phát triển Hàn Quốc (Hàn Quốc) tại Việt Nam</option>
											<option value="Ngân hàng Ogaki Kyoritsu (Nhật Bản) tại Việt Nam"> Ngân hàng Ogaki Kyoritsu (Nhật Bản) tại Việt Nam</option>
											<option value=" Ngân hàng Busan – (Hàn Quốc) tại Việt Nam"> Ngân hàng Busan – (Hàn Quốc) tại Việt Nam</option>
											<option value="Ngân hàng The Export-Import Bank of Korea (Hàn Quốc) tại Việt Nam">Ngân hàng The Export-Import Bank of Korea (Hàn Quốc) tại Việt Nam</option>
											<option value="Rothschild Limited (Singapore) tại Việt Nam">Rothschild Limited (Singapore) tại Việt Nam</option>
											<option value="Ngân hàng Indian Oversea Bank (Ấn Độ) tại Việt Nam">Ngân hàng Indian Oversea Bank (Ấn Độ) tại Việt Nam</option>
											<option value="Ngân hàng Bank of India (Ấn Độ) tại Việt Nam">Ngân hàng Bank of India (Ấn Độ) tại Việt Nam</option>
											<option value=" Ngân hàng Hana Bank (Hàn Quốc) tại Việt Nam"> Ngân hàng Hana Bank (Hàn Quốc) tại Việt Nam</option>
											<option value=" Kookmin Bank (Hàn Quốc) tại Việt Nam"> Kookmin Bank (Hàn Quốc) tại Việt Nam</option>
											<option value="Korea Exchange Bank (Hàn Quốc) tại Việt Nam">Korea Exchange Bank (Hàn Quốc) tại Việt Nam</option>
											<option value="Industrial Bank of Korea (Hàn Quốc) tại Việt Nam">Industrial Bank of Korea (Hàn Quốc) tại Việt Nam</option>
											<option value="Mitsubishi UFJ Lease & Finance Company Limited (Nhật) tại Việt Nam">Mitsubishi UFJ Lease & Finance Company Limited (Nhật) tại Việt Nam</option>
											<option value="Acom Co., Ltd (Nhật) tại Việt Nam">Acom Co., Ltd (Nhật) tại Việt Nam</option>
											<option value="Phongsavanh (Lào) tại Việt Nam">Phongsavanh (Lào) tại Việt Nam</option>
											<option value="RBI (Áo) tại Việt Nam">RBI (Áo) tại Việt Nam</option>
											<option value=" Fortis Bank (Bỉ) tại Việt Nam"> Fortis Bank (Bỉ) tại Việt Nam</option>
											<option value="Société Générale Bank – tại TP. HCM (Pháp) tại Việt Nam">Société Générale Bank – tại TP. HCM (Pháp) tại Việt Nam</option>
											<option value="Natixis Banque BFCE (Pháp) tại Việt Nam">Natixis Banque BFCE (Pháp) tại Việt Nam</option>
											<option value=" Ngân hàng E.Sun Commercial Bank (Đài Loan) tại Việt Nam"> Ngân hàng E.Sun Commercial Bank (Đài Loan) tại Việt Nam</option>
											<option value="Ngân hàng Taiwan Shin Kong Commercial Bank (Đài Loan) tại Việt Nam">Ngân hàng Taiwan Shin Kong Commercial Bank (Đài Loan) tại Việt Nam</option>
											<option value="The Shanghai Commercial and Savings Bank, Ltd (Đài Loan) tại Việt Nam">The Shanghai Commercial and Savings Bank, Ltd (Đài Loan) tại Việt Nam</option>
											<option value=" Land Bank of Taiwan (Đài Loan) tại Việt Nam"> Land Bank of Taiwan (Đài Loan) tại Việt Nam</option>
											<option value="Taishin International Bank (Đài Loan) tại Việt Nam">Taishin International Bank (Đài Loan) tại Việt Nam</option>
											<option value="Cathay United Bank (Đài Loan) tại Việt Nam">Cathay United Bank (Đài Loan) tại Việt Nam</option>

											<option value="Ngân hàng Hua Nan Commercial Bank, Ltd (Đài Loan) tại Việt Nam">Ngân hàng Hua Nan Commercial Bank, Ltd (Đài Loan) tại Việt Nam</option>
											<option value="Ngân hàng Union Bank of Taiwan (Đài Loan) tại Việt Nam">Ngân hàng Union Bank of Taiwan (Đài Loan) tại Việt Nam</option>
											<option value="Ngân hàng Chinatrust Commercial Bank (Đài Loan) tại Việt Nam">Ngân hàng Chinatrust Commercial Bank (Đài Loan) tại Việt Nam</option>
											<option value="Ngân hàng Bank Sinopac (Đài Loan) tại Việt Nam">Ngân hàng Bank Sinopac (Đài Loan) tại Việt Nam</option>
											<option value=" Ngân hàng Commerzbank AG (Đức) tại Việt Nam"> Ngân hàng Commerzbank AG (Đức) tại Việt Nam</option>
											<option value="Ngân hàng Landesbank Baden-Wuerttemberg (Đức) tại Việt Nam">Ngân hàng Landesbank Baden-Wuerttemberg (Đức) tại Việt Nam</option>
											<option value="Ngân hàng Unicredit Bank AG (Đức) tại Việt Nam">Ngân hàng Unicredit Bank AG (Đức) tại Việt Nam</option>
											<option value="Ngân hàng BHF – Bank Aktiengesellschaft (Đức) tại Việt Nam">Ngân hàng BHF - Bank Aktiengesellschaft (Đức) tại Việt Nam</option>
											<option value="Ngân hàng Wells Fargo (Mỹ) tại Việt Nam">Ngân hàng Wells Fargo (Mỹ) tại Việt Nam</option>
											<option value="Ngân hàng JPMorgan Chase Bank (Mỹ) tại Việt Nam">Ngân hàng JPMorgan Chase Bank (Mỹ) tại Việt Nam</option>
											<option value="Ngân hàng Intesa Sanpaolo (Italia) tại Việt Nam">Ngân hàng Intesa Sanpaolo (Italia) tại Việt Nam</option>
											<option value="Ngân hàng RHB (Malaysia) tại Việt Nam">Ngân hàng RHB (Malaysia) tại Việt Nam</option>
											<option value="Ngân hàng Woori bank Việt Nam">Ngân hàng Woori bank Việt Nam</option>
											<option value=" Ngân hàng World Bank Việt Nam"> Ngân hàng World Bank Việt Nam</option>
											<option value="Bangkok bank Việt Nam">Bangkok bank Việt Nam</option>
											<option value="Ngân Hàng Bnp Paribas">Ngân Hàng Bnp Paribas</option>

											<option value="Ngân hàng Commercial Siam Bank Việt Nam">Ngân hàng Commercial Siam Bank Việt Nam</option>
											<option value=" Ngân hàng Scotiabank"> Ngân hàng Scotiabank</option>
											<option value="Ngân Hàng Công Thương Trung Quốc (ICBC)">Ngân Hàng Công Thương Trung Quốc (ICBC)</option>
											<option value="Ngân hàng Maybank Việt Nam">Ngân hàng Maybank Việt Nam</option>
											<option value="Ngân hàng Bank of China">Ngân hàng Bank of China</option>
											<option value="United Overseas Bank">United Overseas Bank</option>
											<option value=" Ngân hàng Commonwealth Bank Việt Nam"> Ngân hàng Commonwealth Bank Việt Nam</option>
											<option value="Ngân hàng TNHH MTV Public Việt Nam">Ngân hàng TNHH MTV Public Việt Nam</option>
											<option value="Ngân hàng Sumitomo Mitsui Bank">Ngân hàng Sumitomo Mitsui Bank</option>
											<option value="Ngân hàng Tokyo-Mitsubishi UFJ">Ngân hàng Tokyo-Mitsubishi UFJ</option>

											<option value=" Ngân hàng Đầu tư và Phát triển Campuchia"> Ngân hàng Đầu tư và Phát triển Campuchia</option>
											<option value="Ngân hàng TNHH MTV Standard Chartered (Việt Nam)">Ngân hàng TNHH MTV Standard Chartered (Việt Nam)</option>
											<option value="Ngân hàng Tokyo-Mitsubishi UFJ">Ngân hàng Tokyo-Mitsubishi UFJ</option>
											<option value="Ngân hàng TNHH MTV Shinhan Việt Nam">Ngân hàng TNHH MTV Shinhan Việt Nam</option>
											<option value="Ngân hàng Hong Leong Việt Nam">Ngân hàng Hong Leong Việt Nam</option>
											<option value=" Ngân hàng Citibank Việt Nam"> Ngân hàng Citibank Việt Nam</option>
											<option value="Ngân hàng TNHH MTV ANZ (Việt Nam)">Ngân hàng TNHH MTV ANZ (Việt Nam)</option>
											<option value="Ngân hàng TNHH MTV HSBC (Việt Nam)">Ngân hàng TNHH MTV HSBC (Việt Nam)</option>
											<option value="Deutsche Bank Việt Nam">Deutsche Bank Việt Nam</option>

										</select>
										@error('ctk')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group row">
									<label for="password" class="col-md-12 col-form-label">Mật khẩu</label>
									<div class="col-md-12">
										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Tối thiểu 8 ký tự bao gồm chữ cái và số" required autocomplete="new-password">
										@error('password')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group row">
									<label for="password-confirm" class="col-md-12 col-form-label">Nhập lại mật khẩu</label>
									<div class="col-md-12">
										<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Tối thiểu 8 ký tự bao gồm chữ cái và số" required autocomplete="new-password">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 padding_none">
							<div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="" id="check">
                                <label class="form-check-label" for="check">Đồng ý với <a href="#">Điều khoản &amp; Điều kiện</a></label>
							</div>
						</div>
							<div class="form-group row mb-0">
								<div class="col-md-3"></div>
								<div class="col-md-6">
									<button type="submit" class="btn btn-primary">
										Đăng ký tài khoản
									</button>
									<div class="dky mt-2">
										<p>Bạn đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>.</p>
								   </div>
								</div>
								<div class="col-md-3"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
