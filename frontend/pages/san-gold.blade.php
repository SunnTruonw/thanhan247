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
                                    {{ $bang_gia->nameL }}
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

            @if( isset($bang_gia) && $bang_gia->count()>0)
            <div class="wrap-ss-1" style="background-image: url('{{ asset($bang_gia->icon_path) }}');">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="box-content-text">
                                <div class="desc mb-3">
                                    {{ $bang_gia->descriptionL }}
                                </div>
                                <div class="text-right">
                                    <a href="#" class="btn-detail btn btn-primary">{{ $bang_gia->nameL }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            
            @if( isset($dat_cho) && $dat_cho->count()>0)
            <div class="wrap-ss-2">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-ss-2">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="box-text-ss-2">
                                            <div class="desc">
                                                {{ $dat_cho->descriptionL }}
                                            </div>
                                            <div class="text-right">
                                                <a href="#" class="btn  btn-primary btn-detail">{{ $dat_cho->nameL }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="image">
                                            <img src="{{ asset($dat_cho->icon_path) }}" alt="{{ $dat_cho->nameL }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endif

            <div class="logo-home" style="background-color: #fff;">
                <span></span>
                    <img src="{{ asset($header['logo']->image_path) }}" alt="Logo">
                <span></span>
            </div>

            @if( isset($story) && $story->count()>0)
            <div class="wrap-info-choi-golf">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="group-title">
                                <div class="title">
                                    {{ $story->nameL }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-item-content">
                    @foreach($story->childLs()->where('category_posts.active','1')->orderBy('order')->get() as $item)
                    <div class="item-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box-content-item">
                                        <div class="title-sm">{{ $item->nameL }}</div>
                                        <div class="desc">
                                            {{ $item->descriptionL }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

@endsection
@section('js')

@endsection
