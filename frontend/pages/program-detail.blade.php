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
                                        class="currentcat">{{ $data['name'] }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-program">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12  block-content-right">
                            <h1 class="title-bg mb-3">
                                <span class="title-inner">
                                    {{ $data->name ?? '' }} </span>
                            </h1>
                            <div class="wrap-content-program">

                                <ul class="nav nav-pills mb-3" role="tablist">
                                    @php
                                        if (isset($type) && isset($activeType)&&$type&&$activeType) {
                                            $checkActiveType = true;
                                            $act = false;
                                        } else {
                                            $checkActiveType = false;
                                            $act = true;
                                        }
                                    @endphp
                                    @foreach (config('paragraph.programs.type') as $typeKey => $typeParagraph)
                                        @if ($data->paragraphs()->where([['type', $typeKey], ['active', 1]])->count() > 0)
                                            <li class="nav-item">
                                                <a class="nav-link @if ($act || ($checkActiveType &&
                                                    $type==$typeKey && $activeType=='paragraph' )) active @endif" data-toggle="pill"
                                                    href="#tab-program-{{ $loop->index + 1 }}" role="tab"
                                                    aria-selected="true">{{ $typeParagraph }}</a>
                                            </li>
                                            @php
                                                $act = false;
                                                if ($checkActiveType && $type == $typeKey && $activeType == 'paragraph') {
                                                    $checkActiveType = false;
                                                }
                                            @endphp
                                        @endif
                                    @endforeach

                                    @foreach (config('web_default.typeExercise') as $typeKey => $typeExercise)
                                        @if ($data->exercises()->where([['type', $typeKey], ['active', 1]])->count() > 0)
                                            <li class="nav-item">
                                                <a class="nav-link @if ($act || ($checkActiveType &&
                                                    $type==$typeKey && $activeType=='exercise' )) active @endif" data-toggle="pill"
                                                    href="#tab-program-exercise-{{ $loop->index + 1 }}" role="tab"
                                                    aria-selected="true">{{ $typeExercise }}</a>
                                            </li>
                                            @php
                                                $act = false;
                                                if ($checkActiveType && $type == $typeKey && $activeType == 'exercise') {
                                                    $checkActiveType = false;
                                                }
                                            @endphp
                                        @endif
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @php
                                       if (isset($type) && isset($activeType)) {
                                            $checkActiveType = true;
                                            $act = false;
                                        } else {
                                            $checkActiveType = false;
                                            $act = true;
                                        }
                                    @endphp
                                    @foreach (config('paragraph.programs.type') as $typeKey => $typeParagraph)
                                        @if ($data->paragraphs()->where([['type', $typeKey], ['active', 1]])->count() > 0)
                                            <div class="tab-pane fade @if ($act || ($checkActiveType &&
                                            $type==$typeKey && $activeType=='paragraph' )) show active @endif"
                                                id="tab-program-{{ $loop->index + 1 }}" role="tabpanel">
                                                <div class="content-program-tab">
                                                    @if ($typeKey == 1)
                                                        {!! $data->content !!}
                                                    @else
                                                        {!! $data->content2 !!}
                                                    @endif
                                                </div>
                                                <div class="box-link-paragraph">
                                                    <div class="title-link-header"><i class="fas fa-align-justify"></i>
                                                    </div>
                                                    <ul>
                                                        @include('frontend.components.paragraph',['typeKey'=>$typeKey,'data'=>$data])
                                                    </ul>
                                                </div>
                                                <div class="list-content-paragraph">
                                                    @include('frontend.components.paragraph-content',['typeKey'=>$typeKey,'data'=>$data])
                                                </div>
                                            </div>
                                            @php
                                                $act = false;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @foreach (config('web_default.typeExercise') as $typeKey => $typeExercise)
                                        @if ($data->exercises()->where([['type', $typeKey], ['active', 1]])->count() > 0)
                                            <div class="tab-pane fade @if ($act || ($checkActiveType &&
                                            $type==$typeKey && $activeType=='exercise' )) show active @endif"
                                                id="tab-program-exercise-{{ $loop->index + 1 }}" role="tabpanel">
                                                @if ($typeKey == 1)
                                                <div class="text-right mt-4 mb-4">
                                                    <a class="btn-view" href="{{ route('program.doExercise',['slug'=>$data->slug]) }}"><i class="far fa-file-alt"></i>Làm bài</a>
                                                </div>
                                                @if (session('resultDoExercise'))
                                                    <div class="alert alert-success">
                                                        {{ session('resultDoExercise') }}
                                                    </div>
                                                @elseif(session('error'))
                                                    <div class="alert alert-warning">
                                                        {{ session('error') }}
                                                    </div>
                                                @endif
                                                    <div class="content-program-tab">
                                                        {!! $data->content3 !!}
                                                    </div>
                                                    <div class="list-question">
                                                        @foreach ($data->exercises()->where('active', 1)->where('type', 1)->get()
                                                               as $exercise)
                                                            <div class="col-question-item">
                                                                <div class="question-item">
                                                                    <div class="box">
                                                                        <div class="top">
                                                                            <span class="red">Câu
                                                                                {{ $loop->index + 1 }}</span>
                                                                            <span>Mã bài tập : <strong
                                                                                    class="red">{{ $exercise->id }}</strong></span>
                                                                        </div>
                                                                        <div class="question-text">
                                                                            {!! $exercise->name !!}
                                                                        </div>
                                                                        <div class="question-answer">
                                                                            <ul>
                                                                                @foreach ($exercise->answers()->where([['active', 1]])->orderby('order')->orderByDesc('created_at')->get()
                                                                                     as $answer)
                                                                                    <li><span
                                                                                            class="code">{{ $answer->code }}
                                                                                            .</span> <span
                                                                                            class="text">{!! $answer->name !!}</span>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                @elseif($typeKey==2)
                                                    <div class="content-program-tab">
                                                        {!! $data->content3 !!}
                                                    </div>
                                                    <div class="list-question">
                                                        @foreach ($data->exercises()->where('active', 1)->where('type', 2)->get()
                                                              as $exercise)
                                                            <div class="col-exercise-item">
                                                                <div class="exercise-item">
                                                                    <div class="box">
                                                                        <div class="top">
                                                                            {{ $exercise->title }}
                                                                        </div>
                                                                        <div class="question-text">
                                                                            {!! $exercise->name !!}
                                                                        </div>
                                                                        <div class="view-answer">
                                                                            <div class="title-view-answer">
                                                                                <div class="left">
                                                                                </div>
                                                                                <div class="right">
                                                                                    <a
                                                                                        class="btn-colsap btn btn-sm btn-light">
                                                                                        Xem đáp án
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collapse-content">
                                                                                <div class="title-col">
                                                                                    Giải chi tiết
                                                                                </div>
                                                                                <div class="text">
                                                                                    {!! $exercise->answer !!}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            @php
                                                $act = false;
                                            @endphp
                                        @endif
                                    @endforeach
                                </div>

                                <div class="share-with">
                                    <div class="share-article">
                                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-591d2f6c5cc3d5e5"></script>
                                        <div class="addthis_inline_share_toolbox"></div>
                                    </div>
                                </div>
                            </div>
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
