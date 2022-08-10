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
                                <li class="breadcrumbs-item">
                                    <a href="{{ makeLink($typeBreadcrumb,'','') }}" class="currentcat">Hỏi đáp</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <h1 class="title-template-news d-none">Hỏi đáp</h1>
            <div class="blog-news">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12 block-content-right">
                            <h1 class="title-template">
                                <span class="title-inner"><i class="fas fa-angle-double-right"></i>
                                    Hỏi đáp </span>
                            </h1>
                            @isset($data)
                                    <div class="list-news list-playlist">
                                        <div class="row">
                                            @foreach ($data as $cate)
                                                <div class="col-faq-item col-lg-4 col-md-4 col-sm-6">
                                                    <div class="faq-item">
                                                        <div class="box">
                                                            <div class="image">
                                                                <a href="{{ makeLink('category_faqs',['id'=>$cate->id,'slug'=>$cate->slug]) }}"><img src="{{ asset($cate->avatar_path) }}" alt="{{ $cate->name }}">
                                                                    <span class="text">
                                                                        {{ $cate->name }}
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                <div class="pagination-group">
                                    <div class="pagination">
                                        @if (count($data))
                                            {{ $data->links() }}
                                        @endif
                                    </div>
                                </div>
                            @endisset
                        </div>
                        <div class="col-lg-3 col-sm-12  block-content-left">
                            @include('frontend.components.sidebar',[
                            "categoryFaq"=>$categoryFaq,
                            "categoryFaqActive"=>$categoryFaqActive,
                            "faq"=>true,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- <script>
        $(function() {
            $(document).on('click', '.pt_icon_right', function() {
                event.preventDefault();
                $(this).parentsUntil('ul', 'li').children("ul").slideToggle();
                $(this).parentsUntil('ul', 'li').toggleClass('active');
            })
        })
    </script> --}}
@endsection
