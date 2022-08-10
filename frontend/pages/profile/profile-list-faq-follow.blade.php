@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
@section('css')
    <style>

    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{-- @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset --}}
            <div class="wrap-content-main">
                <div class="row">
                    <div class="col-sm-12">
						<div class="title-profile">
							Danh sách câu hỏi của bạn ({{ $data->count() }} câu hỏi)
						</div>
                        @isset($data)
                                <div class="list-faq-question">
                                    <div class="row">
                                        @foreach ($data as $faq)
                                        <div class="col-faq-question-item col-lg-6 col-md-12 col-sm-12">
                                            <div class="faq-question-item">
                                                <div class="box p-3" style="background-color:#fff; ">
                                                    <div class="top">
                                                        <div class="icon">
                                                            <img src="{{ asset($faq->user->avatar_path?$faq->user->avatar_path:$shareFrontend['userNoImage']) }}" alt="{{ $faq->user->name }}">
                                                        </div>
                                                        <div class="content-top">
                                                            <h3><a href="{{ $faq->slug_full }}">{{ $faq->user->name }}</a></h3>
                                                            <div class="desc-top">{{ $faq->created_at }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="mid">
                                                        <h3>
                                                            <a href="{{ $faq->slug_full }}">
                                                               {!! $faq->name !!}
                                                            </a>
                                                        </h3>
                                                        <div class="desc">
                                                           {!! $faq->content !!}
                                                        </div>
                                                    </div>
                                                    <div class="bot">
                                                        <div class="left">
                                                            <i class="fas fa-comment-dots"></i> {{ $faq->answers()->count() }}
                                                        </div>
                                                        <div class="right">
                                                            <span class="point">{{ $faq->point }} điểm</span>
                                                            <a href="{{ $faq->slug_full }}" class="btn btn-warning btn-sm">Trả lời</a>
                                                        </div>
                                                    </div>
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
                            @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
