<form class="form-horizontal formAddExerciseAjax" data-url="{{route('admin.program.storeExerciseAnswer',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="loadHtmlErrorValide">

    </div>
    <div class="text-right mb-3">
        <button class="btn btn-primary btn-lg" type="submit">Lưu lại</button>
    </div>
    <div class="card card-outline card-primary">
        <div class="card-header">
        <h3 class="card-title">Thêm đáp án</h3>
        </div>
        <div class="card-body table-responsive p-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Câu hỏi</th>
                        <th style="min-width: 140px" class="">Sửa/Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="answer">
                        <td>
                            <div class="form-group">
                                <input
                                type="text"
                                class="form-control"
                                value=""  name="codeAnswer"
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
                                value=""  name="nameAnswer"
                                placeholder="Đáp án"  cols="30" rows="3"></textarea>
                                @error('nameAnswer')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </td>
                        <td>
                            <div class="form-group d-flex">
                                <div class="form-check mr-3">
                                    <label class="form-check-label">
                                    <input type="checkbox" name="correctAnswer" class="form-check-input checkParagraph" value="0" checked > Sai
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="checkbox" name="correctAnswer" class="form-check-input checkParagraph" value="1" >Đúng
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Nhập số thứ tự</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    value="{{ old('orderAnswer') }}"  name="orderAnswer"
                                    placeholder="Nhập số thứ tự"
                                    >
                                @error('orderAnswer')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>
