@extends('admin.layouts.main')
@section('title',"Thêm Sản phẩm")

@section('css')
<link href="{{asset('lib/select2/css/select2.min.css')}}" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #000 !important;
    }

    .select2-container .select2-selection--single {
        height: auto;
    }
    .tinymce_editor_init{
        height: 300px !important;
    }
</style>
@endsection
@section('content')


<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Sản phẩm","key"=>"Thêm Sản phẩm"])

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(session()->has("alert"))
                    <div class="alert alert-success">
                        {{session()->get("alert")}}
                    </div>
                    @elseif(session()->has('error'))
                    <div class="alert alert-warning">
                        {{session("error")}}
                    </div>
                    @endif
                    <form class="form-horizontal" action="{{route('admin.product.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                       <h3 class="card-title">Thông tin Sản phẩm</h3>
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
                                            <div id="tong_quan" class="container tab-pane active "><br>

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
                                                                <label class="col-sm-2 control-label" for="">Tên Sản phẩm</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control nameChangeSlug
                                                                    @error('name_'.$langItem['value']) is-invalid @enderror" id="name_{{$langItem['value']}}" value="{{ old('name_'.$langItem['value']) }}" name="name_{{$langItem['value']}}" placeholder="Nhập tên sản phẩm">
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
{{--
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Model</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control
                                                                    @error('model_'.$langItem['value']) is-invalid @enderror" id="model_{{$langItem['value']}}" value="{{ old('model_'.$langItem['value']) }}" name="model_{{$langItem['value']}}" placeholder="Nhập model">
                                                                    @error('model_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Tình trạng</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control
                                                                    @error('tinhtrang_'.$langItem['value']) is-invalid @enderror" id="tinhtrang_{{$langItem['value']}}" value="{{ old('tinhtrang_'.$langItem['value']) }}" name="tinhtrang_{{$langItem['value']}}" placeholder="Nhập tình trạng">
                                                                    @error('tinhtrang_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Bảo hành</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control
                                                                    @error('baohanh_'.$langItem['value']) is-invalid @enderror" id="baohanh_{{$langItem['value']}}" value="{{ old('baohanh_'.$langItem['value']) }}" name="baohanh_{{$langItem['value']}}" placeholder="Nhập bảo hành">
                                                                    @error('baohanh_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Xuất sứ</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control
                                                                    @error('xuatsu_'.$langItem['value']) is-invalid @enderror" id="xuatsu_{{$langItem['value']}}" value="{{ old('xuatsu_'.$langItem['value']) }}" name="xuatsu_{{$langItem['value']}}" placeholder="Nhập xuất sứ">
                                                                    @error('xuatsu_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div> --}}
														<div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for="">Giới thiệu</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control tinymce_editor_init @error('content2_'.$langItem['value']) is-invalid  @enderror" name="content2_{{$langItem['value']}}" id="" rows="20" value=""  placeholder="Nhập thông tin" >
                                                                        {{ old('content2_'.$langItem['value']) }}
                                                                        </textarea>
                                                                        @error('content2_'.$langItem['value'])
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
														{{--
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Nhập giới thiệu</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control  @error('description_'.$langItem['value']) is-invalid @enderror" name="description_{{$langItem['value']}}" id="" rows="3"  placeholder="Nhập giới thiệu">{{ old('description_'.$langItem['value']) }}</textarea>
                                                                    @error('description_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>--}}

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-sm-2 control-label" for="">Nhập mô tả sản phẩm</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control tinymce_editor_init @error('content_'.$langItem['value']) is-invalid  @enderror" name="content_{{$langItem['value']}}" id="" rows="20" value=""  placeholder="Nhập thông tin" >
                                                                    {{ old('content_'.$langItem['value']) }}
                                                                    </textarea>
                                                                    @error('content_'.$langItem['value'])
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{--
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for="">Nhập thông số kỹ thuật</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control tinymce_editor_init @error('content2_'.$langItem['value']) is-invalid  @enderror" name="content2_{{$langItem['value']}}" id="" rows="20" value=""  placeholder="Nhập thông số kỹ thuật" >
                                                                        {{ old('content2_'.$langItem['value']) }}
                                                                        </textarea>
                                                                        @error('content2_'.$langItem['value'])
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for=""> Nhập chính sách vận chuyển</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control tinymce_editor_init @error('content3_'.$langItem['value']) is-invalid  @enderror" name="content3_{{$langItem['value']}}" id="" rows="20" value=""  placeholder="Nhập chính sách vận chuyển" >
                                                                        {{ old('content3_'.$langItem['value']) }}
                                                                        </textarea>
                                                                        @error('content3_'.$langItem['value'])
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for=""> Nhập chính sách bảo hành</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control tinymce_editor_init @error('content4_'.$langItem['value']) is-invalid  @enderror" name="content4_{{$langItem['value']}}" id="" rows="20" value=""  placeholder="Nhập chính sách bảo hành" >
                                                                        {{ old('content4_'.$langItem['value']) }}
                                                                        </textarea>
                                                                        @error('content4_'.$langItem['value'])
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        --}}
                                                    </div>
                                                    @endforeach
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
                                                        <input type="file" class="form-control-file img-load-input border @error('avatar_path')
                                                        is-invalid
                                                        @enderror" id="" name="avatar_path">
                                                        @error('avatar_path')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 200px;object-fit:cover; max-width: 260px;">
                                                </div>
                                                <div class="wrap-load-image mb-3">
                                                    <div class="form-group">
                                                        <label for="">Ảnh liên quan</label>
                                                        <input type="file" class="form-control-file img-load-input-multiple border @error('image')
                                                            is-invalid
                                                            @enderror" id="" name="image[]" multiple>
                                                    </div>
                                                    @error('image')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    <div class="load-multiple-img">
                                                        <img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
                                                        <img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
                                                        <img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
                                                    </div>
                                                </div>
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
                                                                        <input type="text" class="form-control @error('title_seo_'.$langItem['value']) is-invalid @enderror" id="" value="{{ old('title_seo_'.$langItem['value']) }}" name="title_seo_{{ $langItem['value'] }}" placeholder="Nhập title seo">
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
                                                                        <input type="text" class="form-control @error('description_seo_'.$langItem['value']) is-invalid @enderror" id="" value="{{ old('description_seo_'.$langItem['value']) }}" name="description_seo_{{ $langItem['value'] }}" placeholder="Nhập mô tả seo">
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
                                                                        <input type="text" class="form-control @error('keyword_seo_'.$langItem['value']) is-invalid @enderror" id="" value="{{ old('keyword_seo_'.$langItem['value']) }}" name="keyword_seo_{{ $langItem['value'] }}" placeholder="Nhập mô tả seo">
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
                            <div class="col-md-4">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Thông tin khác</h3>
                                     </div>
                                     <div class="card-body table-responsive p-3">
                                        <div class="form-group">
                                            <label class="control-label" for="">Chọn danh mục</label>
                                            <select class="form-control custom-select select-2-init @error('category_id')
                                                is-invalid
                                                @enderror" id="" value="{{ old('category_id') }}" name="category_id">

                                                <option value="0">--- Chọn danh mục cha ---</option>

                                                @if (old('category_id'))
                                                    {!! \App\Models\CategoryProduct::getHtmlOption(old('category_id')) !!}
                                                @else
                                                {!!$option!!}
                                                @endif
                                            </select>
                                            @error('category_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- <div class="form-group">
                                            <label class="control-label" for="">Chọn nhà cung cấp</label>
                                            <select class="form-control @error('supplier_id')
                                                is-invalid
                                                @enderror" id="" value="{{ old('supplier_id') }}" name="supplier_id">

                                                <option value="0">--- Chọn nhà cung cấp ---</option>
                                                @foreach ($supplier as $item)
                                                <option value="{{ $item->id }}" @if (old('supplier_id')) {{ old('supplier_id')==  $item->id ?"selected":""}} @endif>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div> --}}

                                        <div class="form-group">
                                            <label class="control-label" for="">Số thứ tự</label>

                                            <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order') }}" name="order" placeholder="Nhập số thứ tự">

                                            @error('order')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>{{-- 
                                        <div class="form-group">
                                            <label class="control-label" for="">Giá</label>
                                            <input type="number" min="0" class="form-control  @error('price') is-invalid  @enderror"  value="{{ old('price') }}" name="price" placeholder="Nhập giá">
                                            @error('price')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="">Sale(%)</label>
                                            <input type="number" min="0" class="form-control  @error('sale') is-invalid  @enderror"  value="{{ old('sale') }}" name="sale" placeholder="Nhập sale">

                                            @error('sale')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div> --}}

                                        <div class="form-group">
                                            <label class="control-label" for="">Sản phẩm nổi bật</label>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input @error('hot')
                                                        is-invalid
                                                        @enderror" value="1" name="hot" @if(old('hot')==="1" ) {{'checked'}} @endif>
                                                </label>
                                            </div>
                                            @error('hot')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
										 <div class="form-group">
                                            <label class="control-label" for="">Sản phẩm máy móc nổi bật</label>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input @error('noibat')
                                                        is-invalid
                                                        @enderror" value="1" name="noibat" @if(old('noibat')==="1" ) {{'checked'}} @endif>
                                                </label>
                                            </div>
                                            @error('noibat')
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

                                        <hr>
                                        {{-- <div class="alert alert-light  mt-3 mb-1">
                                            <strong>Chọn thuộc tính</strong>
                                          </div>

                                         @foreach ($attributes as $key=> $attribute)

                                            <div class="form-group">
                                                <label class="control-label" for="">{{ $attribute->name }}</label>
                                                <select class="form-control"  name="attribute[]" >
                                                    <option value="0">--Chọn--</option>
                                                    @foreach ($attribute->childs()->orderby('order')->get() as $k=> $attr)
                                                        <option value="{{ $attr->id }}" @if (old('attribute')) {{ $attr->id== old('attribute')[$key]?'selected':"" }} @endif>{{ $attr->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('attribute.'.$key)
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                         @endforeach
                                            <hr> 
                                        <div class="alert alert-light mt-3 mb-1">
                                            <strong>Upload file</strong>
                                          </div>
                                        <div class="form-group">
                                            <label for="">FIle</label>
                                            <input type="file" class="form-control-file img-load-input border @error('file')
                                            is-invalid
                                            @enderror" id="" name="file">
                                            @error('file')
                                            <div class="invalid-feedback d-block"> $message</div>
                                            @enderror
                                        </div>
--}}
                                        {{-- <div class="form-group">
                                            <label for="">Hướng dẫn sử dụng</label>
                                            <input type="file" class="form-control-file img-load-input border @error('file2')
                                            is-invalid
                                            @enderror" id="" name="file2">
                                            @error('file2')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Drive</label>
                                            <input type="file" class="form-control-file img-load-input border @error('file3')
                                            is-invalid
                                            @enderror" id="" name="file3">
                                            @error('file3')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div> --}}

                                     </div>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')




@endsection
