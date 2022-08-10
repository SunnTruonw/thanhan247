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
                                        if (isset($type) && isset($activeType) && $type && $activeType) {
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
                                            <div class="tab-pane fade @if ($act || ($checkActiveType
                                                && $type==$typeKey && $activeType=='paragraph' )) show active @endif"
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
                                            <div class="tab-pane fade @if ($act || ($checkActiveType
                                                && $type==$typeKey && $activeType=='exercise' )) show active @endif" id="tab-program-exercise-{{ $loop->index + 1 }}"
                                                role="tabpanel">
                                                @if ($typeKey == 1)
                                                    <div class="content-program-tab">
                                                        {!! $data->content3 !!}
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-9 col-sm-12  block-content-right">
                                                            <h1 class="title-template mb-3">
                                                                <span class="title-inner"><i
                                                                        class="fas fa-angle-double-right"></i>
                                                                    {{ $data->name ?? '' }} </span>
                                                            </h1>
                                                            <div class="content-info-exam">
                                                                <span>{{ $data->view }} phút</span>
                                                                <span><i class="fas fa-question-circle"></i>
                                                                    {{ $data->exercises()->where('active', 1)->where('type', 1)->count() }}
                                                                    câu hỏi trắc
                                                                    nghiệm</span>

                                                            </div>
                                                            <form
                                                                action="{{ route('program.storeResultExercise', ['slug' => $data->slug]) }}"
                                                                method="POST" id="sendResult">
                                                                @csrf
                                                                <div class="wrap-question">
                                                                    <div class="title-question">
                                                                        <div class="title-question-inner">
                                                                            Câu hỏi trắc nghiệm
                                                                            ({{ $data->exercises()->where('active', 1)->where('type', 1)->count() }}
                                                                            câu)
                                                                        </div>
                                                                    </div>
                                                                    <div class="list-question">
                                                                        @foreach ($data->exercises()->where('active', 1)->where('type', 1)->get()
        as $exercise)
                                                                            {{-- <input type="hidden" class="form-check-input" name="answer[{{ $loop->index }}]" value="0"> --}}
                                                                            <div class="col-question-item"
                                                                                id="question-result-{{ $loop->index + 1 }}">
                                                                                <div class="question-item">
                                                                                    <div class="box">
                                                                                        <div class="top">
                                                                                            <input type="hidden"
                                                                                                name="exercise[{{ $loop->index }}]"
                                                                                                value="{{ $exercise->id }}">
                                                                                            <input type="hidden"
                                                                                                name="type[{{ $loop->index }}]"
                                                                                                value="{{ $exercise->type }}">
                                                                                            <span class="red">Câu
                                                                                                {{ $loop->index + 1 }}</span>
                                                                                            <span>Mã câu hỏi : <strong
                                                                                                    class="red">{{ $exercise->id }}</strong></span>
                                                                                        </div>
                                                                                        <div class="question-text">
                                                                                            {!! $exercise->name !!}
                                                                                        </div>
                                                                                        <div class="question-answer wrap-answer-check"
                                                                                            data-href="#view-result-{{ $loop->index + 1 }}">
                                                                                            @foreach ($exercise->answers()->where('active', 1)->get()
        as $answer)
                                                                                                <div class="form-check">
                                                                                                    <label
                                                                                                        class="form-check-label">
                                                                                                        <input
                                                                                                            type="checkbox"
                                                                                                            class="form-check-input onChangeCheckResult"
                                                                                                            name="answer[{{ $loop->parent->index }}][]"
                                                                                                            value="{{ $answer->id }}">
                                                                                                        {!! $answer->name !!}
                                                                                                    </label>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        </div>

                                                                                        <div class="view-answer">
                                                                                            <div class="title-view-answer">
                                                                                                <div class="left">
                                                                                                </div>
                                                                                                <div class="right">
                                                                                                    <a
                                                                                                        class="btn-colsap2 btn btn-sm btn-light">
                                                                                                        Xem đáp án
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="collapse-content">
                                                                                                <div class="title-col">
                                                                                                    Đáp án đúng
                                                                                                </div>
                                                                                                <ul class="list">
                                                                                                    @foreach ($exercise->answers()->where('correct', 1)->get()
        as $answer)
                                                                                                        <li><span
                                                                                                                class="code">{{ $answer->code }}
                                                                                                                .</span>
                                                                                                            <span
                                                                                                                class="text">{!! $answer->name !!}</span>
                                                                                                        </li>
                                                                                                    @endforeach
                                                                                                </ul>
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
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="text-center mt-4 mb-4">
                                                                    <button class="btn-view"><i
                                                                            class="far fa-file-alt"></i>Nộp bài</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-12 block-content-left">
                                                            @php
                                                                $count = $data
                                                                    ->exercises()
                                                                    ->where('active', 1)
                                                                    ->where('type', 1)
                                                                    ->count();
                                                                $i = 1;
                                                            @endphp
                                                            <div class="wrap-result">
                                                                <div class="title-result">Trắc nghiệm</div>
                                                                <div class="count">
                                                                    <strong>Thời gian làm bài:</strong>
                                                                    <div id="countdown"
                                                                        data-date="{{ $data->time ? $data->time : 0 }}">
                                                                        <span id="hours">0</span>:
                                                                        <span id="minutes">0</span>:
                                                                        <span id="seconds">0</span>
                                                                    </div>
                                                                </div>
                                                                <div class="thongke-result">
                                                                    <span class="dalam-r"> <i
                                                                            class="far fa-check-circle"></i> Đã làm: <strong
                                                                            id="dalam">0</strong> câu</span>
                                                                    <span class="chualam-r">Chưa làm <strong
                                                                            id="chualam">{{ $count }}</strong>
                                                                        câu</span>
                                                                    {{-- <span class="chuachacchan">Chưa chắc chắn</span> <span id="chuachacchan">0</span> --}}
                                                                </div>
                                                                <ul class="list-result-answer">

                                                                    @while ($i <= $count)
                                                                        <li class="chualam"
                                                                            id="view-result-{{ $i }}">
                                                                            <a
                                                                                href="#question-result-{{ $i }}">{{ $i }}</a>
                                                                        </li>
                                                                        @php
                                                                            $i++;
                                                                        @endphp
                                                                    @endwhile

                                                                </ul>
                                                            </div>
                                                        </div>
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
            $(document).on('change', '.onChangeCheckResult', function() {
                let href = $(this).parents('.wrap-answer-check').data('href');
                $(this).prop('disabled', true);
                let lengthChecked = $(this).parents('.wrap-answer-check').find(
                    "input.onChangeCheckResult:checked").length;
                if (lengthChecked > 0) {
                    if ($(href).hasClass('dalam')) {

                    } else {
                        $(href).removeClass('chualam').addClass('dalam');
                    }
                } else {
                    if ($(href).hasClass('chualam')) {

                    } else {
                        $(href).removeClass('dalam').addClass('chualam');
                    }
                }
                let numberDalam = $('.list-result-answer .dalam').length;
                let numberChualam = $('.list-result-answer .chualam').length;
                $('#dalam').text(numberDalam);
                $('#chualam').text(numberChualam);
            });



            let getDate = parseInt($("#countdown").data("date"));
            var now = new Date();
            //  var date = now.getDate();
            //  var month = (now.getMonth()+1);
            //  var year =  now.getFullYear();
            //  var minute=now.getMinutes();
            // var minute=now.getMinutes();
            var timer;
            //  var then = year+'/'+month+'/'+date+' 23:59:59';
            var then = now.getTime() + getDate * 60 * 1000;
            //  var then =now.getTime()+5*1000;
            var now = new Date();


            var compareDate = new Date(then) - now.getDate();

            timer = setInterval(function() {

                timeBetweenDates(compareDate);
            }, 1000);

            function timeBetweenDates(toDate) {
                var dateEntered = new Date(toDate);
                var now = new Date();
                var difference = dateEntered.getTime() - now.getTime();
                console.log(difference);
                if (difference <= 0) {
                    clearInterval(timer);
                    Swal.fire({
                        title: 'Thời gian làm bài của bạn đã hết.<br> Hệ thống sẽ tự động gửi bài kiểm tra của bạn.<br> Xin cám ơn',
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Gửi bài kiểm tra !'
                    }).then((result) => {
                        $("#sendResult").submit();
                    })
                } else {
                    var seconds = Math.floor(difference / 1000);
                    var minutes = Math.floor(seconds / 60);
                    var hours = Math.floor(minutes / 60);
                    var days = Math.floor(hours / 24);
                    hours %= 24;
                    minutes %= 60;
                    seconds %= 60;
                    //    $("#days").text(days);
                    $("#hours").text(hours);
                    $("#minutes").text(minutes);
                    $("#seconds").text(seconds);
                }
            }
            $(document).on('click', '.btn-colsap2', function() {
                let lengthCheck = $(this).parents('.question-item').find('input:checked').length;
                // alert(lengthCheck);
                if (lengthCheck) {
                    $(this).parents('.view-answer').find('.collapse-content').slideToggle();
                } else {
                    alert('Bạn phải chọn đáp án trước khi xem kết quả');
                }

            });
        });
    </script>
@endsection
