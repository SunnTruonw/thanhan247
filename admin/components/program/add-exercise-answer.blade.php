<tr class="answer">
    <td>
        <div class="form-group">
            <input
            type="text"
            class="form-control"
            value=""  name="codeAnswer[]"
            placeholder="A"
            required
            >
            @error('codeAnswer')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </td>
    <td>
        <div class="form-group">
            <textarea   class="form-control tinymce_editor_init"
            value=""  name="nameAnswer[]"
            placeholder="Đáp án"  cols="30" rows="3"></textarea>
            @error('nameAnswer')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </td>
    <td>
        <div class="form-group">
            <div class="form-check">
                <label class="form-check-label">
                  <input type="checkbox" name="correctAnswer[]" class="form-check-input checkParagraph" value="0" checked > Sai
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                  <input type="checkbox" name="correctAnswer[]" class="form-check-input checkParagraph" value="1">Đúng
                </label>
            </div>
        </div>
    </td>
    <td>
        <a  class="btn btn-sm  btn-danger deleteAnswer"><i class="far fa-trash-alt"></i></a>
    </td>
</tr>
