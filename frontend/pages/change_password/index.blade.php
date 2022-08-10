@extends('frontend.layouts.main-profile')

@section('css')
    <style>
        .help-block.error-help-block {
            color: red
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('update.password.post') }}" method="POST" id="form-update-password">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Đổi mật khẩu</h3>
                                </div>
                                <div class="card-body table-responsive p-3">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="">Mật khẩu hiện tại</label>
                                                <input type="password" class="form-control" id=""
                                                    value="{{ old('current_password') }}" name="current_password"
                                                    placeholder="Nhập mật khẩu hiện tại">

                                            </div>
                                            <div class="form-group">
                                                <label for="">Mật khẩu mới
                                                </label>
                                                <input type="password" class="form-control" id=""
                                                    value="{{ old('password') }}"
                                                    name="password"
                                                    placeholder="Nhập mật khẩu mới">

                                            </div>
                                            <div class="form-group">
                                                <label for="">Xác nhận mật khẩu mới
                                                </label>
                                                <input type="password" class="form-control" id=""
                                                    value="{{ old('password_confirmation') }}"
                                                    name="password_confirmation"
                                                    placeholder="Nhập lại mật khẩu mới">

                                            </div>
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-primary">Chấp nhận</button>
                                                <button type="reset" class="btn btn-danger">Làm lại</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\Frontend\UpdatePasswordRequest', '#form-update-password') !!}
@endsection
