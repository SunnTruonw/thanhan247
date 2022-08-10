<form class="form-horizontal formAddQuestionAjax" id="formAddQuestionAjax" name="formAddQuestionAjax"
    data-url="{{ route('admin.exam.storeQuestion', ['id' => $exam->id]) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="loadHtmlErrorValide">
    </div>
    <div class="text-right mb-3">
        <button class="btn btn-primary btn-lg" type="submit" form="formAddQuestionAjax" >Lưu lại</button>
    </div>
    <div class="row">
        <div class="col-md-5 @if ($typeQuestion==2) col-md-12 @else col-md-5 @endif">
            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif

            <input type="hidden" value="{{ $typeQuestion }}" name="typeQuestion" form="formAddQuestionAjax">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Thêm câu hỏi</h3>
                </div>
                <div class="card-body table-responsive p-3">

                    <ul class="nav nav-tabs">
                        @foreach ($langConfig as $langItem)
                        <li class="nav-item">
                            <a class="nav-link {{$langItem['value']==$langDefault?'active':''}}" data-toggle="tab" href="#tong_quan_question_{{$langItem['value']}}">{{ $langItem['name'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach ($langConfig as $langItem)
                        <div id="tong_quan_question_{{$langItem['value']}}" class="container wrapChangeSlug tab-pane {{$langItem['value']==$langDefault?'active show':''}} fade">
                            <div class="form-group">
                                <label for="">Nhập tên câu hỏi</label>
                                <textarea class="form-control tinymce_editor_init" value="{{ old('nameQuestion_'.$langItem['value']) }}" name="nameQuestion_{{$langItem['value']}}"
                                    placeholder="Nhập câu hỏi" cols="30" rows="3"
                                    form="formAddQuestionAjax">{{ old('nameQuestion_'.$langItem['value']) }} </textarea>
                                @error('nameQuestion_'.$langItem['value'])
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($typeQuestion == 2)
                                <div class="form-group">
                                    <label for="">Nhập title câu hỏi</label>
                                    <input class="form-control" value="{{ old('titleQuestion_'.$langItem['value']) }}" name="titleQuestion_{{$langItem['value']}}"
                                        placeholder="Nhập câu hỏi" cols="30" rows="3" form="formAddQuestionAjax" />
                                    @error('titleQuestion_'.$langItem['value'])
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="">Nhập giải bài</label>
                                <textarea class="form-control tinymce_editor_init" value="{{ old('answerQuestion_'.$langItem['value']) }}"
                                    name="answerQuestion_{{$langItem['value']}}" placeholder="Nhập đáp án" cols="30" rows="3"
                                    form="formAddQuestionAjax">{{ old('answerQuestion_'.$langItem['value']) }} </textarea>
                                @error('answerQuestion_'.$langItem['value'])
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="">Nhập số thứ tự câu hỏi</label>
                        <input type="number" class="form-control" value="{{ old('orderQuestion') }}" name="orderQuestion"
                            placeholder="Nhập số thứ tự" form="formAddQuestionAjax">
                        @error('orderQuestion')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" value="1" name="activeQuestion" checked form="formAddQuestionAjax">
                                Hiện
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" value="0"
                                    name="activeQuestion" form="formAddQuestionAjax">
                                Ẩn
                            </label>
                        </div>
                    </div>
                    @error('activeQuestion')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        @if ($typeQuestion == 1)
            <div class="col-md-7">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title w-100">Thêm đáp án <a
                                data-url="{{ route('admin.exam.loadCreateQuestionAnswer') }}"
                                class="btn  btn-info btn-md float-right " id="addQuestionAnswer">+ Thêm đáp án</a></h3>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <div class="wrap-anser">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="" style="width:70px;">Nhập mã</th>
                                        <th class="" style="width: calc(100% - 200px);">Nhập đáp án</th>
                                        <th class="" style="width:70px;">ĐA đúng</th>
                                        <th style="width:60px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="answer">
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="" name="codeAnswer[]"
                                                    placeholder="A" required>
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="nav nav-tabs">
                                                @foreach ($langConfig as $langItem)
                                                <li class="nav-item">
                                                    <a class="nav-link {{$langItem['value']==$langDefault?'active':''}}" data-toggle="tab" href="#tong_quan_question_answer_{{$langItem['value']}}">{{ $langItem['name'] }}</a>
                                                </li>
                                                @endforeach

                                            </ul>
                                            <div class="tab-content">
                                                @foreach ($langConfig as $langItem)
                                                <div id="tong_quan_question_answer_{{$langItem['value']}}" class="container tab-pane {{$langItem['value']==$langDefault?'active show':''}} fade">
                                                    <div class="form-group">
                                                        <label for="">Nhập tên câu hỏi</label>
                                                        <textarea class="form-control tinymce_editor_init" value="" name="nameAnswer_{{$langItem['value']}}[]"
                                                            placeholder="Nhập câu hỏi" cols="30" rows="3"
                                                            form="formAddQuestionAjax"> </textarea>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="correctAnswer[]"
                                                            class="form-check-input checkParagraph" value="0"
                                                            checked> Sai
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="correctAnswer[]"
                                                            class="form-check-input checkParagraph" value="1">Đúng
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm  btn-danger deleteQuestionAnswer"><i
                                                    class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</form>
