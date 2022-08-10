@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{-- @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset --}}
            <div class="wrap-content-main">
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

                        <form action="{{route('profile.storeMember')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                        <h3 class="card-title">Thông tin thành viên</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="form-group">
                                                <label for="">Họ và tên</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id=""
                                                    value="{{ old('name') }}"  name="name"
                                                    placeholder="Nhập Họ và tên"
                                                >
                                                @error('name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="">Tài khoản</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id=""
                                                    value="{{ old('username') }}"  name="username"
                                                    placeholder="Nhập tài khoản"
                                                >
                                                @error('username')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Mã combo</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id=""
                                                    value="{{ old('masp') }}"  name="masp"
                                                    placeholder="Nhập mã sản phẩm"
                                                    required
                                                >
                                                @error('masp')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            {{-- <div class="form-group">
                                                <label for="">Số điểm đã nap</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id=""
                                                    value="{{ old('startpoint') }}"  name="startpoint"
                                                    placeholder="Nhập số điểm đã nạp"
                                                    required
                                                >
                                                @error('startpoint')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div> --}}

                                            {{-- <div class="form-group">
                                                <label for="">Email</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id=""
                                                    value="{{ old('email') }}"  name="email"
                                                    placeholder="Email"
                                                >
                                                @error('email')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div> --}}
                                            {{-- <div class="form-group">
                                                <label for="">Mật khẩu</label>
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    id=""
                                                    value="{{ old('password') }}"  name="password"
                                                    placeholder="Mật khẩu"
                                                >
                                                @error('password')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div> --}}
                                            {{-- <div class="form-group">
                                                <label for="">Nhập lại mật khẩu</label>
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    id=""
                                                    value="{{ old('password_confirmation') }}"  name="password_confirmation"
                                                    placeholder="Nhập lại mật khẩu"
                                                >
                                                @error('password_confirmation')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div> --}}
                                            {{-- <div class="form-group">
                                            <label for="">Chọn vai trò</label>
                                            <select name="role_id[]" class="form-control select-2-init" id="" multiple>
                                                <option value=""></option>
                                                @foreach ($dataRoles as $roleItem)
                                                <option value="{{ $roleItem->id }}">{{ $roleItem->name }}</option>
                                                @endforeach
                                            </select>

                                            @error('role_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            </div> --}}
                                            {{--
                                            <div class="form-group">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                    <input
                                                        type="radio"
                                                        class="form-check-input"
                                                        value="1"
                                                        name="active"
                                                        @if(old('active')==="1"||old('active')===null) {{'checked'}}  @endif
                                                    >
                                                    Active
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input
                                                            type="radio"
                                                            class="form-check-input"
                                                            value="0"
                                                            @if(old('active')==="0"){{'checked'}}  @endif
                                                            name="active"
                                                        >
                                                        Disable
                                                    </label>
                                                </div>
                                            </div>
                                            @error('active')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror --}}
                                            <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" name="checkrobot" id="checkrobot" required>
                                            <label class="form-check-label" for="checkrobot">Tôi đồng ý</label>
                                            </div>
                                            @error('checkrobot')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Chấp nhận</button>
                                            <button type="reset" class="btn btn-danger">Làm lại</button>
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
