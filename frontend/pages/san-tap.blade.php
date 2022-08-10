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

            @if( isset($hoc_gold) && $hoc_gold->count()>0)
            <div class="wrap-ss-1" style="background-image: url('{{ asset($hoc_gold->icon_path) }}');">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="box-content-text">
                                <div class="desc mb-3">
                                    <h2>{{ $hoc_gold->nameL }}</h2>
                                    {{ $hoc_gold->descriptionL }}
                                </div>
                                <div class="text-right">
                                    <a href="#" class="btn-detail btn btn-primary">{{ __('home.chi_tiet') }} >>></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if( isset($bang_gia) && $bang_gia->count()>0)
            <div class="bg-1">
                <div class="wrap-ss-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="box-text-ss-2">
                                         <h4>{{ $bang_gia->nameL }}</h4>
                                         <h2>{{ $bang_gia->nameL }}</h2>
                                          <div class="desc">
                                            {{ $bang_gia->descriptionL }}
                                          </div>
                                          <div class="text-left">
                                              <a href="" class="btn  btn-primary btn-detail">{{ __('home.bang_gia_san_tap') }}</a>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="image">
                                            <img src="{{ asset($bang_gia->icon_path) }}" alt="{{ $bang_gia->nameL }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="logo-home">
                    <span></span>
                    <img src="{{ asset($header['logo']->image_path) }}" alt="Logo">
                    <span></span>
                </div>
            </div>
            @endif

            
            @if( isset($why) && $why->count()>0)
            <div class="wrap-why-choose">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12 mb-3">
                            <div class="box-text-why">
                                <div class="title-why">{{ $why->nameL }}</div>
                                <div class="desc">
                                    {{ $why->descriptionL }}
                                </div>
                                <a href="" class="btn  btn-primary btn-detail">{{ __('home.dich_vu') }}</a>
                            </div>
                        </div>
                        @foreach($why->childLs()->where('category_posts.active','1')->orderBy('order')->get() as $item)
                        <div class="col-md-3 col-sm-6 col-12 col-item-why mb-3">
                            <div class="item-why">
                                <div class="box">
                                    <div class="icon">
                                        <img src="{{ asset($item->icon_path) }}" alt="{{ $item->nameL }}">
                                    </div>
                                    <div class="content">
                                        <h3>{{ $item->nameL }}</h3>
                                        <div class="desc">
                                            {{ $item->descriptionL }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

@endsection
@section('js')

@endsection
