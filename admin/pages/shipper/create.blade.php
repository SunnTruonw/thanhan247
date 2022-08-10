@extends('admin.layouts.main')
@section('title', 'Thêm shipper')
@section('css')
    <style>
        .help-block.error-help-block {
            color: red
        }

    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>"Shipper","key"=>"Thêm nhân viên giao hàng"])
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.shipper.store') }}" method="POST" id="form-create-shipper">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Tạo nhân viên giao hàng</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Tên nhân viên
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" name="name" value="{{ old('name') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Email
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="email" name="email" value="{{ old('name') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Số điên thoại
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="number" name="phone" value="{{ old('phone') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Địa chỉ
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" name="address" value="{{ old('address') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Biển số xe
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" name="license_plates"
                                                        value="{{ old('license_plates') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-12 text-center">
                                                    <button type="submit" class="btn btn-primary">
                                                        Xác nhận
                                                    </button>
                                                </div>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Shipper\CreateAndUpdateShipperRequest', '#form-create-shipper') !!}
    <script>
        @if (Session::has('message'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
            toastr.success("{{ session('message') }}");
        @endif
        @if (Session::has('error'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endsection
