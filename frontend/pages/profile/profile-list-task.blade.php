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
							Danh sách bài thi đã làm ({{ $total }} bài)
						</div>
                        <div class="list-task">
                            <ul>
                                @foreach ($data as $task)
                                <li>
                                    <div class="task-item">
                                        <div class="box">
                                            <div class="name"> <a href="{{ route('exam.resultExam',['slug'=>$task->exam->slug,'task_id'=>$task->id]) }}">{{ $task->exam->name }}</a></div>
                                            <div class="info-task">
                                                <span><i class="fas fa-calendar-day"></i> {{ date_format($task->created_at,"d/m/Y") }} </span>
                                                <span> <strong>{{ $task->point }}</strong> điểm</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="pagination-group">
                            <div class="pagination">
                                @if (count($data))
                                    {{ $data->links() }}
                                @endif
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
