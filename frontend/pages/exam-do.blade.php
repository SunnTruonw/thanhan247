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
            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif
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
                        <div class="col-lg-9 col-sm-12  block-content-right">
                            <h1 class="title-template mb-3">
                                <span class="title-inner"><i class="fas fa-angle-double-right"></i>
                                    {{ $data->name ?? '' }} </span>
                            </h1>
                            <div class="content-info-exam">
                                <span>60 phút</span>
                                <span><i class="fas fa-question-circle"></i>
                                    {{ $data->questions()->where('active', 1)->where('type', 1)->count() }} câu hỏi trắc
                                    nghiệm</span>
                                <span><i class="fas fa-user"></i> {{ $data->view }} lượt thi</span>
                            </div>
                            <form action="{{ route('exam.storeResultExam', ['slug' => $data->slug]) }}" method="POST"
                                id="sendResult">
                                @csrf
                                <div class="wrap-question">
                                    <div class="title-question">
                                        <div class="title-question-inner">
                                            Câu hỏi trắc nghiệm
                                            ({{ $data->questions()->where('active', 1)->where('type', 1)->count() }} câu)
                                        </div>
                                    </div>
                                    <div class="list-question">
                                        @foreach ($data->questions()->where('active', 1)->where('type', 1)->get()
                                                 as $question)
                                            {{-- <input type="hidden" class="form-check-input" name="answer[{{ $loop->index }}]" value="0"> --}}
                                            <div class="col-question-item" id="question-result-{{ $loop->index + 1 }}">
                                                <div class="question-item">
                                                    <div class="box">
                                                        <div class="top">
                                                            <input type="hidden" name="question[{{ $loop->index }}]"
                                                                value="{{ $question->id }}">
                                                            <input type="hidden" name="type[{{ $loop->index }}]"
                                                                value="{{ $question->type }}">
                                                            <span class="red">Câu {{ $loop->index + 1 }}</span>
                                                            <span>Mã câu hỏi : <strong
                                                                    class="red">{{ $question->id }}</strong></span>
                                                        </div>
                                                        <div class="question-text">
                                                            {!! $question->name !!}
                                                        </div>
                                                        <div class="question-answer wrap-answer-check"
                                                            data-href="#view-result-{{ $loop->index + 1 }}">
                                                            @foreach ($question->answers()->where('active', 1)->get()
                                                                         as $answer)
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input type="checkbox"
                                                                            class="form-check-input onChangeCheckResult"
                                                                            name="answer[{{ $loop->parent->index }}][]"
                                                                            value="{{ $answer->id }}">
                                                                        {!! $answer->name !!}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-center mt-4 mb-4">
                                    <button class="btn-view"><i class="far fa-file-alt"></i>Nộp bài</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-3 col-sm-12 block-content-left">
                            @php
                                $count = $data
                                    ->questions()
                                    ->where('active', 1)
                                    ->where('type', 1)
                                    ->count();
                                $i = 1;
                            @endphp
                            <div class="wrap-result">
                                <div class="title-result">Trắc nghiệm</div>
                                <div class="count">
                                    <strong>Thời gian làm bài:</strong>
                                    <div id="countdown" data-date="{{ $data->time ? $data->time : 0 }}">
                                        <span id="hours">0</span>:
                                        <span id="minutes">0</span>:
                                        <span id="seconds">0</span>
                                    </div>
                                </div>
                                <div class="thongke-result">
                                    <span class="dalam-r"> <i class="far fa-check-circle"></i> Đã làm: <strong
                                            id="dalam">0</strong> câu</span>
                                    <span class="chualam-r">Chưa làm <strong id="chualam">{{ $count }}</strong>
                                        câu</span>
                                    {{-- <span class="chuachacchan">Chưa chắc chắn</span> <span id="chuachacchan">0</span> --}}
                                </div>
                                <ul class="list-result-answer">

                                    @while ($i <= $count)
                                        <li class="chualam" id="view-result-{{ $i }}">
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
    <script>
        $(function() {
            $(document).on('change', '.onChangeCheckResult', function() {
                let href = $(this).parents('.wrap-answer-check').data('href');

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
                        title: 'Thời gian làm bài của bạn đã hết.<br> Hệ thống sẽ tự động gửi bài thi của bạn.<br> Xin cám ơn',
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Gửi bài thi !'
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

        });
    </script>
@endsection
