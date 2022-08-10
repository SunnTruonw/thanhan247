@php
    $activeHome = '';
    $activeSince = '';
    $activeProduct = '';
    $activePost = '';
    $activeContact = '';
    $routeCurrent = \Route::currentRouteName();
    switch ($routeCurrent) {
        case 'home.index':
            $activeHome = 'active';
            break;
        case 'product.index':
        case 'product.productByCategory':
        case 'product.detail':
            $activeProduct = 'active';
            break;
        case 'contact.index':
        case 'contact.index.en':
        case 'contact.index.ko':
            $activeContact = 'active';
            break;
        case 'post.index':
        case 'post.postByCategory':
        case 'post.detail':
            $activePost = 'active';
            break;
        case 'about-us':
        case 'about-us.en':
        case 'about-us.ko':
            $activeSince = 'active';
            break;
        default:
            # code...
            break;
    }
@endphp
<div class="menu_fix_mobile">
    <div class="close-menu">
        <a href="javascript:;" id="close-menu-button">
            <i class="fa fa-times" aria-hidden="true"></i>
        </a>
    </div>
    <ul class="nav-main">
		<li class="nav-item">
            <a href="{{ makeLink('home') }}">
                <i class="fas fa-home"></i>
            </a>
        </li>
		@include('frontend.components.menu',[
            'limit'=>2,
            'icon_d'=>'<i class="fa fa-angle-down mn-icon"></i>',
            'icon_r'=>'<i class="fa fa-angle-down mn-icon"></i>',
            'data'=>$header['menu_right1'],
            'active'=>false
        ])


        @include('frontend.components.menu',[
            'limit'=>3,
            'icon_d'=>'<i class="fa fa-angle-down mn-icon"></i>',
            'icon_r'=>'<i class="fa fa-angle-down mn-icon"></i>',
            'data'=>$header['menu_left'],
            'active'=>false
        ])
        @include('frontend.components.menu',[
        'limit'=>2,
        'icon_d'=>'<i class="fa fa-angle-down"></i>',
        'icon_r'=>"<i class='fa fa-angle-right'></i>",
        'data'=>$header['menu_right'],
        'active'=>false
        ])

        <li class="nav-item">
            <a href="{{ makeLinkToLanguage('contact', null, null, App::getLocale()) }}">
                <span>{{ __('home.lien_he') }}</span>
            </a>
        </li>
        {{--
            @guest
            <li class="nav-item ">
                <a href="{{ route('login') }}">
                    <span>{{ __('header.dang_nhap') }}</span>
                </a>
            </li>
            @else
            <li class="nav-item ">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span>{{ __('header.dang_nhap') }}</span>
                </a>
            </li>
            @endguest
        --}}
    </ul>
