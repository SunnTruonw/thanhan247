@extends('admin.layouts.main')
@section('title',"Sửa sản phẩm")

@section('css')
@endsection
@section('content')
<div class="content-wrapper lb_template_product_edit">
    @include('admin.partials.content-header',['name'=>"Sản phẩm","key"=>"Sửa sản phẩm"])

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(session("alert"))
                    <div class="alert alert-success">
                        {{session("alert")}}
                    </div>
                    @elseif(session('error'))
                    <div class="alert alert-warning">
                        {{session("error")}}
                    </div>
                    @endif
                    <form class="form-horizontal" action="{{route('admin.product.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
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
                                       <h3 class="card-title">Thông tin sản phẩm</h3>
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
                                                                <label class="col-sm-2 control-label" for="">Tên sản phẩm</label>
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
                                                        {{--
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for="">Model</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control nameChangeSlug
                                                                        @error('model_'.$langItem['value']) is-invalid @enderror" id="model_{{$langItem['value']}}" value="{{ old('model_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->model }}" name="model_{{$langItem['value']}}" placeholder="Nhập model">
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
                                                                        <input type="text" class="form-control nameChangeSlug
                                                                        @error('tinhtrang_'.$langItem['value']) is-invalid @enderror" id="tinhtrang_{{$langItem['value']}}" value="{{ old('tinhtrang_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->tinhtrang }}" name="tinhtrang_{{$langItem['value']}}" placeholder="Nhập tinhtrang">
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
                                                                        <input type="text" class="form-control nameChangeSlug
                                                                        @error('baohanh_'.$langItem['value']) is-invalid @enderror" id="baohanh_{{$langItem['value']}}" value="{{ old('baohanh_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->baohanh }}" name="baohanh_{{$langItem['value']}}" placeholder="Nhập baohanh">
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
                                                                        <input type="text" class="form-control nameChangeSlug
                                                                        @error('xuatsu_'.$langItem['value']) is-invalid @enderror" id="xuatsu_{{$langItem['value']}}" value="{{ old('xuatsu_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->xuatsu }}" name="xuatsu_{{$langItem['value']}}" placeholder="Nhập xuất sứ">
                                                                        @error('xuatsu_'.$langItem['value'])
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
                                                        </div>--}}
														<div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for="">Giới thiệu</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control tinymce_editor_init @error('content2_'.$langItem['value']) is-invalid  @enderror" name="content2_{{$langItem['value']}}" id="" rows="20" value="" placeholder="Nhập nội dung">
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
                                                                <label class="col-sm-2 control-label" for="">Nhập mô tả sản phẩm</label>
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
                                                        {{--
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label class="col-sm-2 control-label" for="">Nhập thông số kỹ thuật</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control tinymce_editor_init @error('content2_'.$langItem['value']) is-invalid  @enderror" name="content2_{{$langItem['value']}}" id="" rows="20" value="" placeholder="Nhập thông số kỹ thuật">
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
                                                                    <label class="col-sm-2 control-label" for="">Nhập chính sách vận chuyển</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control tinymce_editor_init @error('content3_'.$langItem['value']) is-invalid  @enderror" name="content3_{{$langItem['value']}}" id="" rows="20" value="" placeholder="Nhập chính sách vận chuyển">
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
                                                                    <label class="col-sm-2 control-label" for="">Nhập chính sách bảo hành</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control tinymce_editor_init @error('content4_'.$langItem['value']) is-invalid  @enderror" name="content4_{{$langItem['value']}}" id="" rows="20" value="" placeholder="Nhập chính sách bảo hành">
                                                                        {{ old('content4_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->content4 }}
                                                                        </textarea>
                                                                        @error('content4_'.$langItem['value'])
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        --}}
                                                        {{--
                                                             <div class="form-group form-check">
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


                                                <div class="wrap-load-image mb-3">
                                                    <label class="mb-3 w-100">Hình ảnh khác</label>

                                                    <span class="badge badge-success">Đã thêm</span>
                                                    <div class="list-image d-flex flex-wrap">
                                                        @foreach($data->images()->get() as $productImageItem)
                                                             <div class="col-image" style="width:20%;" >
                                                                <img class="" src="{{$productImageItem->image_path}}" alt="{{$productImageItem->name}}">
                                                                <a class="btn btn-sm btn-danger lb_delete_image"  data-url="{{ route('admin.product.destroy-image',['id'=>$productImageItem->id]) }}"><i class="far fa-trash-alt"></i></a>
                                                             </div>
                                                         @endforeach
                                                         @if (!$data->images()->get()->count())
                                                            Chưa thêm hình ảnh nào
                                                         @endif
                                                    </div>
                                                    <hr>
                                                    <span class="badge badge-primary mb-3">Thêm ảnh</span>
                                                    <div class="form-group">
                                                        {{-- <label for="">Thêm ảnh</label> --}}
                                                        <input type="file" class="form-control-file img-load-input-multiple border" id="" name="image[]" multiple>
                                                    </div>
                                                    @error('image')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    <div class="load-multiple-img">
                                                        @if (!$data->images()->get()->count())
                                                        <img class="" src="{{asset('admin_asset/images/upload-image.png')}}" alt="'no image">
                                                        <img class="" src="{{asset('admin_asset/images/upload-image.png')}}" alt="'no image">
                                                        <img class="" src="{{asset('admin_asset/images/upload-image.png')}}" alt="'no image">
                                                        @endif
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
                            <div class="col-md-4">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Thông tin khác</h3>
                                     </div>
                                     <div class="card-body table-responsive p-3">
                                        <div class="form-group">
                                            <label class=" control-label" for="">Chọn danh mục</label>
                                            <select class="form-control custom-select select-2-init @error('category_id')
                                                is-invalid
                                                @enderror" id="" value="{{ old('category_id') }}" name="category_id">

                                                <option value="0">--- Chọn danh mục cha ---</option>

                                                @if (old('category_id')||old('category_id')==='0')
                                                    {!! \App\Models\CategoryProduct::getHtmlOption(old('category_id')) !!}
                                                @else
                                                {!!$option!!}
                                                @endif
                                            </select>
                                            @error('category_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{--
                                            <div class="form-group">
                                                <label class="control-label" for="">Chọn nhà cung cấp</label>
                                                <select class="form-control @error('supplier')
                                                    is-invalid
                                                    @enderror" id="" value="{{ old('supplier_id') }}" name="supplier_id">

                                                    <option value="0">--- Chọn nhà cung cấp ---</option>
                                                    @foreach ($supplier as $item)
                                                    <option value="{{ $item->id }}" {{ (old('supplier')??$data->supplier_id)==  $item->id ?"selected":""}}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('supplier_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        --}}

                                        <div class="form-group">
                                            <label class="control-label" for="">Số thứ tự</label>
                                            <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order')??$data->order }}" name="order" placeholder="Nhập số thứ tự">
                                            @error('order')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{--
                                        <div class="form-group">
                                            <label class="control-label" for="">Giá</label>
                                            <input type="number" min="0" class="form-control  @error('price') is-invalid  @enderror"  value="{{ old('price')??$data->price }}" name="price" placeholder="Nhập giá">
                                            @error('price')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                            <div class="form-group">
                                                <label class=" control-label" for="">Sale(%)</label>
                                                <input type="number" min="0" class="form-control  @error('sale') is-invalid  @enderror"  value="{{ old('sale')??$data->sale }}" name="sale" placeholder="Nhập sale">

                                                @error('sale')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        --}}

                                        <div class="form-group">
                                            <label class="control-label" for="">Sản phẩm nổi bật</label>

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
										 <div class="form-group">
                                            <label class="control-label" for="">Sản phẩm máy móc nổi bật</label>

                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input @error('noibat') is-invalid
                                                        @enderror" value="1" name="noibat" @if(old('noibat')==="1"||$data->noibat==1 ) {{'checked'}} @endif>
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

                                        <hr>
                                        {{--
                                            <div class="alert alert-light  mt-3 mb-1">
                                                <strong>Chọn thuộc tính</strong>
                                            </div>

                                            @foreach ($attributes as $key=> $attribute)

                                                <div class="form-group">
                                                    <label class="control-label" for="">{{ $attribute->name }}</label>
                                                    <select class="form-control"  name="attribute[]" >
                                                        <option value="0">--Chọn--</option>
                                                        @foreach ($attribute->childs()->orderby('order')->get() as $k=> $attr)
                                                            <option value="{{ $attr->id }}"
                                                                @if (old('attribute'))
                                                                    @if ($attr->id==old('attribute')[$key])
                                                                        selected
                                                                    @else
                                                                        {{ $data->attributes()->get()->pluck('id')->contains($attr->id)?'selected':"" }}
                                                                    @endif
                                                                @else
                                                                {{ $data->attributes()->get()->pluck('id')->contains($attr->id)?'selected':"" }}
                                                                @endif
                                                            >
                                                                {{ $attr->name }}
                                                            </option>
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

                                        {{-- <div class="form-group">
                                            <label for="">File</label>
                                          <div>
                                            <a href="{{ $data->file }}" download>{{ $data->file }}</a>
                                          </div>
                                            <input type="file" class="form-control-file img-load-input border @error('file')
                                            is-invalid
                                            @enderror" id="" name="file">
                                            @error('file')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div> 

                                        <div class="form-group">
                                            <label for="">File tài liệu</label>
                                            @if ($data->file)
                                                <div class="list_file mb-2">
                                                     asset('http://docs.google.com/gview?url='.$data->file) 
                                                   <ul class="list-group">
                                                    <li class="file_item list-group-item">
                                                        <a href="{{ asset($data->file) }}" target="blank">{{ $data->file }}   </a>
                                                         <a data-url="{{ route('admin.product.destroyFile',['id'=>$data->id,'field'=>'file']) }}" class="lb_delete_file"><i class="fas fa-times-circle"></i></a>
                                                    </li>
                                                  </ul>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control-file border @error('file')
                                            is-invalid
                                            @enderror" id="" name="file">
                                            @error('file')
                                            <div class="invalid-feedback d-block">$message</div>
                                            @enderror
                                        </div>
                                        --}}

                                        {{--
                                            <div class="form-group">
                                                <label for="">Hướng dẫn sử dụng</label>
                                                <div>
                                                    <a href="{{ $data->file2 }}" download>{{ $data->file2 }}</a>
                                                </div>
                                                <input type="file" class="form-control-file img-load-input border @error('file2')
                                                is-invalid
                                                @enderror" id="" name="file2">
                                                @error('file2')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Drive</label>
                                                <div>
                                                    <a href="{{ $data->file3 }}" download>{{ $data->file3 }}</a>
                                                </div>
                                                <input type="file" class="form-control-file img-load-input border @error('file3')
                                                is-invalid
                                                @enderror" id="" name="file3">
                                                @error('file3')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        --}}
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
