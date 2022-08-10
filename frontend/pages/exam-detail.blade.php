@extends('frontend.layouts.main')



@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')


@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{-- @isset($breadcrumbs, $typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                'breadcrumbs'=>$breadcrumbs,
                'type'=>$typeBreadcrumb,
                ])
            @endisset --}}
            <div class="text-left wrap-breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumbs-item">
                                    <a href="{{ makeLink('home') }}">{{ __('home.home') }}</a>
                                </li>
                                @foreach ($breadcrumbs as $item)
                                    <li class="breadcrumbs-item"><a
                                            href="{{ makeLink($typeBreadcrumb, $item['id'] ?? '', $item['slug']) ?? '' }}"
                                            class="currentcat">{{ $item['name'] }}</a></li>
                                @endforeach
                                <li class="breadcrumbs-item"><a href="{{ $data->slug_full }}"
                                        class="currentcat">{{ $item['name'] }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-exam">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12  block-content-right">
                            <h1 class="title-template mb-3">
                                <span class="title-inner"><i class="fas fa-angle-double-right"></i>
                                    {{ $data->name ?? '' }} </span>
                            </h1>
                            <div class="content-info-exam">
                                <span>{{ $data->time }} phút</span>
                                <span><i class="fas fa-question-circle"></i>
                                    {{ $data->questions()->where('active', 1)->where('type', 1)->count() }} câu hỏi trắc nghiệm</span>
                                <span><i class="fas fa-user"></i> {{ $data->view }} lượt thi</span>
                                <a href="{{ route('exam.doExam',['slug'=>$data->slug]) }}"><i class="far fa-check-circle"></i> Làm bài</a>
                            </div>
                            <div class="wrap-question">
                                <div class="title-question">
                                    <div class="title-question-inner">
                                        Câu hỏi trắc nghiệm ({{ $data->questions()->where('active', 1)->where('type', 1)->count() }} câu)
                                    </div>
                                </div>
                                <div class="list-question">
                                    @foreach ($data->questions()->where('active', 1)->where('type', 1)->get()
                                               as $question)
                                        <div class="col-question-item">
                                            <div class="question-item">
                                                <div class="box">
                                                    <div class="top">
                                                        <span class="red">Câu {{ $loop->index + 1 }}</span>
                                                        <span>Mã câu hỏi : <strong
                                                                class="red">{{ $question->id }}</strong></span>
                                                    </div>
                                                    <div class="question-text">
                                                        {!! $question->name !!}
                                                    </div>
                                                    <div class="question-answer">
                                                        <ul>
                                                            @foreach ($question->answers()->where([
                                                                ['active', 1]
                                                                ])->orderby('order')->orderByDesc('created_at')->get() as $answer)
                                                                <li><span class="code">{{ $answer->code }} .</span> <span
                                                                        class="text">{!! $answer->name !!}</span> </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-center mt-4 mb-4">
                                <a href="{{ route('exam.doExam',['slug'=>$data->slug]) }}" class="btn-view"><i class="far fa-file-alt"></i> Bắt đầu làm bài</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
