@extends('frontend.layouts.main')

@section('title', __('search.ket_qua_tim_kiem'))
@section('keywords', __('search.ket_qua_tim_kiem'))
@section('description', __('search.ket_qua_tim_kiem'))
@section('image', asset(optional($header['seo_home'])->image_path))
@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="text-left wrap-breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <ul class="breadcrumb">
                                <li class="breadcrumbs-item">
                                    <a href="{{ makeLink('home') }}">{{ __('home.home') }}</a>
                                </li>
                                <li class="breadcrumbs-item"><a
                                    href=""
                                    class="currentcat">{{ __('search.tim_kiem') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrap-content-main wrap-template-product template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            @isset($dataPost)
                                @if ($dataPost)
                                    @if ($dataPost->count())
                                        <h3 class="title-template">{{ __('search.ket_qua_tim_kiem') }} </h3>
                                        <div class="wrap-list-product">
                                            <div class="list_news_col">
                                                    @foreach ($dataPost as $post)
                                                            <div class="item">
                                                                <div class="box">
                                                                    <div class="image">
                                                                        <a href="{{ $post->slug_full }}">
                                                                            <img src="{{ asset($post->avatar_path) }}" alt="{{ $post->nameL }}">
                                                                        </a>
                                                                    </div>
                                                                    <div class="info">
                                                                        <h3>
                                                                            <a href="{{ $post->slug_full }}">
                                                                                {{ $post->nameL }}
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
                                                                            {{ $post->descriptionL }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    @endforeach


                                            </div>
                                            <div class="col-md-12">
                                                @if (count($dataPost))
                                                    {{ $dataPost->appends(request()->all())->links() }}
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endisset

                        </div>
                        {{-- <div class="col-lg-12 col-sm-12">
                            @isset($dataPost)
                                @if ($dataPost)
                                    @if ($dataPost->count())
                                        <h3 class="title-template-news">{{ __('search.ket_qua_tim_kiem_tin_tuc') }}</h3>
                                        <div class="list-news">
                                            <div class="row">
                                                @foreach ($dataPost as $post)
                                                <div class="fo-03-news col-lg-4 col-md-6 col-sm-6">
                                                    <div class="box">
                                                        <div class="image">
                                                            <a href="{{ makeLink("post",$post->id,$post->slug) }}"><img src="{{ asset($post->avatar_path) }}" alt="{{ $post->name }}"></a>
                                                        </div>
                                                        <h3><a href="{{ makeLink("post",$post->id,$post->slug) }}">{{ $post->name }}</a></h3>
                                                        <div class="date">{{ date_format($post->updated_at,"d/m/Y")}} - Admin</div>
                                                        <div class="desc">
                                                            {!! $post->description  !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                @endforeach
                                            </div>
                                        </div>
                                        @if (count($dataPost))
                                        {{$dataPost->links()}}
                                        @endif
                                    @endif
                                @endif
                            @endisset
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
