@extends('admin.layouts.main')
@section('title', 'thêm setting')
@section('css')
@endsection

@section('content')
    <div class="content-wrapper">

        @include('admin.partials.content-header',['name'=>"Setting","key"=>"Thêm nội dung mới"])

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('alert'))
                            <div class="alert alert-success">
                                {{ session('alert') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-warning">
                                {{session("error")}}
                            </div>
                        @endif
                        <form action="{{ route('admin.setting.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    @if ($errors->all())
                                    <div class="card-header">
                                        @foreach ($errors->all() as $message)
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @endforeach
                                     </div>
                                    @endif

                                </div>
                                <div class="col-md-6">
                                    <div class="card-tool p-3 text-right">
                                        <button type="submit" class="btn btn-primary btn-lg">Chấp nhận</button>
                                        <button type="reset" class="btn btn-danger btn-lg">Làm lại</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Thông tin nội dung</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="tab-content">
                                                <!-- START Tổng Quan -->
                                                <div id="tong_quan" class=" p-3 tab-pane active "><br>

                                                    <ul class="nav nav-tabs">
                                                        @foreach ($langConfig as $langItem)
                                                        <li class="nav-item">
                                                            <a class="nav-link {{$langItem['value']==$langDefault?'active':''}}" data-toggle="tab" href="#tong_quan_{{$langItem['value']}}">{{ $langItem['name'] }}</a>
                                                        </li>
                                                        @endforeach

                                                    </ul>
                                                    <div class="tab-content">
                                                        @foreach ($langConfig as $langItem)
                                                        <div id="tong_quan_{{$langItem['value']}}" class="pt-3 tab-pane {{$langItem['value']==$langDefault?'active show':''}} fade">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for="">Tên</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control
                                                                        @error('name_'.$langItem['value']) is-invalid @enderror" id="name_{{$langItem['value']}}" value="{{ old('name_'.$langItem['value']) }}" name="name_{{$langItem['value']}}" placeholder="Nhập tên danh mục">
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
                                                                        @error('slug_'.$langItem['value']) is-invalid  @enderror" id="slug_{{ $langItem['value'] }}" value="{{ old('slug_'.$langItem['value']) }}" name="slug_{{ $langItem['value'] }}" placeholder="Nhập slug">
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
                                                                        <textarea class="form-control  @error('value_'.$langItem['value']) is-invalid @enderror" name="value_{{$langItem['value']}}" id="" rows="3"  placeholder="Nhập giới thiệu">{{ old('value_'.$langItem['value']) }}</textarea>
                                                                        @error('value_'.$langItem['value'])
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for="">Nhập nội dung</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control tinymce_editor_init @error('description_'.$langItem['value']) is-invalid  @enderror" name="description_{{$langItem['value']}}" id="" rows="20" value=""  placeholder="Nhập nội dung" >
                                                                        {{ old('description_'.$langItem['value']) }}
                                                                        </textarea>
                                                                        @error('description_'.$langItem['value'])
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="wrap-load-image mb-3">
                                                                <div class="form-group">
                                                                    <label for="">Ảnh đại diện</label>
                                                                    <input type="file" class="form-control-file img-load-input border @error('image_path_'.$langItem['value'])
                                                                    is-invalid
                                                                    @enderror" id="" name="image_path_{{$langItem['value']}}">
                                                                    @error('image_path_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 200px;object-fit:cover; max-width: 260px;">
                                                            </div>

                                                            <div class="wrap-load-image mb-3">
                                                                <div class="form-group">
                                                                    <label for="">Upload file</label>
                                                                    <input type="file" class="form-control-file  border @error('file_'.$langItem['value'])
                                                                    is-invalid
                                                                    @enderror" id="" name="file_{{$langItem['value']}}">
                                                                    @error('file_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <!-- END Tổng Quan -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                        <h3 class="card-title">Thông tin khác</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">


                                            <div class="form-group">
                                                <label class=" control-label" for="">Chọn danh mục</label>
                                                <select class="form-control custom-select select-2-init @error('parent_id')
                                                    is-invalid
                                                    @enderror" id="" value="{{ old('parent_id') }}" name="parent_id">

                                                    <option value="0">--- Chọn danh mục cha ---</option>

                                                    @if (old('parent_id'))
                                                        {!! \App\Models\Setting::getHtmlOptionAddWithParent(old('parent_id')) !!}
                                                    @else
                                                    {!!$option!!}
                                                    @endif
                                                </select>
                                                @error('parent_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label" for="">Số thứ tự</label>

                                                <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order') }}" name="order" placeholder="Nhập số thứ tự">

                                                @error('order')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label" for="">Trạng thái</label>

                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="1" name="active" @if(old('active')==='1' ||old('active')===null) {{'checked'}} @endif>Hiện
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" value="0" @if(old('active')==="0" ){{'checked'}} @endif name="active">Ẩn
                                                    </label>
                                                </div>
                                                @error('active')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection


@section('js')
@endsection
