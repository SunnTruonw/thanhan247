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
                <a class="nav-link {{$langItem['value']==$langDefault?'active':''}}" data-toggle="tab" href="#tong_quan_question_answer_{{$i}}_{{$langItem['value']}}">{{ $langItem['name'] }}</a>
            </li>
            @endforeach

        </ul>
        <div class="tab-content">
            @foreach ($langConfig as $langItem)
            <div id="tong_quan_question_answer_{{$i}}_{{$langItem['value']}}" class="container tab-pane {{$langItem['value']==$langDefault?'active show':''}} fade">
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
