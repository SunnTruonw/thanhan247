@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')

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
                                @foreach ($breadcrumbs as $item)
                                    <li class="breadcrumbs-item"><a href="{{ $item['slug'] }}"
                                            class="currentcat">{{ $item['name'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @if( isset($san_gold) && $san_gold->count()>0)
            <div class="wrap-about-home">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-12">
                            <div class="group-title">
                                <div class="title">
                                    {{ $san_gold->nameL }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-12">
                                    <div class="box-text">
                                        {{ $san_gold->descriptionL }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-12">
                                    <div class="box-text">
                                        {!! $san_gold->contentL !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if( isset($ke_hoach) && $ke_hoach->count()>0)
            <div class="wrap-ss-1" style="background-image: url('{{ asset($ke_hoach->icon_path) }}');">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="box-content-text">
                                <div class="desc mb-3">
                                    <h2>{{ $ke_hoach->nameL }}</h2>
                                    {{ $ke_hoach->descriptionL }}
                                </div>
                                <div class="text-right">
                                    <a href="#" class="btn-detail btn btn-primary">{{ __('home.bang_gia_hoc_gold') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif            

            @if( isset($the_manh) && $the_manh->count()>0)
            <div class="wrap-the-manh">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="group-title">
                                <div class="title">
                                    {{ $the_manh->nameL }}
                                </div>
                            </div>
                            <div class="list-the-manh">
                                <div class="row">
                                    @foreach($the_manh->childLs()->where('category_posts.active','1')->orderBy('order')->get() as $item)
                                    <div class="col-item-the-manh col-lg-3 col-md-4 col-sm-6 col-12">
                                        <div class="item-the-manh">
                                            <div class="box">
                                                <div class="icon">
                                                    <img src="{{ asset($item->icon_path) }}" alt="{{ $item->nameL }}">
                                                </div>
                                                <div class="name">
                                                    {{ $item->nameL }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="logo-home">
                <span></span>
                <img src="{{ asset($header['logo']->image_path) }}" alt="Logo">
                <span></span>
            </div>

        </div>
    </div>

@endsection
@section('js')

@endsection
