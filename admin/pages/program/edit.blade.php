@extends('admin.layouts.main')
@section('title',"Sửa bài viêt")

@section('css')
<style>
    .lb_list_action_recusive {
        width: 110px;
    }
    .lb_list_content_recusive{
        width: calc(100% - 110px);
    }
    ul{
        list-style: none;
    }
    ul li{
        list-style: none;
    }
</style>
<style>
    .answers{

    }
    .answers ul{

        flex-wrap: wrap;
        max-width: 600px;
        margin: 0 auto;
    }
    .answers ul li{
        /* width: 50%; */
        display: flex;
        align-items: flex-start;
    }
    .mda{
        width: 100px;
    }
    .da{
        width: 100%;
    }
    .action{
        width: 110px;
    }
    .answers{
        display: none;
    }
    .list-group-item p{
        margin: 0;
    }
    .list-group-item{
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .list-group {
        font-size: 14px;
    }
</style>
@endsection
@section('content')
<div class="content-wrapper lb_template_post_edit">
    @include('admin.partials.content-header',['name'=>"Bài viết","key"=>"Sửa bài viết"])

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    @if(session("alert"))
                    <div class="alert alert-success">
                        {{session("alert")}}
                    </div>
                    @elseif(session('error'))
                    <div class="alert alert-warning">
                     {{session("error")}}
                  </div>
                    @endif
                    <form class="form-horizontal" action="{{route('admin.program.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline card-primary">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-header">
                                                @foreach ($errors->all() as $message)
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @endforeach
                                             </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-tool p-3 text-right">
                                                <button type="submit" class="btn btn-primary btn-lg">Chấp nhận</button>
                                                <button type="reset" class="btn btn-danger btn-lg">Làm lại</button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card-header">
                                       <h3 class="card-title">Thông tin bài viết</h3>
                                    </div>
                                    <div class="card-body table-responsive p-3">
										<ul class="nav nav-tabs">
                                            <li class="nav-item">
                                              <a class="nav-link active" data-toggle="tab" href="#tong_quan">Tổng quan</a>
                                            </li>
                                            <!-- <li class="nav-item">
                                              <a class="nav-link" data-toggle="tab" href="#du_lieu">Dữ liệu</a>
                                            </li> -->
                                            <li class="nav-item">
                                              <a class="nav-link" data-toggle="tab" href="#hinh_anh">Hình ảnh</a>
                                            </li>
                                            <li class="nav-item">
                                              <a class="nav-link" data-toggle="tab" href="#seo">Seo</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <!-- START Tổng Quan -->
                                            <div id="tong_quan" class="container tab-pane active"><br>

                                                <ul class="nav nav-tabs">
                                                    @foreach ($langConfig as $langItem)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{$langItem['value']==$langDefault?'active':''}}" data-toggle="tab" href="#tong_quan_{{$langItem['value']}}">{{ $langItem['name'] }}</a>
                                                    </li>
                                                    @endforeach

                                                </ul>
                                                <div class="tab-content">
                                                    @foreach ($langConfig as $langItem)
                                                    <div id="tong_quan_{{$langItem['value']}}" class="container wrapChangeSlug tab-pane {{$langItem['value']==$langDefault?'active show':''}} fade">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Tên dịch vụ</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control nameChangeSlug
                                                                    @error('name_'.$langItem['value']) is-invalid @enderror" id="name_{{$langItem['value']}}" value="{{ old('name_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->name }}" name="name_{{$langItem['value']}}" placeholder="Nhập tên sản phẩm">
                                                                    @error('name_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Slug</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control resultSlug
                                                                    @error('slug_'.$langItem['value']) is-invalid  @enderror" id="slug_{{ $langItem['value'] }}" value="{{ old('slug_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->slug }}" name="slug_{{ $langItem['value'] }}" placeholder="Nhập slug">
                                                                    @error('slug_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Nhập giới thiệu</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control  @error('description_'.$langItem['value']) is-invalid @enderror" name="description_{{$langItem['value']}}" id="" rows="3"  placeholder="Nhập giới thiệu">{{ old('description_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->description  }}</textarea>
                                                                    @error('description_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Nhập nội dung</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control tinymce_editor_init @error('content_'.$langItem['value']) is-invalid  @enderror" name="content_{{$langItem['value']}}" id="" rows="20" value="" placeholder="Nhập nội dung">
                                                                    {{ old('content_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->content }}
                                                                    </textarea>
                                                                    @error('content_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Nhập nội dung soạn văn</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control tinymce_editor_init @error('content2_'.$langItem['value']) is-invalid  @enderror" name="content2_{{$langItem['value']}}" id="" rows="20" value="" placeholder="Nhập nội dung soạn bài">
                                                                    {{ old('content2_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->content2 }}
                                                                    </textarea>
                                                                    @error('content2_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Nhập nội dung trắc nghiệm</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control tinymce_editor_init @error('content3_'.$langItem['value']) is-invalid  @enderror" name="content3_{{$langItem['value']}}" id="" rows="20" value="" placeholder="Nhập nội dung trắc nghiệm">
                                                                    {{ old('content3_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->content3 }}
                                                                    </textarea>
                                                                    @error('content3_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Nhập nội dung Bài tập SGK</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control tinymce_editor_init @error('content4_'.$langItem['value']) is-invalid  @enderror" name="content4_{{$langItem['value']}}" id="" rows="20" value="" placeholder="Nhập nội dung bài tập SGK">
                                                                    {{ old('content4_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->content4 }}
                                                                    </textarea>
                                                                    @error('content4_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="form-group form-check">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label">

                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <input type="checkbox" class="form-check-input" name="checkrobot" id="">
                                                                    <label class="form-check-label" for="" required>Tôi đồng ý</label>
                                                                </div>
                                                            </div>
                                                            @error('checkrobot')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div> --}}
                                                    </div>
                                                    @endforeach

                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Chọn danh mục</label>
                                                        <div class="col-sm-10">

                                                            <select class="form-control custom-select select-2-init @error('category_id')
                                                                is-invalid
                                                                @enderror" id="" value="{{ old('category_id') }}" name="category_id">

                                                                <option value="0">--- Chọn danh mục cha ---</option>

                                                                @if (old('category_id')||old('category_id')==='0')
                                                                    {!! \App\Models\CategoryProgram::getHtmlOption(old('category_id')) !!}
                                                                @else
                                                                {!!$option!!}
                                                                @endif
                                                            </select>
                                                            @error('category_id')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Số thứ tự</label>
                                                        <div class="col-sm-10">
                                                            <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order')??$data->order }}" name="order" placeholder="Nhập số thứ tự">
                                                        </div>
                                                        @error('order')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Nhập thời gian làm bài trắc nghiệm </label>
                                                        <div class="col-sm-10">
                                                            <input type="number" min="0" class="form-control  @error('time') is-invalid  @enderror"  value="{{ old('time')??$data->order }}" name="time" placeholder="Nhập thời gian làm bài trắc nghiệm ">
                                                        </div>
                                                        @error('time')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Dịch vụ nổi bật</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" class="form-check-input @error('hot') is-invalid
                                                                        @enderror" value="1" name="hot" @if(old('hot')==="1"||$data->hot==1 ) {{'checked'}} @endif>
                                                                </label>
                                                            </div>
                                                            @error('hot')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Trạng thái</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-check-inline">
                                                                <label class="form-check-label">
                                                                <input type="radio" class="form-check-input" value="1" name="active" @if(old('active')==='1' || $data->active==1) {{'checked'}} @endif>Hiện
                                                                </label>
                                                            </div>
                                                            <div class="form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="radio" class="form-check-input" value="0" @if(old('active')==="0" || $data->active==0){{'checked'}} @endif name="active">Ẩn
                                                                </label>
                                                            </div>
                                                            @error('active')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                </div>

                                            </div>
                                            <!-- END Tổng Quan -->

                                            <!-- START Dữ Liệu -->
                                            <!-- <div id="du_lieu" class="container tab-pane fade"><br>

                                            </div> -->
                                            <!-- END Dữ Liệu -->

                                            <!-- START Hình Ảnh -->
                                            <div id="hinh_anh" class="container tab-pane fade"><br>

                                                <div class="wrap-load-image mb-3">
                                                    <div class="form-group">
                                                        <label for="">Ảnh đại diện</label>
                                                        <input type="file" class="form-control-file img-load-input border" id="" name="avatar_path">
                                                    </div>
                                                    @error('avatar_path')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    @if ($data->avatar_path)
                                                    <img class="img-load border p-1 w-100" src="{{$data->avatar_path}}" alt="{{$data->name}}" style="height: 200px;object-fit:cover; max-width: 260px;">
                                                    @endif
                                                </div>

                                                <hr>

                                            </div>
                                            <!-- END Hình Ảnh -->

                                            <!-- START Seo -->
                                            <div id="seo" class="container tab-pane fade"><br>
                                                <ul class="nav nav-tabs">
                                                    @foreach ($langConfig as $langItem)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{$langItem['value']==$langDefault?'active':''}}" data-toggle="tab" href="#seo_{{$langItem['value']}}">{{ $langItem['name'] }}</a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                <div class="tab-content">
                                                    @foreach ($langConfig as $langItem)
                                                        <div id="seo_{{$langItem['value']}}" class="container tab-pane {{$langItem['value']==$langDefault?'active show':''}} fade">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for="">Nhập title seo</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control @error('title_seo_'.$langItem['value']) is-invalid @enderror" id="" value="{{ old('title_seo_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->title_seo }}" name="title_seo_{{ $langItem['value'] }}" placeholder="Nhập title seo">
                                                                        @error('title_seo_'.$langItem['value'])
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for="">Nhập mô tả seo</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control @error('description_seo_'.$langItem['value']) is-invalid @enderror" id="" value="{{ old('description_seo_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->description_seo }}" name="description_seo_{{ $langItem['value'] }}" placeholder="Nhập mô tả seo">
                                                                        @error('description_seo_'.$langItem['value'])
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for="">Nhập từ khóa seo</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control @error('keyword_seo_'.$langItem['value']) is-invalid @enderror" id="" value="{{ old('keyword_seo_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->keyword_seo  }}" name="keyword_seo_{{ $langItem['value'] }}" placeholder="Nhập mô tả seo">
                                                                        @error('keyword_seo_'.$langItem['value'])
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for="">Nhập tags</label>
                                                                    <div class="col-sm-10">
                                                                        {{-- {{ dd(old('tags_'.$langItem['value'])) }} --}}
                                                                        <select class="form-control tag-select-choose w-100" multiple="multiple" name="tags_{{$langItem['value']}}[]">
                                                                            @if (old('tags_'.$langItem['value']))
                                                                                @foreach (old('tags_'.$langItem['value']) as $tag)
                                                                                    <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                                                                @endforeach
                                                                            @else
                                                                            @foreach($data->tagsLanguage($langItem['value'])->get() as $tagItem)
                                                                             <option value="{{$tagItem->name}}" selected>{{$tagItem->name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                        @error('title_seo')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!-- END Seo -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-5">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                        <h3 class="card-title w-100">Đoạn văn đã thêm <a data-url="{{ route('admin.program.loadCreateParagraphProgram',['id'=>$data->id]) }}" class="btn  btn-info btn-md float-right " id="addParagraphAjax">+ Thêm đoạn văn</a></h3>
                        </div>
                        <div class="card-body table-responsive p-3">
                            <div id="loadListParagraph">
                                @include('admin.components.paragraph.load-list-paragraph',[
                                    'configParagraph'=>$configParagraph,'data'=>$data,
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                        <h3 class="card-title w-100">Bài tập đã thêm
                             <a data-url="{{ route('admin.program.loadCreateExercise',['id'=>$data->id,'type'=>1]) }}" class="btn  btn-info btn-md float-right addExerciseAjax" id="">+ Thêm BT TN</a>
                             <a data-url="{{ route('admin.program.loadCreateExercise',['id'=>$data->id,'type'=>2]) }}" class="btn  btn-info btn-md float-right mr-2 addExerciseAjax" id="">+ Thêm BT SGK</a>
                        </h3>
                        </div>
                        <div class="card-body table-responsive p-3">
                            <div id="loadListExercise">
                                @include('admin.components.program.load-list-exercise',['type'=>config('web_default.typeExercise'),'data'=>$data,'typeActive'=>1])
                            </div>
                        </div>
                    </div>
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
          <h4 class="modal-title">Đoạn văn</h4>
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
    <script>

    </script>
@endsection
