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
                                <li class="breadcrumbs-item"><a href="{{ $exam->slug_full }}"
                                        class="currentcat">{{ $exam['name'] }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-exam">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12  block-content-right">
                            @if (session('alert'))
                                <div class="alert alert-success">
                                    {{ session('alert') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-warning">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <h1 class="title-template mb-3">
                                <span class="title-inner"><i class="fas fa-angle-double-right"></i>
                                    {{ $exam->name ?? '' }} </span>
                            </h1>
                            <div class="content-info-exam">
                                <span>{{ $exam->time }} phút</span>
                                <span><i class="fas fa-question-circle"></i>
                                    {{ $data->answers()->where('type', 1)->count() }} câu hỏi trắc
                                    nghiệm</span>
                                <span><i class="fas fa-user"></i> {{ $exam->view }} lượt thi</span>
                            </div>

                        @php
                           $count = $data->answers()->where('type', 1)->count();
                           $arrKeyAnswerTrue=collect();
                        @endphp
                            <div class="wrap-question">
                                <div class="title-question">
                                    <div class="title-question-inner">
                                        Câu hỏi trắc nghiệm
                                        ({{ $count }} câu)
                                    </div>
                                </div>
                                <div class="list-question">
                                    @foreach ($data->answers()->where('type', 1)->get()
                                                as $taskAnswer)
                                                @php
                                                    $question=$taskAnswer->question;
                                                    $choice= $taskAnswer->choices()->get()->pluck('answer_id');
                                                    $checkAnswer=$taskAnswer->checkAnswerShow();
                                                    if($checkAnswer){
                                                        $arrKeyAnswerTrue->push($loop->index + 1);
                                                    }
                                                @endphp
                                        <div class="col-question-item col-question-item-result @if($checkAnswer) true @endif" id="question-result-{{ $loop->index + 1 }}">
                                            <div class="question-item">
                                                <div class="box">
                                                    <div class="top">
                                                        <span class="red">Câu {{ $loop->index + 1 }} </span>
                                                        <span>Mã câu hỏi : <strong
                                                                class="red">{{$question->id }}</strong></span>
                                                    </div>
                                                    <div class="question-text">
                                                        {!! $question->name !!}
                                                    </div>
                                                    <div class="question-answer">
                                                        <ul>
                                                            @foreach ($question->answers()->where([
                                                                ['active', 1]
                                                                ])->orderby('order')->orderByDesc('created_at')->get() as $answer)
                                                                <li class="@if ($answer->correct) answer-true @endif @if ($choice->contains($answer->id)) answer-choice @endif">
                                                                    <span class="code">{{ $answer->code }} .</span> <span
                                                                        class="text">{!! $answer->name !!}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>

                                                    </div>
                                                    <div class="view-answer">
                                                        <div class="title-view-answer">
                                                          <div class="left">
                                                            @if($checkAnswer)
                                                                <a  class="btn btn-sm btn-success">Đúng <i class="fas fa-check-circle"></i></a>
                                                            @else
                                                                <a  class="btn btn-sm btn-danger"><span class=""> Sai <i class="fas fa-exclamation-circle"></i></span></a>
                                                            @endif
                                                          </div>
                                                          <div class="right">
                                                            <a class="btn-colsap btn btn-sm btn-light">
                                                                Xem đáp án
                                                              </a>
                                                          </div>
                                                        </div>
                                                        <div  class="collapse-content">
                                                           <div class="title-col">
                                                            Đáp án đúng
                                                           </div>
                                                            <ul class="list">
                                                                @foreach ($question->answers()->where('correct',1)->get() as $answer)
                                                                <li><span class="code">{{ $answer->code }} .</span> <span
                                                                    class="text">{!! $answer->name !!}</span></li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="title-col">
                                                               Giải chi tiết
                                                            </div>
                                                            <div class="text">
                                                                {!! $question->answer !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3 col-sm-12 block-content-left">
                            @php
                                $i = 1;
                            @endphp
                            <div class="wrap-result">
                                <div class="title-result">Trắc nghiệm</div>

                                <div class="thongke-result">
                                    <span class="dung-r"> <i class="far fa-check-circle"></i> Số câu trả lời đúng <strong
                                            >{{ $arrKeyAnswerTrue->count() }}</strong> câu</span>
                                    <span class="sai-r"><i class="fas fa-exclamation-circle"></i> Số câu trả lời sai <strong >{{ $count -$arrKeyAnswerTrue->count() }}</strong>
                                        câu</span>
                                    {{-- <span class="chuachacchan">Chưa chắc chắn</span> <span id="chuachacchan">0</span> --}}
                                </div>
                                <ul class="list-result-answer">
                                    @while ($i <= $count)
                                        <li class="@if ($arrKeyAnswerTrue->contains($i)) btn-true @else btn-false @endif" id="view-result-{{ $i }}">
                                            <a href="#question-result-{{ $i }}">{{ $i }}</a>
                                        </li>
                                        @php
                                            $i++;
                                        @endphp
                                    @endwhile
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