</div>
<div id="header" class="header">
    <div class="header-top-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-header-top-top">
                        <div class="box-social-header-top d-none d-md-block">
                            <div class="box-info">
                                @if( isset($header['address']) && $header['address']->count()>0)
                                <ul>
                                    <li class="title"><img src="{{ asset($header['address']->image_path) }}" alt="Hotline"> {{ $header['address']->slugL }}</li>
                                </ul>
                                @endif
                            </div>
                            <div class="hotline-header">
                                @if( isset($header['hotline']) && $header['hotline']->count()>0)
                                    <img src="{{ asset($header['hotline']->image_path) }}" alt="Email"> {{ $header['hotline']->slugL }}
                                @endif
                            </div>
                            {{-- <div class="form-s-desk">
                                <form action="{{ makeLink('search') }}" method="GET">
                                    <div class="input-group">
                                      <input type="text" class="form-control" name="keyword" placeholder="{{ __('header.keyword') }}">
                                      <div class="input-group-append">

                                        <button class="input-group-text"  type="submit"><i class="fas fa-search"></i></button>
                                      </div>
                                    </div>
                                  </form>
                            </div> --}}
                        </div>
                        <div class="box-social-header-top right">
							{{--
                            <div class="group-social">
                                @if( isset($header['socialParent']) && $header['socialParent']->count()>0)
                                <ul>
									<span>{{ __('header.ketnoi') }}</span>
                                    @foreach( $header['socialParent'] as $item)
                                    <li class="social-item"><a href="{{ $item->slugL }}" target="_blank" rel="noopener noreferrer"><img src="{{ asset($item->image_path) }}" alt="{{ $item->nameL }}"></a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>--}}
                            <div class="box-info hidden-xs hidden-sm">
                                <ul class="wrap-login">
                                    @guest
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-default" href="{{ route('register') }}"> <i class="fas fa-retweet"></i> Đăng ký</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-default" href="{{ route('login') }}"><i class="fas fa-sign-out-alt"></i> Đăng nhập</a>
                                        </li>
                                    @else
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                @if (Auth::guard('web')->check())
                                                    {{ Auth::guard('web')->user()->name }}
                                                @endif
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{ route('order_management.index') }}"><i class="fas fa-user mr-2"></i> Tài khoản của tôi</a>
                                                @if (Auth::guard('web')->check())
                                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        <i class="fas fa-sign-out-alt"></i> {{ 'Thoát' }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                @endif
                                            </div>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                            
							{{--<div class="language">
								 <span>{{ __('header.language') }} <i class="fas fa-hand-point-right"></i></span> 
								<ul>
									@foreach ($langConfig as $lang)
									<li><a href="{{ route('language.index',['language'=>$lang['value']]) }}"><img src="{{ asset($lang['image']) }}" alt="{{ asset($lang['name']) }}"></a></li>
									@endforeach
								</ul>
							</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-top d-none">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-header-top">
                        <div class="list-bar">
                            <div class="bar1"></div>
                            <div class="bar2"></div>
                            <div class="bar3"></div>
                        </div>
                        <div class="search_mobile">
                            <a><i class="fas fa-search"></i></a>
                        </div>
                        <div class="search" id="search">
                            <div class="form-s-mobile">
                                <form action="{{ makeLink('search') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="keyword" placeholder="{{ __('header.keyword') }}">
                                        <div class="input-group-append">
                                            <button class="input-group-text"  type="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <span class="close-search"><i class="fas fa-times"></i></span>
                            </div>
                        </div>
                        <div class="logo-head">
                            <div class="image">
                                <a href="{{ route('home.index') }}">
                                    <img src="{{ optional($header['logo'])->image_pathL }}" alt="{{ optional($header['logo'])->nameL }}">
                                </a>
                            </div>
                        </div>
                        <div class="box_bannertop">
                            @if ($header['title'])
                                @foreach ($header['title']->childLs()->where('settings.active', 1)->orderby('order')->latest()->get()
                                      as $item)
                                <div class="banner_top">
                                    <a href="{{ $item->slugL }}" target="_blank" rel="noopener">
                                        <img src="{{ $item->image_pathL }}" alt="{{ $item->nameL }}">
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="box-social-header-top d-md-none">
                            <div class="language">
                                <ul>
                                    @foreach ($langConfig as $lang)
                                    <li><a href="{{ route('language.index',['language'=>$lang['value']]) }}"><img src="{{ asset($lang['image']) }}" alt="{{ asset($lang['name']) }}"></a></li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-main">
        <div class="container">
            <div class="box-header-main">
                {{-- <span class="dm_menu">
                    <a href="">
                        <i class="fas fa-home"></i>
                    </a>
                </span>
                <div id="clock" class="smallfont" style="margin-left:5px;"></div> --}}
                <div class="list-bar">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <div class="menu menu-desktop">
                    <div class="logo-head">
                        <div class="image">
                            <a href="{{ route('home.index') }}">
                                <img src="{{ asset($header['logo']->image_path) }}" alt="logo">
                            </a>
                        </div>
                    </div>
                    <ul class="nav-main">
                        <li class="nav-item">
                            <a href="{{ makeLink('home') }}">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        @include('frontend.components.menu',[
                        'limit'=>2,
                        'icon_d'=>'<i class="fa fa-angle-down"></i>',
                        'icon_r'=>"<i class='fa fa-angle-right'></i>",
                        'data'=>$header['menu_right1'],
                        'active'=>false
                        ])
                        
                        @include('frontend.components.menu',[
                        'limit'=>2,
                        'icon_d'=>'<i class="fa fa-angle-down"></i>',
                        'icon_r'=>"<i class='fa fa-angle-right'></i>",
                        'data'=>$header['menu_left'],
                        'active'=>false
                        ])

                        @include('frontend.components.menu',[
                        'limit'=>2,
                        'icon_d'=>'<i class="fa fa-angle-down"></i>',
                        'icon_r'=>"<i class='fa fa-angle-right'></i>",
                        'data'=>$header['menu_right'],
                        'active'=>false
                        ])

						<li class="nav-item">
							<a href="{{ makeLinkToLanguage('contact', null, null, App::getLocale()) }}">
                                <span>{{ __('home.lien_he') }}</span>
                            </a>
						</li>
						{{--<li class="nav-item">
							<a href="#" style="background: #ea1e29; color: #fff; border-radius:3px; ">
                                <span><i class="fas fa-map-marker-alt"></i> Tra cứu bưu cục</span>
                            </a>
						</li>--}}
                    </ul>
					<div class="search_kh">
                        <form class="box_search_kh" method="get" action="{{ route('search.index') }}">
                            <input type="text" name="order_code" value="{{ old('order_code') }}" placeholder="Tra cứu vận đơn" required>
                            <button type="submit" name="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
