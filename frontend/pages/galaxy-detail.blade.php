@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')

@section('css')

@endsection

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
                $tranData=$data->translationsLanguage()->first();
                if(!$tranData){
                    $tranData=($data->translationsLanguage(config('languages.default'))->first());
                }
            @endphp
            <div class="blog-news-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12">
                            <div class="news-detail">
                                {{-- <div class="title-detail">
                                    {{ $data->name }}
                                </div> --}}
                                <div class="title_in">
                                    <h2><i class="fas fa-angle-double-right"></i> {{ $tranData->name }}</h2>
                                </div>
                                <div class="news-detail-info">
                                    <ul style="justify-content: end;">
                                        <li><i class="far fa-calendar-alt"></i>
                                            {{ date_format($data->created_at, 'd/m/Y') }}</li>
                                        <li class="view-galaxy"> <i class="fas fa-eye"></i> {{ $data->view }} {{ __('galaxy-detail.xem') }}</li>

                                    </ul>
                                </div>

                                <div class="box_content">
                                    <div class="content-news">
                                        {!! $tranData->content !!}
                                    </div>
                                </div>

                                <div class="wrap-video">
                                    @if ($tranData->description)
                                    <iframe src="{{ asset($tranData->description) }}" frameborder="0"></iframe>
                                    @endif
                                </div>

                                @isset($dataRelate)
                                <div class="wrap-relate">
                                    <div class="title_in">
                                        <h2><i class="fas fa-angle-double-right"></i> {{ __('galaxy-detail.video_trong_playlist') }}</h2>
                                    </div>
                                    <div class="list-news list-playlist">
                                        <div class="row">
                                                @foreach ($dataRelate as $galaxy)
                                                  @php
                                                  $tranDataRelate=$galaxy->translationsLanguage()->first();
                                                  if(!$tranDataRelate){
                                                      $tranDataRelate=($galaxy->translationsLanguage(config('languages.default'))->first());
                                                  }
                                                   @endphp
                                                    <div class="col-galaxy-item col-lg-4 col-md-4 col-sm-6">
                                                        <div class="galaxy-item">
                                                            <div class="box">
                                                                <a href="{{ $galaxy->slug_full }}" class="bgw">
                                                                    <div class="picpl">
                                                                        <img class="pic" src="{{ asset($galaxy->avatar_path) }}">
                                                                        <p class="xem"><i class="fas fa-play"></i> {{ __('galaxy-detail.xem') }}</p>
                                                                    </div>
                                                                    <div class="inf canhtrai">
                                                                        <h3>{{ $tranDataRelate->name }}</h3>
                                                                        <p class="">
                                                                            <span class="fright">
                                                                                {{ $galaxy->view }} {{ __('galaxy-detail.luot_xem') }}
                                                                            </span>
                                                                        </p>
                                                                        {{-- <p class="clear martop10 fleft">
                                                                            {{ $galaxy->category->description }}
                                                                        </p> --}}
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                        </div>
                                    </div>
                                </div>
                                @endisset
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
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
    <script>
        $(function() {

            let normalSize = parseFloat($('#wrapSizeChange').css('fontSize'));
            $(document).on('click', '.prevSize', function() {
                let font = $('#wrapSizeChange').css('fontSize');
                console.log(parseFloat(font));
                let prevFont;
                if (parseFloat(font) <= 10) {
                    prevFont = parseFloat(font);
                } else {
                    prevFont = parseFloat(font) - 1;
                }
                $('#wrapSizeChange').css({
                    'fontSize': prevFont
                });
            });
            $(document).on('click', '.nextSize', function() {
                let font = $('#wrapSizeChange').css('fontSize');
                console.log(parseFloat(font));
                let nextFont;
                nextFont = parseFloat(font) + 1;
                $('#wrapSizeChange').css({
                    'fontSize': nextFont
                });
            });
            $(document).on('click', '.mormalSize', function() {
                $('#wrapSizeChange').css({
                    'fontSize': normalSize
                });
            });
        })
    </script>
    <script src="{{ asset('frontend/js/Comment.js') }}">
    </script>
    {{-- <script>
    console.log($('div').createFormComment());
</script> --}}
@endsection
