<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title') </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="vi" />
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="abstract" content="@yield('abstract')" />
    <meta name="ROBOTS" content="Metaflow" />
    <meta name="ROBOTS" content="noindex, nofollow, all" />
    <meta name="AUTHOR" content="Bivaco" />
    <meta name="revisit-after" content="1 days" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta property="og:image" content="@yield('image')" />
    <meta property="og:image:alt" content="@yield('image')" />

    <meta property="og:url" content="{{ makeLink('home') }}" />
    <meta property="og:type" content="article">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <link rel="canonical" href="{{ makeLink('home') }}" />
    <link rel="shortcut icon" href="{{ URL::to('/favicon.ico') }}" />
    <script type="text/javascript" src="{{ asset('lib/jquery/jquery-3.2.1.min.js') }} "></script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/bootstrap-4.5.3-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.13.1/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/wow/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/lightbox-plus/css/lightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/reset.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/stylesheet-2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/profile.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/footer.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/cart.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/loader.css') }}">
    <script type="text/javascript" src="{{ asset('lib/jquery/jquery-3.2.1.min.js') }} "></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    @yield('css')
	<style>
		@media (min-width:1200px) {
			.container{
				width: 100%;
				max-width: 1250px;
			}
		}
	</style>
</head>

<body class="template-search">
    <div class="wrapper home">
        @include('frontend.partials.header')
        <div class="wrap-profile-container">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2 bg-left">
                        <div id="sidebar-profile" class="pt-3 pb-3">
                            <div class="avatar text-center p-3">
                                <a href="{{ route('profile.editInfo') }}">
                                    <img src="{{ $user->avatar_path ? $user->avatar_path : $shareFrontend['userNoImage'] }}"
                                        alt="{{ $user->name }}" class="mb-3 rounded-circle profile-avatar">
                                    <h4>{{ $user->name }}</h4>
                                </a>
                            </div>
							
                            <nav class="mt-2">
                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                    data-accordion="false">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.editInfo') }}">
                                            <i class="fas fa-edit"></i>
                                            <p> {{ __('main-profile.chinh_su_thong_tin') }} </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('order_management.index') }}">
                                            <i class="fas fa-store"></i>
                                            <p> {{ __('main-profile.quan_ly_don_hang') }} </p>
                                        </a>
                                    </li>
									<li class="nav-item">
                                        <a class="nav-link" href="{{ route('csv_management.index') }}">
                                            <i class="fas fa-file-excel"></i>
                                            <p> Lên đơn Excel </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('order_management.history') }}">
                                            <i class="fa fa-history"></i>
                                            <p> Lịch sử giao dịch </p>
                                        </a>
                                    </li>
									<li class="nav-item">
                                        <a class="nav-link" href="{{ route('update.password.get') }}">
                                            <i class="fas fa-key"></i>
                                            <p> Đổi mật khẩu </p>
                                        </a>
                                    </li>
									<li class="nav-item">
                                       <a class="nav-link" href="#">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <p> Đăng xuất </p>
                                        </a>
                                    </li>
									{{-- 
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ makeLinkToLanguage('about-us', null, null, \App::getLocale()) }}">
                                            <i class="fas fa-list"></i>
                                            <p>{{ __('main-profile.huong_dan_nap_diem') }} </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.listTask') }}">
                                            <i class="fas fa-list"></i>
                                            <p> Danh sách bài thi đã làm </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.listFaq') }}">
                                            <i class="fas fa-list"></i>
                                            <p> Danh sách câu hỏi của bạn </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.listFaqFollow') }}">
                                            <i class="fas fa-list"></i>
                                            <p> Danh sách câu hỏi bạn theo dõi </p>
                                        </a>
                                    </li> --}}
                                </ul>
                            </nav>

                        </div>
                    </div>
                    <div class="col-sm-10">
                        @yield('content')
                    </div>
                </div>
            </div>

        </div>


        @include('frontend.partials.footer')


    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->


    <script type="text/javascript" src="{{ asset('lib/lightbox-plus/js/lightbox-plus-jquery.min.js') }}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="{{ asset('lib/bootstrap-4.5.3-dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/wow/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/slick-1.8.1/js/slick.min.js') }}"></script>
    <script src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/main.js') }}"></script>
    {{-- <script>
            $(window).on("load", function() {
            "use strict";
            /* ===================================
                    Loading Timeout
             ====================================== */

            setTimeout(function() {
                $(".loader").fadeOut("slow");
            }, 500);

        });
    </script> --}}
    
    @yield('js')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script>
        @if (Session::has('message'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
            toastr.success("{{ session('message') }}");
        @endif
        @if (Session::has('error'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
            toastr.error("{{ session('error') }}");
        @endif
    </script>
</body>

</html>
