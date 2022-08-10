@php
    $lang=\App::getLocale();
@endphp

<div class="main_right">
    {{--
    @if($sidebar['certificate'])
    <div class="certificate">
        @foreach($sidebar['certificate'] as $item)
        <div class="item">
            <a href="{{ $item->slug_full }}">
                <div class="box">
                    <div class="image">
                        <img src="{{ asset($item->avatar_path) }}">
                    </div>
                    <div class="info">
                        <h3>{{ $item->name }}</h3>
                        <div class="date_time">
                            <span>{{ \Carbon::parse($item->created_at)->format('d/m/Y') }}</span>
                            <span>{{ $item->view }} Lượt xem</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif

    --}}

    <div class="banner_quangcao">
        @if ($sidebar['bannerTop'])
            @foreach ($sidebar['bannerTop']->childLs()->where('settings.active', 1)->orderby('order')->latest()->limit('2')->get()
                  as $item)
                <a href="{{ $item->slugL??asset($item->fileL) }}"  rel="noopener">
                    <img src="{{ asset($item->image_pathL) }}" alt="{{ $item->nameL }}">
                </a>
            @endforeach

            @foreach ($sidebar['bannerTop']->childLs()->where('settings.active', 1)->where('settings.id','131')->limit('1')->get()
                  as $item)

            <div class="slide_banner autoplay">
                @foreach ($item->childLs()->where('settings.active', 1)->orderby('order')->latest()->get()
                  as $item2)
                <div class="image">
                    <a href="{{ $item2->slugL }}"  rel="noopener">
                        <img src="{{ asset($item2->image_pathL) }}" alt="{{ $item2->nameL }}">
                    </a>
                </div>
                @endforeach
            </div>
            @endforeach
        @endif
    </div>

    {{-- @if (isset( $sidebar['galaxy'])&& $sidebar['galaxy']->count()>0)
    <div class="box_video_sidebar">
        @php
            $videoF=$sidebar['galaxy']->first();
        @endphp

        <div class="side-bar">
            <div class="title-sider-bar">
                Video clip
            </div>
            <div class="video-s">
                <iframe src="{{ $videoF->description }}" frameborder="0"></iframe>
            </div>
            <div class="list-category">
                <ul class="menu-side-bar">
                    @foreach ($sidebar['galaxy'] as $item)
                    @php
                        $tran=$item->translationsLanguage()->first();
                    @endphp
                    <li class="nav_item">
                        <img src="{{ asset('frontend/images/play.png') }}" alt="{{ $tran->name }}">
                        <a href="{{ $item->slug_full }}"><span>{{ $tran->name }}</span></a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif --}}
{{--
    @if($sidebar['data_vanban'])
    <div class="box_vanban">
        <div class="image">
            <a href="{{ $sidebar['data_vanban']->slug_full }}">
                <img src="{{ asset($sidebar['data_vanban']->avatar_path) }}" alt="{{ $sidebar['data_vanban']->name }}">
            </a>
        </div>
    </div>
    @endif

    @if($sidebar['data_congtrinh'])
    <div class="box_congtrinh">
        <div class="image">
            <a href="{{ $sidebar['data_congtrinh']->slug_full }}">
                <img src="{{ asset($sidebar['data_congtrinh']->avatar_path) }}" alt="{{ $sidebar['data_congtrinh']->name }}">
            </a>
        </div>
    </div>
    @endif

    @if($sidebar['banner_bandoc'])
    <div class="box_bandoc">
        <div class="image">
            <a href="{{ asset($sidebar['banner_bandoc']->slug) }}">
                <img src="{{ asset($sidebar['banner_bandoc']->image_path) }}" alt="{{ $sidebar['banner_bandoc']->name }}">
            </a>
        </div>
    </div>
    @endif --}}

    {{--
    <div class="banner_quangcao">
        @if ($sidebar['bannerBot'])
            @foreach ($sidebar['bannerBot']->childs()->where('active', 1)->orderby('order')->latest()->get()
                 as $item)
                <a href="{{ $item->slug }}">
                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}">
                </a>
            @endforeach
        @endif
    </div>
    --}}

    <div class="newspaper">
        @if ($sidebar['bannerBot'])
            @foreach ($sidebar['bannerBot']->childLs()->where('settings.active', 1)->orderby('order')->latest()->get()
                 as $item)
                <div class="image-newspaper">
                    <a href="{{ asset($item->fileL) }}"  rel="noopener">
                        <img src="{{ asset($item->image_pathL) }}" alt="{{ $item->nameL }}">
                    </a>
                </div>
            @endforeach
        @endif

        @if($sidebar['new_certificate'])
        @if ($lang=='en')
        <div class="notice-newspaper">
            <ul>
                @foreach($sidebar['new_certificate'] as $item)
                <li>
                    <a class="a-title" href="{{ $item->slug_full }}" title="{{ $item->nameL }}">{{ $item->nameL }}<img src="{{ asset('/frontend/images/new.gif') }}"></a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        @endif
    </div>

    {{--
    @if ($sidebar['link_partner'])
    <div class="box_lienket">
        <div class="title-sider-bar">
                Tìm kiếm đối tác
        </div>
        <div class="news-donvithanhvien">
            <div class="cate-title">
                <select id="member" class="form-control website form-control-lienket">
                    <option value="0">-- Chọn đối tác --</option>
                    @foreach ($sidebar['link_partner']->childs()->where('active', 1)->orderby('order')->latest()->get()
                 as $item)
                    <option value="{{ $item->value }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @endif

    <script type="text/javascript">
        document.getElementById("member").onchange = function () {
            if (this.selectedIndex !== 0) {
                window.open(this.value, '_blank')
            }
        };
    </script>

    --}}

    {{--
    <div class="box_vanban">
        @guest
        <div class="title-sider-bar">
            <a href="{{ route('login') }}">
                Đăng nhập nội bộ
            </a>
        </div>
        @else
        <div class="title-sider-bar">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                      document.getElementById('logout-form').submit();">
                Đăng xuất
            </a>
        </div>
        @endguest
    </div>
    --}}



    <div class="banner_quangcao">
        @if ($sidebar['bannerBottom'])
            @foreach ($sidebar['bannerBottom']->childLs()->where('settings.active', 1)->orderby('order')->latest()->get()
                  as $item)

                @if ($lang=='en'&&$loop->first)
                @else
                <a href="{{ $item->slugL??asset($item->fileL) }}"  rel="noopener">
                    <img src="{{ asset($item->image_pathL) }}" alt="{{ $item->nameL }}">
                </a>
                @endif


            @endforeach
        @endif
    </div>

    {{--
    <div class="box_hoatdong">
        <div class="title-sider-bar">
            HOẠT ĐỘNG NỔI BẬT
        </div>
        @if (isset($sidebar['postHotFirst'])&&$sidebar['postHotFirst'])
        <div class="image">
            <a href="{{ $sidebar['postHotFirst']->slug_full }}">
                <img src="{{ $sidebar['postHotFirst']->avatar_path }}" alt="{{ $sidebar['postHotFirst']->name }}">
            </a>
        </div>
        @endif

        <div class="list_hoatdong">
            <ul>
                @if (isset($sidebar['postHot'])&&$sidebar['postHot'])
                @foreach ($sidebar['postHot'] as $item)
                <li><a href="{{ $item->slug_full }}">{{ $item->name }}</a></li>
                @endforeach
                @endif
            </ul>
        </div>
    </div>
    --}}
