
<form class="form-horizontal formAddExerciseAjax" data-url="{{route('admin.program.updateExercise',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="loadHtmlErrorValide">

    </div>
        <div class="text-right mb-3">
            <button class="btn btn-primary btn-lg" type="submit">Lưu lại</button>
        </div>
        <div class="row">
            <div class=" @if ($data->type==2) col-md-12 @else col-md-12 @endif">
               @if(session("alert"))
               <div class="alert alert-success">
                  {{session("alert")}}
               </div>
               @elseif(session('error'))
               <div class="alert alert-warning">
                  {{session("error")}}
               </div>
               @endif
                {{-- <input type="hidden" class="form-control" value="{{ $program->id }}"  name="program_id_exercise"> --}}
                <input type="hidden" value="{{ $data->type }}" name="typeExercise">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                       <h3 class="card-title">Sửa bài tập</h3>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <div class="form-group">
                            <label for="">Nhập tên câu hỏi</label>
                                <textarea   class="form-control tinymce_editor_init"
                                value="{{ old('nameExercise')??$data->name }}"  name="nameExercise"
                                placeholder="Nhập câu hỏi"  cols="30" rows="3">{{ old('nameExercise')??$data->name }} </textarea>
                            @error('nameExercise')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($data->type==2)
                        <div class="form-group">
                            <label for="">Nhập title câu hỏi</label>
                                <input   class="form-control"
                                value="{{ old('titleExercise')??$data->title }}"  name="titleExercise"
                                placeholder="Nhập câu hỏi"  cols="30" rows="3" />
                            @error('titleExercise')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>

                            <div class="form-group">
                            <label for="">Nhập đáp án</label>
                                <textarea   class="form-control tinymce_editor_init"
                                value="{{ old('answerExercise')??$data->answer }}"  name="answerExercise"
                                placeholder="Nhập đáp án"  cols="30" rows="3">{{ old('answerExercise')??$data->answer }} </textarea>
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
                                value="{{ old('orderExercise')??$data->order }}"  name="orderExercise"
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
                                @if((old('activeExercise')??$data->active)=="1") {{'checked'}}  @endif
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
                                @if((old('activeExercise')??$data->active)=="0"){{'checked'}}  @endif
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
            {{-- @if ($data->type==1)
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
                                       @foreach ($data->answers as $item)
                                        <tr class="answer">
                                            <td>
                                                <div class="form-group">
                                                    <input
                                                    type="text"
                                                    class="form-control"
                                                    value="{{ $item->code }}"  name="codeAnswer[]"
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
                                                    value="{{ $item->name }}"  name="nameAnswer[]"
                                                    placeholder="Đáp án"  cols="30" rows="3">{{ $item->name }}</textarea>
                                                    @error('nameAnswer')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                          <input type="checkbox" name="correctAnswer[]" class="form-check-input checkParagraph" value="0" {{ $item->correct?"":'checked' }} > Sai
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                          <input type="checkbox" name="correctAnswer[]" class="form-check-input checkParagraph" value="1" {{ $item->correct?"checked":'' }}>Đúng
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a  class="btn btn-sm  btn-danger deleteAnswer"><i class="far fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif --}}
         </div>
</form>
