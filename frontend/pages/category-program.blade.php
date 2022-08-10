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
            <div class="block-program">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12  block-content-right">
                            <h1 class="title-template">
                                <span class="title-inner"><i class="fas fa-angle-double-right"></i>
                                    {{ $category->name ?? '' }} </span>
                            </h1>
                            @if (isset($typeView))
                                @if ($typeView == 'category')
                                    @isset($data)
                                        <div class="wrap-list-category">
                                            <div class="list-category-program">
                                                <div class="row">
                                                    @foreach ($data as $cate)
                                                        <div class="col-sm-12 col-category-program-item">
                                                            <div class="category-program-item">
                                                                <div class="box">
                                                                    {{-- <div class="image">
                                                                        <a href=""><img src="{{ asset($item->avatar_path) }}" alt="{{ $item->name }}"></a>
                                                                    </div> --}}
                                                                    <div class="content">
                                                                        <h3>
                                                                            <a href="{{ makeLink('category_programs', $cate->id, $cate->slug) }}">{{ $cate->name }}</a>
                                                                        </h3>
                                                                        @if ($cate->childs()->where('active',1)->count()>0)
                                                                            <ul>
                                                                                @foreach ($cate->childs()->where('active',1)->orderby('order')->orderByDesc('created_at')->get() as $cate2)
                                                                                <li>
                                                                                    <a href="{{ makeLink('category_programs',$cate->id, $cate->slug) }}"> <i class="fas fa-angle-double-right"></i> {{ $cate2->name }}</a>
                                                                                </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @else
                                                                            <ul>
                                                                                @foreach ($cate->programs()->where('active',1)->orderby('order')->orderByDesc('created_at')->get() as $program)
                                                                                <li>
                                                                                    <a href="{{  makeLink('program',$program->id, $program->slug) }}"><i class="fas fa-angle-double-right"></i> {{ $program->name }}</a>
                                                                                </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                        <div class="text-right">
                                                                            <a href="{{ makeLink('category_programs', $cate->id, $cate->slug) }}" class="btn-view-program">Xem chi tiết</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>
                                    @endisset
                                @else
                                    {{-- <div class="content-program mb-3">
                                        {!! $category->description ?? '' !!}
                                    </div> --}}
                                    <div class="col-category-program-item">
                                        <div class="category-program-item">
                                            <div class="box">
                                                {{-- <div class="image">
                                                    <a href=""><img src="{{ asset($item->avatar_path) }}" alt="{{ $item->name }}"></a>
                                                </div> --}}
                                                <div class="content">
                                                    <h3>
                                                        <a href="{{ makeLink('category_programs', $category->id, $category->slug) }}">{{ $category->name }}</a>
                                                    </h3>
                                                    <ul>
                                                        @foreach ($data as $program)
                                                        <li>
                                                            <a href="{{  makeLink('program',$program->id, $program->slug) }}"><i class="fas fa-angle-double-right"></i> {{ $program->name }}</a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="text-right">
                                                        <a href="{{ makeLink('category_programs', $category->id, $category->slug) }}" class="btn-view-program">Xem chi tiết</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if (count($data))
                                {{ $data->appends(request()->all())->links() }}
                            @endif
                        </div>

                        <div class="col-lg-3 col-sm-12 col-xs-12 block-content-left">
                            @include('frontend.components.sidebar',[
                            "categoryProgram"=>$categoryProgram,
                            "categoryProgramActive"=>$categoryProgramActive,
                            "program"=>true,
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

        })
    </script>
@endsection
