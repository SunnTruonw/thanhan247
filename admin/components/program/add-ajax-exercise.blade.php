
<form class="form-horizontal formAddExerciseAjax" data-url="{{route('admin.program.storeExercise',['id'=>$program->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="loadHtmlErrorValide">

    </div>
        <div class="text-right mb-3">
            <button class="btn btn-primary btn-lg" type="submit">Lưu lại</button>
        </div>
        <div class="row">
            <div class="col-md-5 @if ($typeExercise==2) col-md-12 @else col-md-5 @endif">
               @if(session("alert"))
               <div class="alert alert-success">
                  {{session("alert")}}
               </div>
               @elseif(session('error'))
               <div class="alert alert-warning">
                  {{session("error")}}
               </div>
               @endif
                <input type="hidden" class="form-control" value="{{ $program->id }}"  name="program_id_exercise">
                <input type="hidden" value="{{ $typeExercise }}" name="typeExercise">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                       <h3 class="card-title">Thêm bài tập</h3>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <div class="form-group">
                            <label for="">Nhập tên câu hỏi</label>
                                <textarea   class="form-control tinymce_editor_init"
                                value="{{ old('nameExercise') }}"  name="nameExercise"
                                placeholder="Nhập câu hỏi"  cols="30" rows="3">{{ old('nameExercise') }} </textarea>
                            @error('nameExercise')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($typeExercise==2)
                        <div class="form-group">
                            <label for="">Nhập title câu hỏi</label>
                                <input   class="form-control"
                                value="{{ old('titleExercise') }}"  name="titleExercise"
                                placeholder="Nhập câu hỏi"  cols="30" rows="3" />
                            @error('titleExercise')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>

                            <div class="form-group">
                            <label for="">Nhập đáp án</label>
                                <textarea   class="form-control tinymce_editor_init"
                                value="{{ old('answerExercise') }}"  name="answerExercise"
                                placeholder="Nhập đáp án"  cols="30" rows="3">{{ old('answerExercise') }} </textarea>
                            @error('answerExercise')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="">Nhập số thứ tự câu hỏi</label>
                            <input
                                type="number"
                                class="form-control"
                                value="{{ old('orderExercise') }}"  name="orderExercise"
                                placeholder="Nhập số thứ tự"
                                >
                            @error('orderExercise')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                <input
                                type="radio"
                                class="form-check-input"
                                value="1"
                                name="activeExercise"
                                @if(old('activeExercise')==="1"||old('activeExercise')===null) {{'checked'}}  @endif
                                >
                                Hiện
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                <input
                                type="radio"
                                class="form-check-input"
                                value="0"
                                @if(old('activeExercise')==="0"){{'checked'}}  @endif
                                name="activeExercise"
                                >
                                Ẩn
                                </label>
                            </div>
                        </div>
                        @error('activeExercise')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            @if ($typeExercise==1)
                <div class="col-md-7">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                        <h3 class="card-title w-100">Thêm đáp án   <a data-url="{{ route('admin.program.loadCreateExerciseAnswer') }}" class="btn  btn-info btn-md float-right " id="addAnswer">+ Thêm đáp án</a></h3>
                        </div>
                        <div class="card-body table-responsive p-3">
                            <div class="wrap-anser">

                                <table class="table table-bordered" >
                                    <thead>
                                        <tr>
                                            <th class="" style="width:70px;">Nhập mã</th>
                                            <th class="" style="width: calc(100% - 200px);">Nhập đáp án</th>
                                            <th class="" style="width:70px;">ĐA đúng</th>
                                            <th style="width:60px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (old('codeAnswer')&&old('nameAnswer'))
                                            @foreach (old('codeAnswer') as $key=>$value)
                                            <tr class="answer">
                                                <td>
                                                    <div class="form-group">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            value="{{ $value }}"  name="codeAnswer[]"
                                                            placeholder="A"
                                                            required
                                                        >
                                                        @error('codeAnswer.'.$key)
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>

                                                <td >
                                                    <div class="form-group">
                                                        <textarea   class="form-control tinymce_editor_init"
                                                        value="{{ old('nameAnswer')[$key] }}"  name="nameAnswer[]"
                                                        placeholder="Đáp án"  cols="30" rows="3"  required>{{ old('nameAnswer')[$key] }}</textarea>
                                                        @error('nameAnswer.'.$key)
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
                                            @endforeach
                                       @else
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
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
         </div>
</form>
