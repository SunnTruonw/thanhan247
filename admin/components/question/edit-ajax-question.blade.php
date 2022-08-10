<form class="form-horizontal formEditQuestionAjax" id="formEditQuestionAjax" name="formEditQuestionAjax"
    data-url="{{ route('admin.exam.updateQuestion', ['id' => $data->id]) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="loadHtmlErrorValide">

    </div>
    <div class="text-right mb-3">
        <button class="btn btn-primary btn-lg" type="submit">Lưu lại</button>
    </div>



    <div class="row">
        <div class=" @if ($data->type==2) col-md-12 @else col-md-12 @endif">
            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif

            <input type="hidden" value="{{ $data->type }}" name="typeQuestion" form="formEditQuestionAjax">
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
                                <textarea class="form-control tinymce_editor_init" value="{{ optional($data->translationsLanguage($langItem['value'])->first())->name }}" name="nameQuestion_{{$langItem['value']}}"
                                    placeholder="Nhập câu hỏi" cols="30" rows="3"
                                    form="formEditQuestionAjax">{{ optional($data->translationsLanguage($langItem['value'])->first())->name }} </textarea>
                                @error('nameQuestion_'.$langItem['value'])
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($data->type == 2)
                                <div class="form-group">
                                    <label for="">Nhập title câu hỏi</label>
                                    <input class="form-control" value="{{ optional($data->translationsLanguage($langItem['value'])->first())->title }}" name="titleQuestion_{{$langItem['value']}}"
                                        placeholder="Nhập câu hỏi" cols="30" rows="3" form="formEditQuestionAjax" />
                                    @error('titleQuestion_'.$langItem['value'])
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="">Nhập giải bài</label>
                                <textarea class="form-control tinymce_editor_init" value="{{ old('answerQuestion_'.$langItem['value']) }}"
                                    name="answerQuestion_{{$langItem['value']}}" placeholder="Nhập đáp án" cols="30" rows="3"
                                    form="formEditQuestionAjax">{{ optional($data->translationsLanguage($langItem['value'])->first())->answer }} </textarea>
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
                        <input type="number" class="form-control" value="{{ $data->order }}" name="orderQuestion"
                            placeholder="Nhập số thứ tự" form="formEditQuestionAjax">
                        @error('orderQuestion')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" value="1" name="activeQuestion" {{ $data->active==1?"checked":"" }} form="formEditQuestionAjax">
                                Hiện
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" value="0" {{ $data->active==0?"checked":"" }}
                                    name="activeQuestion" form="formEditQuestionAjax">
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
    </div>
</form>
