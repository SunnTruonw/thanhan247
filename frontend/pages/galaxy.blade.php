@extends('frontend.layouts.main')



@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')




@section('content')
    <div class="content-wrapper">
        <div class="main">
            @isset($breadcrumbs, $typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                'breadcrumbs'=>$breadcrumbs,
                'type'=>$typeBreadcrumb,
                ])
            @endisset
            @php
            $categoryTran=$category->translationsLanguage()->first();
            if(!$categoryTran){
                $categoryTran=($category->translationsLanguage(config('languages.default'))->first());
            }
             @endphp
            <h1 class="title-template-news d-none">{{ optional($categoryTran)->name ?? '' }}</h1>
            <div class="blog-news">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12 ">
                            <div class="title_in">
                                <h2><i class="fas fa-angle-double-right"></i> {{ optional($categoryTran)->name }}</h2>
                                {{-- <div class="date">
                                    @php
                                        $first = $category
                                            ->galaxys()
                                            ->where('active', 1)
                                            ->latest()
                                            ->first();
                                    if($first){
                                        $lastDate = $first->created_at;
                                        $tranFirst=optional($first)->translationsLanguage()->first();
                                    }
                                    @endphp
                                    {{ \Carbon::parse($lastDate)->format('l d/m/Y H:m:s') }}
                                    <i class="far fa-calendar-alt"></i>
                                </div> --}}
                            </div>
                            @isset($data)
                                    <div class="list-news list-playlist">
                                        <div class="row">
                                            @if ($typeView == 'category')
                                            @foreach ($data as $cate)

                                                <div class="col-galaxy-item col-lg-4 col-md-4 col-sm-6">
                                                    <div class="galaxy-item">
                                                        <div class="box">
                                                            <a href="{{ $cate->slug_full }}" class="bgw">
                                                                <div class="picpl">
                                                                    <img class="pic" src="{{ asset($cate->avatar_path) }}">
                                                                    <div class="cover">
                                                                        <span>{{ $cate->totalGalaxy() }}</span>
                                                                        <img class="pic"
                                                                            src="{{ asset('frontend/images/playlist.png') }}">
                                                                    </div>
                                                                    <p class="xem"><i class="fas fa-play"></i></p>
                                                                </div>
                                                                <div class="inf canhtrai">
                                                                    <h3>{{ $cate->nameL }}</h3>
                                                                    <p class="">
                                                                        <span class="fleft">
                                                                            {{ $cate->totalGalaxy() }} video
                                                                        </span>
                                                                        <span class="fright">
                                                                            {{ $cate->totalView() }} {{ __('galaxy-by-category.luot_xem') }}
                                                                        </span>
                                                                    </p>
                                                                    {{-- <p class="clear martop10 fleft"> {{ $cate->description }}
                                                                    </p> --}}
                                                                </div>
                                                            </a>


                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @elseif ($typeView=="galaxy")
                                                @foreach ($data as $galaxy)
                                                <div class="col-galaxy-item col-lg-4 col-md-4 col-sm-6">
                                                    <div class="galaxy-item">
                                                        <div class="box">
                                                            <a href="{{ $galaxy->slug_full }}" class="bgw">
                                                                <div class="picpl">
                                                                    <img class="pic" src="{{ asset($galaxy->avatar_path) }}">
                                                                    <p class="xem"><i class="fas fa-play"></i></p>
                                                                </div>
                                                                <div class="inf canhtrai">
                                                                    <h3>{{ $galaxy->nameL }}</h3>
                                                                    <p class="">
                                                                        <span class="fright">
                                                                            {{ $galaxy->view }} {{ __('galaxy-by-category.luot_xem') }}
                                                                        </span>
                                                                    </p>
                                                                    {{-- <p class="clear martop10 fleft"> {{ $galaxy->category->description }}
                                                                    </p> --}}
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
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
                        <div class="col-lg-3 col-sm-12 ">
                            @include('frontend.components.sidebar',[
                            "categoryGalaxy"=>$categoryGalaxy,
                            "categoryGalaxyActive"=>$categoryGalaxyActive,
                            "galaxy"=>true,
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
