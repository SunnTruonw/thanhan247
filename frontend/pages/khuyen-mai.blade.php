@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')


@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{--
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset
            --}}

            @if (isset($dataHot) && $dataHot)
            <div class="block-khuyen-mai">
                <div class="ss-km-1">
                    <div class="list-km">
                        <div class="item-tien-ich">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-12">
                                        <div class="title-top">
                                            <div class="text">
                                                {{ $dataHot->nameL }}
                                            </div>
                                            <div class="sale-km">
                                                Giảm <span>60</span>%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-12">
                                        <div class="box-tien-ich">
                                            <div class="left">
                                                <div class="box-text">
                                                    {{ $dataHot->descriptionL }}
                                                </div>
                                                <div class="text-left">
                                                    <a href="{{ $dataHot->slug_full }}" class="btn btn-xemthem">{{ __('home.xem_them') }} <i class="fas fa-minus"></i></a>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <div class="image">
                                                    <a href="{{ $dataHot->slug_full }}"><img src="{{ asset($dataHot->avatar_path) }}" alt="{{ $dataHot->nameL }}"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-1">
                <div class="wrap-post-2">
                    <div class="container">
                        <div class="row">
                            @if (isset($data)&&$data)
                                @foreach ($data as $post)
                                    <div class="col-item-post col-item-post-2 col-lg-4 col-md-6 col-sm-6 col-sm-6 col-12">
                                        <div class="item-post">
                                            <div class="box">
                                                <div class="image">
                                                     <a href="{{ $post->slug_full }}"><img src="{{ asset($post->avatar_path) }}" alt="{{ $post->nameL }}"></a>
                                                </div>
                                                <div class="content">
                                                    <div class="name"><a href="{{ $post->slug_full }}">{{ $post->nameL }}</a></div>
                                                    <div class="desc">
                                                        {{ $post->descriptionL }}
                                                    </div>
                                                    <div class="text-center">
                                                        <a href="{{ $post->slug_full }}" class="link-detail">{{ __('home.chi_tiet') }} <i class="fas fa-long-arrow-alt-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')

@endsection
