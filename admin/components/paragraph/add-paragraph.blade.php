<tr class="paragraph">
    <td class="" style="width:calc(100% - 50px);">

        <div class="row">
            <div class="col-md-9">
                <ul class="nav nav-tabs">
                    @foreach ($langConfig as $langItem)
                    <li class="nav-item">
                        <a class="nav-link {{$langItem['value']==$langDefault?'active':''}}" data-toggle="tab" href="#thong_tin_paragraph_{{$i.$langItem['value']}}">{{ $langItem['name'] }}</a>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach ($langConfig as $langItem)
                    <div id="thong_tin_paragraph_{{$i.$langItem['value']}}" class="container tab-pane {{$langItem['value']==$langDefault?'active show':''}} fade">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 control-label" for="">Tên đoạn</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  value="" name="nameParagraph_{{$langItem['value']}}[]" placeholder="Nhập tên" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 control-label" for="">Nhập nội dung đoạn</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control tinymce_editor_init @error('valueParagraph_'.$langItem['value']) is-invalid  @enderror" name="valueParagraph_{{$langItem['value']}}[]" id="" rows="15" value=""  placeholder="Nhập nội dung đoạn văn" ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-3">
                <div class="wrap-load-image mb-3">
                    <div class="form-group">
                        <label for="">Ảnh đại diện</label>
                        <input type="file" class="form-control-file img-load-input border" id="" name="image_path_paragraph[]">
                    </div>
                    <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 150px;object-fit:cover; max-width: 200px;">
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="">Chọn kiểu</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="" value="" name="typeParagraph[]" required>
                                <option value="">--- Chọn kiểu đoạn ---</option>
                                @foreach ($configParagraph['type'] as $key=> $value)
                                     <option value="{{ $key }}"> {{ $value }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @if (isset($htmlselect))
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="">Chọn đoạn văn cha</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="" value="" name="parentIdParagraph[]" required>
                                <option value="">--- Chọn đoạn văn ---</option>
                               {{  $htmlselect }}
                            </select>
                        </div>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="">Số thứ tự</label>
                        <div class="col-sm-8">
                            <input type="number" min="0" class="form-control"  value="" name="orderParagraph[]" placeholder="Nhập số thứ tự">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="">Trạng thái</label>
                        <div class="col-sm-8">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                     <input type="checkbox" class="form-check-input checkParagraph" value="1" name="activeParagraph[]" checked>Hiện
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                     <input type="checkbox" class="form-check-input checkParagraph" value="0" name="activeParagraph[]">Ẩn
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </td>
    <td style="width:50px;">
        <a  class="btn btn-sm btn-danger deleteParagraph"><i class="far fa-trash-alt"></i></a>
    </td>
</tr>
