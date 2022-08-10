@extends('frontend.layouts.main')



@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')


@section('content')
    <div class="content-wrapper">
        <div class="main">
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset
            <div class="wrap_home">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="main_left">
                                <div class="news_hot">
                                    <div class="title_in">
                                        @php
                                                $tranCategory=($category->translationsLanguage()->first());
                                                if(!$tranCategory){
                                                    $tranCategory=($category->translationsLanguage(config('languages.default'))->first());
                                                }
                                        @endphp
                                        <h2><i class="fas fa-angle-double-right"></i> {{ $tranCategory->name }}</h2>
                                        <div class="date">
                                            {{ \Carbon::parse($createLatest)->format('l d/m/Y H:m') }}
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    @if (isset($data)&&$data)
                                    @php
                                        $dataFirst=$data->first();
                                        $dataFirstTran=$dataFirst->translationsLanguage()->first();
                                        if(!$dataFirstTran){
                                            $dataFirstTran=($dataFirst->translationsLanguage(config('languages.default'))->first());
                                        }
                                    @endphp
                                        <div class="box_news_hot">
                                            <div class="image">
                                                <a href="{{ $dataFirst->slug_full }}">
                                                    <img src="{{ $dataFirst->avatar_path }}" alt="{{ $dataFirstTran->name }}">
                                                </a>
                                            </div>
                                            <div class="info">
                                                <h3>
                                                    <a href="{{ $dataFirst->slug_full }}">
                                                        {{ $dataFirstTran->name }}
                                                    </a>
                                                </h3>
                                                <div class="box_time">
                                                    <div class="date_time">
                                                        <i class="far fa-clock"></i>  {{ \Carbon::parse($dataFirst->created_at)->format('d/m/Y H:m') }}
                                                    </div>
                                                    <div class="views">
                                                        <i class="far fa-eye"></i>
                                                        {{ $dataFirst->view_ao }} {{ __('post-by-category.luot_xem') }}
                                                    </div>
                                                </div>
                                                <div class="desc">
                                                    {{ $dataFirstTran->description }}
                                                </div>

                                                <div class="view_more2">
                                                    <a href="{{ $dataFirst->slug_full }}">
                                                        {{ __('post-by-category.chi_tiet') }} >>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if (isset($category))
                                        @foreach ($category->paragraphs()->where('type',1)->where('active',1)->orderby('order')->latest()->limit(5)->get() as $item)
                                        @php
                                            $dataItem=$item->translationsLanguage()->first();
                                            if(!$dataItem){
                                                $dataItem=($item->translationsLanguage(config('languages.default'))->first());
                                            }
                                        @endphp
                                        <div class="banner_center">
                                            <div class="image">
                                                <a href="{{  $dataItem->name }}">
                                                    <img src="{{ asset($item->image_path) }}" alt="banner{{ $loop->index }}">
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                @endif


                                <div class="list_news_col">
                                    @if (isset($data)&&$data)
                                        @foreach ($data as $post)
                                            @if (!$loop->first)
                                                @php
                                                    $postTran=$post->translationsLanguage()->first();
                                                    if(!$postTran){
                                                        $postTran=($post->translationsLanguage(config('languages.default'))->first());
                                                    }

                                                    $link=$post->slug_full;
                                                @endphp
                                                <div class="item">
                                                    <div class="box">
                                                        <div class="image">
                                                            <a href="{{ $link }}">
                                                                <img src="{{ $post->avatar_path }}" alt="{{ $postTran->name }}">
                                                            </a>
                                                        </div>
                                                        <div class="info">
                                                            <h3>
                                                                <a href="{{ $link }}">
                                                                    {{ $postTran->name }}
                                                                </a>
                                                            </h3>
                                                            <div class="box_time">
                                                                <div class="date_time">
                                                                    <i class="far fa-clock"></i> {{ \Carbon::parse($post->created_at)->format('d/m/Y H:m') }}
                                                                </div>
                                                                <div class="views">
                                                                    <i class="far fa-eye"></i>
                                                                    {{ $post->view_ao }} {{ __('post-by-category.luot_xem') }}
                                                                </div>
                                                            </div>
                                                            <div class="desc">
                                                                {{ $postTran->description }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                    @endif
                                </div>
                                <div class="text-center">
                                    {{ $data->links() }}
                                </div>
                                {{-- <div class="view_all">
                                    <a href="">Xem tiếp <i class="fas fa-arrow-right"></i></a>
                                </div> --}}

                            </div>

                                @include('frontend.components.sidebar',[
                                    "categoryPost"=>$categoryPost,
                                    "categoryPostActive"=>$categoryPostActive,
                                    "post"=>true,
                                    ])
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
@section('js')
<script>

</script>
@endsection
