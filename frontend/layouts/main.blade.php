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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="vi" />
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="abstract" content="@yield('abstract')" />
    <meta name="ROBOTS" content="Metaflow" />
    <meta name="ROBOTS" content="index, follow, all" />
    <meta name="AUTHOR" content="Bivaco" />
    <meta name="revisit-after" content="1 days" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta property="og:image" content="@yield('image')" />
    <meta property="og:image:alt" content="@yield('image')" />
<meta name="google-site-verification" content="KcJF8X03wJzLBzCY_mfMqavG3HtNQrON53lc6SH_mog" />

    <meta property="og:url" content="{{ makeLink('home') }}" />
    <meta property="og:type" content="article">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <link rel="canonical" href="{{ makeLink('home') }}" />
    <link rel="shortcut icon" href="{{URL::to('/favicon.ico')}}" />
    <script type="text/javascript" src="{{ asset('lib/jquery/jquery-3.2.1.min.js') }} "></script>




    <!--
    <link rel="stylesheet" href="{linkhost}/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{linkhost}/css/lightbox.min.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/animate.css" type="text/css" />
    <link href="{linkhost}/css/slick.css" rel="stylesheet" />
    <link href="{linkhost}/css/slick-theme.css" rel="stylesheet" />
    <link rel="stylesheet" href="{linkhost}/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    -->

    <!--
    <link rel="stylesheet" href="{linkhost}/css/stylesheet-2.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/header.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/footer.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/cart.css" type="text/css" />
    -->


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/bootstrap-4.5.3-dist/css/bootstrap.min.css') }}">

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.13.1/css/all.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.13.1/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/wow/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/lightbox-plus/css/lightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/ekko-lightbox/css/ekko-lightbox.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/stylesheet-2.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/stylesheet.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/footer.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/cart.css') }}">

    @yield('css')
</head>

<body class="template-search">
    <div class="wrapper home">
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                                    {{-- @if (Auth::guard('admin')->check())
                                    {{ Auth::guard('admin')->user()->name }}
                                    @else --}}
                                    {{-- @if(Auth::guard('web')->check())
                                    {{ Auth::guard()->user()->name }}
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    {{-- @if (Auth::guard('admin')->check())
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                     {{ __('Logout') }}
                                     </a>
                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none"> --}}
                                    {{-- @if(Auth::guard('web')->check())
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                     {{ __('Logout') }}
                                     </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @endif
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}
        <!-- Navbar -->
        @include('frontend.partials.header')
        <!-- /.navbar -->

        @yield('content')

        @include('frontend.partials.footer')


    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->


    <script type="text/javascript" src="{{ asset('lib/lightbox-plus/js/lightbox-plus-jquery.min.js') }}"></script>

    <!-- Bootstrap 3 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="{{ asset('lib/bootstrap-4.5.3-dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/wow/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/slick-1.8.1/js/slick.min.js') }}"></script>
    <script src="{{asset('lib/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('lib/ekko-lightbox/js/ekko-lightbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('lib/components/js/Cart.js') }}"></script>
    <script src="{{ asset('lib/components/js/Compare.js') }}"></script>
    <script>
        new WOW().init();
        $(function() {
            $(document).on('click','.pt_icon_right',function(){
                event.preventDefault();
                $(this).parent('a').parent('li').children("ul").slideToggle();
                $(this).parent('a').parent('li').toggleClass('active');
            })
            // $('.btn-dathangngay').click(function() {
            //     $(this).parents('.modal').find('.close').trigger('click');
            // })

            // $('.pt_icon_share .btn-share').click(function() {
            //     $(this).parents('.pt_icon_share').find('.share').toggle();
            // })
            // $('.wrap-tab-pig-meat .wrap-navbar-tab .nav-tabs>li>a').click(function() {
            //     let url = $(this).attr('image');
            //     $("#image-pig").attr("src", "" + url);
            // })
            // $('.wrap-product-popup .wrap-navbar-tab .nav-tabs>li>a').click(function() {
            //     let url = $(this).attr('image');
            //     $("#image-pig-2").attr("src", "" + url);

            //     $(this).parents('.nav-tabs').find('li').removeClass('active');
            //     $(this).parent('li').addClass('active');
            //     console.log(url);
            // })
            // $('.quantity .prev').click(function() {
            //     let input = $(this).parents('.number').find("input[type='number']");
            //     let value = parseFloat(input.val());
            //     if (value < 1) {
            //         input.val(0);
            //     } else {
            //         input.val(value - 1);
            //     }
            // })
            // $('.quantity .next').click(function() {
            //     let input = $(this).parents('.number').find("input[type='number']");
            //     let value = parseFloat(input.val());
            //     input.val(value + 1);
            // })

            // $(".side-bar .menu-side-bar-leve-2").each(function() {
            //     let length = $(this).find(".nav_item1").length;
            //     if (length) {
            //         $(this).prev("a").append("<i class='fa fa-angle-right pt_icon_right'></i>");
            //     }
            // })
            // $(".pt_icon_right").click(function() {
            //     event.preventDefault();
            //     $(this).parents(".menu-side-bar .nav_item").find(".menu-side-bar-leve-2").slideToggle();
            //     $(this).parents(".menu-side-bar .nav_item").toggleClass('active');
            // })

            // $(".side-bar .menu-side-bar-leve-3").each(function() {
            //     let length = $(this).find(".nav_item2").length;
            //     if (length) {
            //         $(this).prev("a").append("<i class='fa fa-angle-right pt_icon_right2'></i>");
            //     }
            // })
            // $(".pt_icon_right2").click(function() {
            //     event.preventDefault();
            //     $(this).parents(".menu-side-bar .nav_item1").find(".menu-side-bar-leve-3").slideToggle();
            //     $(this).parents(".menu-side-bar .nav_item1").toggleClass('active');
            // })
            // $('.user>a').click(function() {
            //     event.preventDefault();
            //     $(this).parents('.user').find('.dropdown-menu-list').slideToggle();
            // });

        });
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>

    

    @yield('js')

</body>
</html>
