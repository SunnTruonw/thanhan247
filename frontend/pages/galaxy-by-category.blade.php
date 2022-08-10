@extends('frontend.layouts.main')



@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')


@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{--
            @isset($breadcrumbs, $typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                'breadcrumbs'=>$breadcrumbs,
                'type'=>$typeBreadcrumb,
                ])
            @endisset
            --}}

            {{--
            <div class="blog-news">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12">
                            <div class="title_in">
                                @php
                                $categoryTran=$category->translationsLanguage()->first();
                                 @endphp
                                <h2><i class="fas fa-angle-double-right"></i> {{ optional($categoryTran)->name }}</h2>
                                <div class="date">
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
                                </div>
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
                                                                            {{ $cate->totalGalaxy() }} {{ __('galaxy-by-category.bai_hoc') }}
                                                                        </span>
                                                                        <span class="fright">
                                                                            {{ $cate->totalView() }} {{ __('galaxy-by-category.luot_xem') }}
                                                                        </span>
                                                                    </p>
                                                                    <p class="clear martop10 fleft"> {{ $cate->description }}
                                                                    </p>
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
                                                                    <p class="clear martop10 fleft">
                                                                        {{ $galaxy->category->description }}
                                                                    </p>
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
            --}}

            @php
                $modalGalaxy = new App\Models\Galaxy;
            @endphp

            @if($category->id == 2)
                <div class="block-galaxy">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="title-galaxy">
                                    {{ __('home.thu_vien_anh') }}
                                </div>
                                <div class="tab-galaxy mb-5">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#all" role="tab" aria-controls="home" aria-selected="true">All</a>
                                        </li>
                                        @if($category->childLs()->count()>0 )
                                            @foreach($category->childLs()->where([['category_galaxies.active', 1]])->orderby('order')->orderByDesc('created_at')->get() as $item)
                                            <li class="nav-item">
                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tab_{{ $item->id }}" role="tab" aria-controls="profile" aria-selected="false">{{ $item->nameL }}</a>
                                            </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="list-galaxy">
                                                <div class="row">
                                                    
                                                    @foreach( $dataAll as $imgItem )
                                                    <div class="col-galaxy-item col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <div class="galaxy-item">
                                                            <div class="box">
                                                                <a href="{{ asset($imgItem->avatar_path) }}" data-lightbox="image">
                                                                    <img src="{{ asset($imgItem->avatar_path) }}" alt="{{ $imgItem->nameL }}">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @if($category->childLs()->count()>0 )
                                            @foreach($category->childLs()->where([['category_galaxies.active', 1]])->orderby('order')->orderByDesc('created_at')->get() as $item)
                                            <div class="tab-pane fade" id="tab_{{ $item->id }}" role="tabpanel" aria-labelledby="home-tab">
                                                <div class="list-galaxy">
                                                    <div class="row">
                                                        @php
                                                            $image = $modalGalaxy->mergeLanguage()->where('galaxies.category_id', $item->id)->where('galaxies.active', 1)->orderby('order')->orderByDesc('created_at')->get();
                                                        @endphp
                                                        
                                                        @foreach( $image as $imgItem )
                                                        <div class="col-galaxy-item col-lg-3 col-md-4 col-sm-6 col-6">
                                                            <div class="galaxy-item">
                                                                <div class="box">
                                                                    <a href="{{ asset($imgItem->avatar_path) }}" data-lightbox="image">
                                                                        <img src="{{ asset($imgItem->avatar_path) }}" alt="{{ $imgItem->nameL }}">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
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
            @else
                <div class="block-galaxy">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="title-galaxy">
                                    {{ __('home.thu_vien_video') }}
                                </div>
                                @if(isset($data) && $data )
                                <div class="list-galaxy">
                                    <div class="row">
                                        
                                            @foreach($data as $item)
                                            <div class="col-galaxy-item col-lg-3 col-md-4 col-sm-6 col-6">
                                                <div class="galaxy-item">
                                                    <div class="box">
                                                        <a href="{{ $item->descriptionL }}" data-toggle="lightbox" data-type="youtobe" data-title="Video" data-gallery="listvideo">
                                                            <img class="" src="{{ asset($item->avatar_path) }}" alt="{{ $item->nameL }}">
                                                        </a>
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
