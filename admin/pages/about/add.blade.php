@extends('admin.layouts.main')
@section('title', 'Thêm giấy giới thiệu')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>"Giấy giới thiệu","key"=>"Thêm giấy giới thiệu"])
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
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    @if ($errors->all())
                                        <div class="card-header">
                                            @foreach ($errors->all() as $message)
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
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
                                            <div class="form-group">
                                                <label class="control-label" for="">Tên</label>
                                                <input type="text"
                                                    class="form-control
                                                        @error('name') is-invalid @enderror"
                                                    value="{{ old('name') }}"
                                                    name="name" placeholder="Nhập tiêu đề">
                                                @error('name')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="">Điểm đến</label>
                                                <input type="text"
                                                    class="form-control
                                                        @error('to') is-invalid @enderror"
                                                    value="{{ old('to') }}"
                                                    name="to" placeholder="Nhập điểm đến">
                                                @error('to')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="">Ngày cấp</label>
                                                <input type="date"
                                                    class="form-control
                                                        @error('created_date') is-invalid @enderror"
                                                    value="{{ old('created_date') }}"
                                                    name="created_date" >
                                                @error('created_date')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class=" control-label" for="">Chọn phóng viên</label>
                                                <select class="form-control custom-select select-2-init @error('admin_id')
                                                    is-invalid
                                                    @enderror" id="" value="{{ old('admin_id') }}" name="admin_id" data-title="Chọn phóng viên">

                                                    <option value="">--- Chọn phóng viên ---</option>
                                                    @foreach ($admins as $admin)
                                                    <option value="{{ $admin->id }}" {{ old('admin_id')== $admin->id?'selected':'' }}>{{ $admin->name }}</option>
                                                    @endforeach


                                                </select>
                                                @error('admin_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="">Nhập mô tả</label>
                                                <textarea
                                                    class="form-control tinymce_editor_init @error('description' ) is-invalid  @enderror"
                                                    name="description" id="" rows="20"
                                                    value="" placeholder="Nhập mô tả">
                                                        {{ old('description' ) }}
                                                        </textarea>
                                                @error('description' )
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
