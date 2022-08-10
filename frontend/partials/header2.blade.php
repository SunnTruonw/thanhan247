<div class="menu_fix_mobile">
    <div class="close-menu">
        <a href="javascript:;" id="close-menu-button">
            <i class="fa fa-times" aria-hidden="true"></i>
        </a>
    </div>
    <ul class="nav-main">
        @include('frontend.components.menu',[
        'limit'=>3,
        'icon_d'=>'<i class="fa fa-angle-down mn-icon"></i>',
        'icon_r'=>'<i class="fa fa-angle-down mn-icon"></i>',
        'data'=>$header['menu'],
        'active'=>false
        ])
        @guest
        <li class="nav-item ">
            <a href="{{ route('login') }}">
                <span>Đăng nhập</span>
            </a>
        </li>
        @else
        <li class="nav-item ">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span>Đăng xuất</span>
            </a>
        </li>
        @endguest
    </ul>
</div>

{{-- <div id="header" class="header">

    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-header-top">
                        <div class="box-social-header-top">
                            <div class="box-info   d-none d-lg-block">
                                <ul>
                                    <li class="title">
                                        {{ $header['title']->value }}
                                        <a href="" class="xemngay">Xem ngay</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-social-header-top right">
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
                                                <a class="dropdown-item" href="{{ route('profile.index') }}"><i
                                                        class="fas fa-user mr-2"></i> Tài khoản của tôi</a>
                                                @if (Auth::guard('web')->check())
                                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                      document.getElementById('logout-form').submit();">
                                                        <i class="fas fa-sign-out-alt"></i> {{ 'Thoát' }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        class="d-none">

                                                        @csrf
                                                    </form>
                                                @endif
                                            </div>
                                        </li>
                                    @endguest
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
                <div class="list-bar">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <div class="logo-head">
                    <div class="image">
                        <a href="{{ makeLink('home') }}"><img src="{{ $header['logo']->image_path }}"></a>
                    </div>
                </div>

                <div class="menu menu-desktop">
                    <ul class="nav-main">
                        @include('frontend.components.menu',[
                        'limit'=>3,
                        'icon_d'=>'<i class="fa fa-angle-down"></i>',
                        'icon_r'=>"<i class='fa fa-angle-right'></i>",
                        'data'=>$header['menu'],
                        'active'=>true
                        ])
                        <li class="tuyendung">
                            <a href="{{ makeLink('tuyen-dung') }}">Tuyển giáo viên</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>


    <div id="search">
        <div class="wrap-search-header-main  search-mobile">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-search-header-main">
                            <div class="search-header">
                                <form id="formSearchMb" name="formSearchMb" method="GET"
                                    action="{{ makeLink('search') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="keyword"
                                            placeholder="Nhập từ khóa tìm kiếm...">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="form-control close-search" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
        </div>
    </div>
</div> --}}

<div id="header" class="header">
    <div class="header-top-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-header-top-top">
                        <div class="box-social-header-top">
                            <div class="box-info   d-none d-xl-block">
                                <ul>
                                    <li class="title">
                                        @php
                                        $d= \Carbon::now()->locale('vi_VI');

                                     @endphp

                                     <span class="time"> {{ ucfirst($d->dayName)  }}, ngày  {{ $d->format('d/n/Y') }}</span>
                                        {{ $header['title']->value }}
                                    </li>
                                </ul>
                            </div>
                            <div class="form-s-desk">
                                <form action="{{ makeLink('search') }}" method="GET">
                                    <div class="input-group">
                                      <input type="text" class="form-control" name="keyword" placeholder="Từ khóa">
                                      <div class="input-group-append">

                                        <button class="input-group-text"  type="submit"><i class="fas fa-search"></i></button>
                                      </div>
                                    </div>
                                  </form>
                            </div>
                        </div>
                        <div class="box-social-header-top right">
                            {{--
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
                                                <a class="dropdown-item" href="{{ route('profile.index') }}"><i
                                                        class="fas fa-user mr-2"></i> Tài khoản của tôi</a>
                                                @if (Auth::guard('web')->check())
                                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                      document.getElementById('logout-form').submit();">
                                                        <i class="fas fa-sign-out-alt"></i> {{ 'Thoát' }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        class="d-none">

                                                        @csrf
                                                    </form>
                                                @endif
                                            </div>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                            --}}
							<div class="language">
								<span>Ngôn ngữ <i class="fas fa-hand-point-right"></i></span>



									<ul>
									@foreach ($langConfig as $lang)
									<li><a href="{{ route('language.index',['language'=>$lang['value']]) }}"><img src="{{ asset($lang['image']) }}" alt="{{ asset($lang['name']) }}"></a></li>
									@endforeach


									 <li>
                                        <a href="">
                                            <img src="{{ asset('frontend/images/en.png') }}" alt="">
                                        </a>
                                    </li>

								</ul>

							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-top">
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
                            <a>
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                        <div class="search" id="search">
                            <div class="form-s-mobile">
                                <form action="{{ makeLink('search') }}" method="GET">
                                    <div class="input-group">
                                      <input type="text" class="form-control" name="keyword" placeholder="Từ khóa">
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
                                    <img src="{{ $header['logo']->image_path }}" alt="{{ $header['logo']->image_path }}">
                                </a>
                            </div>
                        </div>
                        <div class="box_bannertop">
                            @if ($header['title'])
                            @foreach ($header['title']->childs()->where('active', 1)->orderby('order')->latest()->get()
                                  as $item)
                                  @php
                                        $tranItem=($item->translationsLanguage()->first());
                                        if(!$tranItem){
                                            $tranItem=($item->translationsLanguage(config('languages.default'))->first());
                                        }
                                  @endphp
                            <div class="banner_top">
                                <a href="{{ $tranItem->slug }}" target="_blank" rel="noopener">
                                    <img src="{{ $item->image_path }}" alt="{{ $tranItem->name }}">
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
                                    <li>
                                        <a href="">
                                            <img src="{{ asset('frontend/images/en.png') }}" alt="">
                                        </a>
                                    </li>
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
                <span class="dm_menu">
                    <a href="">
                        <i class="fas fa-home"></i>
                    </a>
                </span>
                <div id="clock" class="smallfont" style="margin-left:5px;"></div>
                <div class="list-bar">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>

                <div class="menu menu-desktop">
                    <ul class="nav-main">
                        @include('frontend.components.menu',[
                        'limit'=>3,
                        'icon_d'=>'<i class="fa fa-angle-down"></i>',
                        'icon_r'=>"<i class='fa fa-angle-right'></i>",
                        'data'=>$header['menu'],
                        'active'=>true
                        ])
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function refrClock()
    {
    var d=new Date();
    var s=d.getSeconds();
    var m=d.getMinutes();
    var h=d.getHours();
    var day=d.getDay();
    var date=d.getDate();
    var month=d.getMonth();
    var year=d.getFullYear();
    var days=new Array("Chủ nhật,","Thứ 2,","Thứ 3,","Thứ 4,","Thứ 5,","Thứ 6,","Thứ 7,");
    var months=new Array("tháng 1,","tháng 2,","tháng 3,","tháng 4,","tháng 5,","tháng 6,","tháng 7,","tháng 8,","tháng 9,","tháng 10,","tháng 11,","tháng 12,");
    var am_pm;
    if (s<10) {s="0" + s}
    if (m<10) {m="0" + m}
    if (h>12) {h-=12;am_pm = "Chiều"}
    else {am_pm="Sáng"}
    if (h<10) {h="0" + h}
    document.getElementById("clock").innerHTML=days[day] + " ngày " + date + " " + months[month] + " " + year + ", " + h + ":" + m + ":" + s + " " + am_pm;
    setTimeout("refrClock()",1000);
    }
    refrClock();
</script>
