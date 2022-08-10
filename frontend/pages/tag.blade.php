@extends('frontend.layouts.main')



@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')


@section('content')
    <div class="content-wrapper">
        <div class="main">
            <main id="main" class="main clearfix">
                <div class="main-in">
                    <div class="text-left wrap-breadcrumbs">

                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                
                                        <ul class="breadcrumb">
                                            <li class="breadcrumbs-item">
                                                <a href="{{ makeLink('home') }}">{{ __('home.home') }}</a>
                                            </li>
                                            
                                            <li class="breadcrumbs-item active"><a  class="currentcat">Tag</a></li>
                                            
                                        </ul>
                                </div>
                            </div>
                        </div>
                </div>
                    
                <div class="block-post">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 block-content-right">
                                <h1 class="title-template-news">{{ $slug }}</h1>
                                <div class="list-post">
                                    <div class="row">
                                        @if(isset($data)&&$data)
                                            @foreach ($data as $post)
                                            @php
                                                $tran=$post->translationsLanguage()->first();
                                                // $link = makeLink('post', [$post->id , $post->slug]);
                                            @endphp
                                                <div class="col-item-post col-lg-3 col-md-6 col-sm-6 col-sm-12">
                                                    <div class="item-post">
                                                        <div class="box">
                                                            <div class="image">
                                                                <a href="{{ route('post.detail', ['slug' => $tran->slug]) }}"><img src="{{ asset($post->avatar_path) }}" alt="{{ $tran->name ?? '' }}"></a>
                                                            </div>
                                                            <div class="content">
                                                                <div class="name"><a href="{{ route('post.detail', ['slug' => $tran->slug]) }}">{{ $tran->name }}</a></div>
                                                                <div class="desc">
                                                                    {{ $tran->description ?? '' }}
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

            </main>
        </div>


    </div>
@endsection
@section('js')

@endsection
