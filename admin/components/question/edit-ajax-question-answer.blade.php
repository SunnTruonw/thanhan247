<form class="form-horizontal formEditQuestionAnswerAjax" id="formEditQuestionAnswerAjax" name="formEditQuestionAnswerAjax" data-url="{{route('admin.exam.updateQuestionAnswer',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="loadHtmlErrorValide">

    </div>
    <div class="text-right mb-3">
        <button class="btn btn-primary btn-lg" type="submit">Lưu lại</button>
    </div>
    <div class="card card-outline card-primary">
        <div class="card-header">
        <h3 class="card-title">Sửa đáp án</h3>
        </div>
        <div class="card-body table-responsive p-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="" style="width:150px;">Nhập mã</th>
                        <th class="" style="width: calc(100% - 300px);">Nhập đáp án</th>
                        <th class="" style="width:150px;">ĐA đúng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="answer">
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $data->code }}" name="codeAnswer" placeholder="A" form="formEditQuestionAnswerAjax"
                                    required>
                            </div>
                        </td>
                        <td>
                            <ul class="nav nav-tabs">
                                @foreach ($langConfig as $langItem)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $langItem['value'] == $langDefault ? 'active' : '' }}"
                                            data-toggle="tab"
                                            href="#tong_quan_question_answer_{{ $langItem['value'] }}">{{ $langItem['name'] }}</a>
                                    </li>
                                @endforeach

                            </ul>
                            <div class="tab-content">
                                @foreach ($langConfig as $langItem)
                                    <div id="tong_quan_question_answer_{{ $langItem['value'] }}"
                                        class="container tab-pane {{ $langItem['value'] == $langDefault ? 'active show' : '' }} fade">
                                        <div class="form-group">
                                            <label for="">Nhập tên câu hỏi</label>
                                            <textarea class="form-control tinymce_editor_init" value=""
                                                name="nameAnswer_{{ $langItem['value'] }}" placeholder="Nhập câu hỏi"
                                                cols="30" rows="3" form="formEditQuestionAnswerAjax"> {{ optional($data->translationsLanguage($langItem['value'])->first())->name }} </textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="correctAnswer" form="formEditQuestionAnswerAjax"
                                            class="form-check-input checkParagraph" value="0" {{ $data->correct==0?'checked':'' }}> Sai
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="correctAnswer" form="formEditQuestionAnswerAjax"
                                            class="form-check-input checkParagraph" value="1" {{ $data->correct==1?'checked':'' }}>Đúng
                                    </label>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


</form>
