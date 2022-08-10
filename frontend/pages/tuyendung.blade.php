@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')

@section('content')
    <div class="content-wrapper">
        <div class="main">

            {{-- @include('frontend.components.breadcrumbs',[
                'breadcrumbs'=>$breadcrumbs,
                'breadcrumbs'=>$breadcrumbs,
                'type'=>$typeBreadcrumb,
            ]) --}}

<div class="text-left wrap-breadcrumbs">

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                    <ul class="breadcrumb">
                        <li class="breadcrumbs-item">
                            <a href="{{ makeLink('home') }}">{{ __('home.home') }}</a>
                        </li>
                        @foreach ($breadcrumbs as $item)
                        <li class="breadcrumbs-item"><a href="{{ $item['slug'] }}" class="currentcat">{{  $item['name']  }}</a></li>
                        @endforeach
                    </ul>
            </div>
        </div>
    </div>
</div>


            @if ($data)

            <div class="blog-about-us">
                <div class="wrap-about-us">
                    <div class="container">
                        <div class="row d-flex before-after-unset">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                {{-- <div class="image-about-us">
                                    <img src="{{ $tuyenDung->avatar_path }}" alt="{{$tuyenDung->name}}">
                                </div> --}}
                                <div class="about-text">
                                    <div class="group-title">
                                        <div class="title title-red">
                                            {{$data->nameL}}
                                        </div>
                                    </div>
                                    <div class="desc-about">
                                       {!! $data->contentL !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection
@section('js')

@endsection
