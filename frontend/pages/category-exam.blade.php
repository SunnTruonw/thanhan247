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
            <div class="block-exam">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-sm-12  block-content-right">
                            <h1 class="title-template">
                                <span class="title-inner"><i class="fas fa-angle-double-right"></i>
                                    {{ $category->name ?? '' }} </span>
                            </h1>
                            @if (isset($typeView))
                                @if ($typeView == 'category')
                                    @isset($data)
                                        <div class="wrap-list-category">
                                            <div class="list-category-exam">
                                                <div class="row">
                                                    @foreach ($data as $item)
                                                        <div class="col-sm-12 col-category-item">
                                                            <div class="category-item">
                                                                <div class="box">
                                                                    {{-- <div class="image">
                                                                        <a href=""><img src="{{ asset($item->avatar_path) }}" alt="{{ $item->name }}"></a>
                                                                    </div> --}}
                                                                    <div class="content">
                                                                        <h3><a
                                                                                href="{{ makeLink('category_exams', $item->id, $item->slug) }}">{{ $item->name }}</a>
                                                                        </h3>
                                                                        <div class="desc">
                                                                            {!! $item->description !!}
                                                                        </div>
                                                                        <div class="info">
                                                                            <span><i class="fas fa-file-alt"></i> {{ $item->totalExam() }} bài</span>
                                                                            <span><i class="fas fa-edit"></i> {{ $item->totalExamView() }} lượt
                                                                                thi</span>
                                                                            <a
                                                                                href="{{ makeLink('category_exams', $item->id, $item->slug) }}">Xem
                                                                                chi tiết</a>
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
                                <div class="content-exam">
                                    {!! $category->description ?? '' !!}
                                </div>
                                    <div class="wrap-list-exam">
                                        <div class="row">
                                            @foreach ($data as $item)
                                                <div class="col-sm-12 col-exam-item">
                                                    <div class="exam-item">
                                                        <div class="box">
                                                            {{-- <div class="image">
                                                                    <a href=""><img src="{{ asset($item->avatar_path) }}" alt="{{ $item->name }}"></a>
                                                                </div> --}}
                                                            <div class="content">
                                                                <h3><a
                                                                        href="{{ makeLink('exam', $item->id, $item->slug) }}">{{ $item->name }}</a>
                                                                </h3>
                                                                <div class="desc">
                                                                    {!! $item->description !!}
                                                                </div>
                                                                <div class="info">
                                                                    <span><i class="fas fa-calendar-alt"></i> {{ Carbon::parse($item->created_at)->format('d/m/Y') }}</span>
                                                                    <span><i class="fas fa-file-alt"></i> {{ $item->questions()->where([
                                                                        ['active',1],
                                                                        ['type',1]
                                                                    ])->count() }} bài</span>
                                                                    <span><i class="fas fa-edit"></i> {{ $item->view }} lượt
                                                                        thi</span>
                                                                    <a
                                                                        href="{{ makeLink('exam', $item->id, $item->slug) }}">Bắt đầu thi</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if (count($data))
                                {{ $data->appends(request()->all())->links() }}
                            @endif
                        </div>

                        <div class="col-lg-4 col-sm-12 col-xs-12 block-content-left">
                            @include('frontend.components.sidebar',[
                            "categoryExam"=>$categoryExam,
                            "categoryExamActive"=>$categoryExamActive,
                            "exam"=>true,
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
