@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{ dd($typeBreadcrumb) }}

            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset

            <div class="blog-news-detail">
                <div class="container">
                    <div class="row p-75 d-flex before-after-unset">
                        <div class="col-md-8 col-sm-12 col-xs-12 block-content-left p-75">
                            <div class="news-detail shadow padding-content">
                                <div class="title-detail">
                                    {{ $data->name }}
                                </div>
                                <div class="author">
                                    <div class="date">
                                        <div class="year">{{ date_format($data->created_at,"d/m/Y") }}</div>
                                    </div>
                                </div>
                                <div class="image">
                                    <img src=" {{ $data->avatar_path }}" alt="{{ $data->name }}">
                                </div>
                                <div class="box_content">

                                    <div class="content-news">

                                        {!! $data->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 block-content-right p-75" id="side-bar">
                            <div class="fix-sidebar">
                                <div class="side-bar shadow">
                                    <div class="title-sider-bar">
                                        <span>{{ __('tuyen-dung-detail.tin_tuc_noi_bat') }}</span>
                                    </div>
                                    <div class="list-trending">

                                        <ul>
                                            @isset($post_hot)
                                            @foreach ($post_hot as $item)
                                            <li>
                                                <div class="box">
                                                    <div class="icon">
                                                        <a href="{{ makeLink('post',$item->id,$item->slug) }}"><img src="{{ $item->avatar_path }}" alt="{{ $item->name }}"></a>
                                                    </div>
                                                    <div class="content">

                                                        <h3 class="name">
                                                            <a href="{{ makeLink('post',$item->id,$item->slug) }}">{{ $item->name }}</a>
                                                        </h3>
                                                        <div class="desc">
                                                            {{ $item->description }}
                                                        </div>
                                                        <div class="text-right">
                                                            <div class="date">
                                                                {{ date_format($item->created_at,"d/m/Y") }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                            @endisset
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @isset($dataRelate)
                        @if ($dataRelate)
                            @if ($dataRelate->count())
                                <div class="row p-75">
                                    <div class="col-xs-12  p-75">
                                        <div class="side-bar wrap-relate shadow">
                                            <div class="title-sider-bar">
                                                <span>{{ __('tuyen-dung-detail.tin_tuc_lien_quan') }}</span>
                                            </div>
                                            <div class="list-trending">
                                                <ul class="d-flex">
                                                    @foreach ($dataRelate as $item)
                                                    <li class="col-sm-6 col-xs-12">
                                                        <div class="box">
                                                            <div class="icon">
                                                                <a href="{{ makeLink('tuyen-dung-detail',$item->id,$item->slug)  }}"><img src="{{ $item->avatar_path }}" alt="{{ $item->name }}"></a>
                                                            </div>
                                                            <div class="content">

                                                                <h3 class="name">
                                                                    <a href="{{ makeLink('tuyen-dung-detail',$item->id,$item->slug) }}">{{ $item->name }}</a>
                                                                </h3>
                                                                <div class="desc">
                                                                    {{ $item->description }}
                                                                </div>
                                                                <div class="text-right">
                                                                    <div class="date">
                                                                        {{ date_format($item->created_at,"d/m/Y") }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endisset
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
@endsection
