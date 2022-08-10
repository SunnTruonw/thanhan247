@extends('admin.layouts.main')
@section('title',"Thêm menu")

@section('content')

  <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>"Menu","key"=>"Sửa menu"])
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
                <form action="{{route('admin.menu.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
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
                                   <h3 class="card-title">Thông tin menu</h3>
                                </div>
                                <div class="card-body table-responsive p-3">
                                    <ul class="nav nav-tabs">
                                        @foreach ($langConfig as $langItem)
                                        <li class="nav-item">
                                            <a class="nav-link {{$langItem['value']==$langDefault?'active':''}}" data-toggle="tab" href="#tong_quan_{{$langItem['value']}}">{{ $langItem['name'] }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach ($langConfig as $langItem)
                                        <div id="tong_quan_{{$langItem['value']}}" class="p-3 tab-pane {{$langItem['value']==$langDefault?'active show':''}} fade">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-sm-2 control-label" for="">Tên</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control nameChangeSlug
                                                        @error('name_'.$langItem['value']) is-invalid @enderror" id="name_{{$langItem['value']}}" value="{{ old('name_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->name }}" name="name_{{$langItem['value']}}" placeholder="Nhập tên">
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
                                                        <input type="text" class="form-control
                                                        @error('slug_'.$langItem['value']) is-invalid  @enderror" id="slug_{{ $langItem['value'] }}" value="{{ old('slug_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->slug }}" name="slug_{{ $langItem['value'] }}" placeholder="Nhập slug">
                                                        @error('slug_'.$langItem['value'])
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

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
                                    <div class="wrap-load-image mb-3">
                                        <div class="form-group">
                                            <label for="">Hình ảnh</label>
                                            <input type="file" class="form-control-file img-load-input border" id="" value="" name="avatar_path">
                                        </div>
                                        @error('avatar_path')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        @if ($data->avatar_path)
                                        <img class="img-load border p-1 w-100" src="{{asset($data->avatar_path)}}" alt="{{$data->name}}" style="object-fit:contain;">
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="">Chọn danh mục</label>
                                        <select class="form-control custom-select select-2-init @error('parent_id')
                                            is-invalid
                                            @enderror" id="" value="{{ old('parent_id') }}" name="parent_id">
                                            <option value="0">--- Root---</option>
                                            @if (old('parent_id')||old('parent_id')==='0')
                                            {!! \App\Models\Menu::getHtmlOptionAddWithParent(old('parent_id')) !!}
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

                                        <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order')??$data->order }}" name="order" placeholder="Nhập số thứ tự">

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
      </div>
    </div>
</div>
@endsection

@section('js')

@endsection
