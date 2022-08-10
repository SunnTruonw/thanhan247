@extends('admin.layouts.main')
@section('title', 'Thông tin bài thi')

@section('css')
    <style>
        .answers {}

        .answers ul {

            flex-wrap: wrap;
            max-width: 600px;
            margin: 0 auto;
        }

        .answers ul li {
            /* width: 50%; */
            display: flex;
            align-items: flex-start;
        }

        .mda {
            width: 100px;
        }

        .da {
            width: 100%;
        }

        .action {
            width: 110px;
        }

        .answers {
            display: none;
        }

        .list-group-item p {
            margin: 0;
        }

        .list-group-item {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .list-group {
            font-size: 14px;
        }

    </style>
@endsection
@section('content')

    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>"Bài thi","key"=>"Thông tin bài thi"])
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <a data-url="{{ route('admin.exam.loadCreateQuestion', ['id' => $data->id, 'type' => 1]) }}"
                                class="btn  btn-info btn-md mb-2 addQuestionAjax">+ Thêm câu hỏi trắc nghiệm</a>
                            <a data-url="{{ route('admin.exam.loadCreateQuestion', ['id' => $data->id, 'type' => 2]) }}"
                                class="btn  btn-info btn-md mb-2 addQuestionAjax">+ Thêm câu hỏi tự luận</a>
                            {{-- <a href="{{ route('admin.bailam.index',['exam_id'=>$data->id]) }}" class="btn  btn-success btn-lg mb-2 float-right"><i class="fas fa-list-alt mr-2"></i> Danh sách bài làm</a> --}}
                        </div>

                        @if (session('alert'))
                            <div class="alert alert-success">
                                {{ session('alert') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-warning">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="card card-outline card-primary mb-0">
                            <div class="card-header mb-3">
                                <h3 class="card-title">Thông tin bài thi</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-dark table-hover" style="font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th>Trường</th>
                                            <th>Giá trị</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Tên</td>
                                            <td>{{ $data->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Thời gian làm bài </td>
                                            <td>{{ $data->time }} (phút)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-outline card-primary mb-0">
                            <div class="card-header mb-3">
                                <h3 class="card-title">Danh sách câu hỏi</h3>
                            </div>
                            <div class="card card-outline card-primary mb-0">
                                <div class="card-body">
                                    <div id="loadListExercise">
                                        @include('admin.components.question.load-list-question',['type'=>config('web_default.typeQuestion'),'data'=>$data,'typeActive'=>1])
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-12 card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách đề thi</h3>
                         </div>
                    </div>
                    @foreach ($data->dethis as $item)
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-id-card"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">
                                    {{ $item->code }}
                                    @if ($item->active == 1)
                                       <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-danger">Disable</span>
                                    @endif
                                </span>
                                <span class="info-box-number">
                                    Trắc nghiệm {{ $item->questions()->where(['active'=>1,'type'=>1])->count() }} (câu)
                                    Tự luận {{ $item->questions()->where(['active'=>1,'type'=>2])->count() }} (câu)
                                </span>
                            </div>
                            </div>
                        </div>
                    @endforeach --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade in" id="loadAjaxParent">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Câu hỏi</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="content p-3" id="loadContent">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('admin_asset/ajax/ajax-exam.js') }}"></script>
@endsection