</div>







{{-- <div id="side-bar">
    @isset($post)
        @if ($post)
            <div class="side-bar">
                @foreach ($categoryPost as $categoryItem)
                    <div class="title-sider-bar">
                        {{ $categoryItem->name }}
                    </div>
                    <div class="list-category">
                        @include('frontend.components.category',[
                        'data'=>$categoryItem->childs()->orderby('order')->orderByDesc('created_at')->get(),
                        'type'=>"category_posts",
                        'categoryActive'=>$categoryPostActive,
                        $modelCategory=new \App\Models\CategoryPost(),
                        ])
                    </div>
                @endforeach
            </div>
        @endif
    @endisset

    @isset($exam)
        @if ($exam)
            @foreach ($categoryExam as $categoryItem)
                <div class="side-bar">
                    <div class="title-sider-bar">
                        {{ $categoryItem->name }}
                    </div>
                    <div class="list-category">
                        @include('frontend.components.category',[
                        'data'=>$categoryItem->childs()->orderby('order')->orderByDesc('created_at')->get(),
                        'type'=>"category_exams",
                        'categoryActive'=>$categoryExamActive,
                        $modelCategory=new \App\Models\CategoryExam(),
                        ])
                    </div>
                </div>
            @endforeach
        @endif
    @endisset

    @isset($program)
        @if ($program)
            @foreach ($categoryProgram as $categoryItem)
                <div class="side-bar">
                    <div class="title-sider-bar">
                        {{ $categoryItem->name }}
                    </div>
                    <div class="list-category">
                        @include('frontend.components.category',[
                        'data'=>$categoryItem->childs()->orderby('order')->orderByDesc('created_at')->get(),
                        'type'=>"category_programs",
                        'categoryActive'=>$categoryProgramActive,
                        $modelCategory=new \App\Models\CategoryProgram(),
                        ])
                    </div>
                </div>
            @endforeach
        @endif
    @endisset


    @isset($galaxy)
        @if ($galaxy)
            @foreach ($categoryGalaxy as $categoryItem)
                <div class="side-bar">
                    <div class="title-sider-bar">
                        {{ $categoryItem->name }}
                    </div>
                    <div class="list-category">
                        @include('frontend.components.category',[
                        'data'=>$categoryItem->childs()->orderby('order')->orderByDesc('created_at')->get(),
                        'type'=>"category_galaxies",
                        'categoryActive'=>$categoryGalaxyActive,
                        $modelCategory=new \App\Models\CategoryGalaxy(),
                        ])
                    </div>
                </div>
            @endforeach
        @endif
    @endisset
    @isset($faq)
        @if ($faq)
            @foreach ($categoryFaq as $categoryItem)
                <div class="side-bar">
                    <div class="title-sider-bar">
                        Hỏi đáp
                    </div>
                    <div class="list-category">
                        @include('frontend.components.category',[
                        'data'=>$categoryItem->childs()->orderby('order')->orderByDesc('created_at')->get(),
                        'type'=>"category_faqs",
                        'categoryActive'=>$categoryFaqActive,
                        'limit'=>2
                        ])
                    </div>
                </div>
            @endforeach
        @endif
    @endisset
</div> --}}
