@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="main">

            @isset($breadcrumbs, $typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                'breadcrumbs'=>$breadcrumbs,
                'type'=>$typeBreadcrumb,
                ])
            @endisset
            
            @php
                $dataTran=$data->translationsLanguage()->first();
            @endphp
            <div class="block-post">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12">
                            <div class="news_detail_content">
                                <h1>{{ $dataTran->name }}</h1>
                                <div class="ngay_dang">
                                    {{ __('post.ngay_dang') }}: {{ \Carbon::parse($data->created_at)->format('d/m/Y | H:m') }}
                                </div>
                                {!!  optional($dataTran)->content  !!}
                                @foreach (config('paragraph.posts.type') as $typeKey => $typeParagraph)
                                    @if ($data->paragraphs()->where([['type', $typeKey], ['active', 1]])->count() > 0)
                                        <div class="box-link-paragraph">
                                            <ul>
                                                @include('frontend.components.paragraph',['typeKey'=>$typeKey,'data'=>$data])
                                            </ul>
                                        </div>
                                    @endif
                                @endforeach
                                
                                @foreach (config('paragraph.posts.type') as $typeKey => $typeParagraph)
                                    @if ($data->paragraphs()->where([['type', $typeKey], ['active', 1]])->count() > 0)
                                        <div class="list-content-paragraph">
                                            @include('frontend.components.paragraph-content',['typeKey'=>$typeKey,'data'=>$data])
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="hastag">
                                <div class="tags"><i class="fa fa-tags"
                                        aria-hidden="true"></i>Tags</div>
                                <div class="tags_product">
                                    
        
                                    @foreach ($data->tags as $item)
                                        <a class="tag_title" title="{{ $item->name }}"
                                            href="{{ route('post.tag', ['slug' => $item->name]) }}">{{ $item->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="share-article">
                                <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-591d2f6c5cc3d5e5"></script>
                                <div class="addthis_inline_share_toolbox"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12 col-xs-12">
                            <div id="side-bar">
                                {{--
                                @if( isset($tin_tuc) && $tin_tuc->count()>0)
                                <div class="side-bar">
                                    <div class="title-sider-bar">
                                        {{ $tin_tuc->nameL }}
                                    </div>
                                    <div class="list-category">
                                        <ul class="menu-side-bar">
                                            @foreach($tin_tuc->childLs()->where('category_posts.active','1')->orderBy('order')->get() as $item)
                                            <li class="nav_item">
                                                <a href="{{ $item->slug_full }}"><span>{{ $item->nameL }}</span></a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif
                                --}}

                                @if (isset($dataRelate)&&$dataRelate)
                                    
                                <div class="side-bar">
                                    <div class="title-sider-bar">
                                        {{ __('post.tin_tuc_lien_quan') }}
                                    </div>
                                    <div class="list-category list-new-sb">
                                        <ul class="menu-side-bar">
                                            @foreach ($dataRelate as $post)
                                            <li class="nav_item">
                                                <a href="{{ $post->slug_full }}"><span>{{ $post->nameL }}</span></a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif

                                @if( isset($dataHotAll) && $dataHotAll->count()>0)
                                <div class="side-bar">
                                    <div class="title-sider-bar">
                                        {{ __('home.tin_tuc_noi_bat') }}
                                    </div>
                                    <div class="list-category list-new-sb">
                                        <ul class="menu-side-bar">
                                            @foreach($dataHotAll as $item)
                                            <li class="nav_item">
                                                <a href="{{ $item->slug_full }}"><span>{{ $item->nameL }}</span></a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{--

            <div class="wrap_home">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="main_left">
                                <div class="news_detail">
                                    <div class="title_in">
                                        @php
                                        $categoryTran=$category->translationsLanguage()->first();
                                         @endphp
                                        <h2><i class="fas fa-angle-double-right"></i> {{ optional($categoryTran)->name }}</h2>
                                        <div class="date">
                                            {{ \Carbon::parse($createLatest)->format('l d/m/Y H:m') }}
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    @php
                                        $dataTran=$data->translationsLanguage()->first();
                                    @endphp
                                    <div class="box_info">
                                        <h1>

                                            {{ optional($dataTran)->name }}
                                        </h1>
                                        <div class="box_time">
                                            <div class="date_time">
                                                <i class="far fa-clock"></i>  {{ \Carbon::parse($data->created_at)->format('d/m/Y H:m') }}
                                            </div>
                                            <div class="views">
                                                <i class="far fa-eye"></i>
                                                {{ $data->view_ao }} {{ __('post-detail.luot_xem') }}
                                            </div>
                                        </div>
                                        <div class="fb-like">
                                            <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&width=120&layout=button&action=like&size=small&share=true&height=65&appId=623047861698063" width="120" height="65" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                                        </div>
                                    </div>
                                    <div class="description">
                                        @if ($data->nhan)
                                           <span class="nhan">TCCKVN</span>
                                        @endif
                                        {{ optional($dataTran)->description }}
                                    </div>
                                    <div class="content">
                                        {!!  optional($dataTran)->content  !!}
                                        {!!  optional($dataTran)->content2  !!}
                                    </div>
                                </div>

                                <div class="wrap-content-paragraph">
                                    @foreach (config('paragraph.posts.type') as $typeKey => $typeParagraph)
                                        @if ($data->paragraphs()->where([
                                            ['type', $typeKey],
                                        ['active', 1],
                                        ['parent_id',0]
                                        ])->count() > 0)
                                            <div>
                                                <div class="box-link-paragraph">
                                                    <div class="title-link-header"><i class="fas fa-align-justify"></i>
                                                    </div>
                                                    <ul>

                                                         @include('frontend.components.paragraph',['typeKey' => $typeKey,'data' => $data])
                                                    </ul>
                                                </div>
                                                <div class="list-content-paragraph">
                                                    @include('frontend.components.paragraph-content',['typeKey'=>$typeKey,'data'=>$data])
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="box_tags">
                                    <span>{{ __('post-detail.tu_khoa') }}:</span>
                                    @foreach ($data->tagsLanguage as $tag)
                                    <a >{{ $tag->name }}</a>
                                    @endforeach
                                </div>

                                <div class="news_home news_rale">
                                    <div class="title_in2">
                                        <h2><img src="{{ asset('frontend/images/icon_title.png') }}"> {{ __('post-detail.co_the_ban_quan_tam') }}</h2>
                                    </div>
                                    <div class="list_news_home">
                                        <div class="row">
                                            @if (isset($dataRelate)&&$dataRelate)
                                                @foreach ($dataRelate as $post)

                                                <div class="col-md-4 col-sm-6 col-12 item">
                                                    <div class="box">
                                                        <div class="image">
                                                            <a href="{{ $post->slug_full }}">
                                                                <img src="{{ asset($post->avatar_path) }}" alt="{{ $post->nameL }}">
                                                            </a>
                                                        </div>
                                                        <div class="info">
                                                            <h3>
                                                                <a href="{{ $post->slug_full }}">{{ $post->nameL }}</a>
                                                            </h3>
                                                            <div class="desc">
                                                               {{ $post->descriptionL }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </div>


                                @if (isset($banner)&&$banner)
                                @foreach ($banner->childLs()->where('settings.active',1)->orderby('order')->latest()->limit(5)->get() as $item)
                                <div class="banner_center">
                                    <div class="image">
                                        <a href="{{  $item->slugL }}">
                                            <img src="{{ $item->image_path }}" alt="{{ $item->nameL }}">
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            </div>
                            @include('frontend.components.sidebar',[
                                // "categoryPost"=>$categoryPost,
                                // "categoryPostActive"=>$categoryPostActive,
                                // "post"=>true,
                            ])
                        </div>
                    </div>
                </div>
            </div>

            --}}
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function() {

            let normalSize = parseFloat($('#wrapSizeChange').css('fontSize'));
            $(document).on('click', '.prevSize', function() {
                let font = $('#wrapSizeChange').css('fontSize');
                console.log(parseFloat(font));
                let prevFont;
                if (parseFloat(font) <= 10) {
                    prevFont = parseFloat(font);
                } else {
                    prevFont = parseFloat(font) - 1;
                }
                $('#wrapSizeChange').css({
                    'fontSize': prevFont
                });
            });
            $(document).on('click', '.nextSize', function() {
                let font = $('#wrapSizeChange').css('fontSize');
                console.log(parseFloat(font));
                let nextFont;
                nextFont = parseFloat(font) + 1;
                $('#wrapSizeChange').css({
                    'fontSize': nextFont
                });
            });
            $(document).on('click', '.mormalSize', function() {
                $('#wrapSizeChange').css({
                    'fontSize': normalSize
                });
            });
        })
    </script>
    <script src="{{ asset('frontend/js/Comment.js') }}">
    </script>
    {{-- <script>
    console.log($('div').createFormComment());
</script> --}}
@endsection
