@extends('admin.layouts.main')
@section('title',"Thêm  quyền")

@section('content')


  <div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Quyền","key"=>"Thêm quyền"])

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
              <form action="{{route('admin.permission.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                               <h3 class="card-title">Thông tin quyền</h3>
                            </div>
                            <div class="card-body table-responsive p-3">
                                <div class="form-group">
                                    <label for="">Tên tài khoản</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id=""
                                        value="{{ old('name') }}"  name="name"
                                        placeholder="Nhập tên tài khoản"
                                    >
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                  <div class="form-group">
                                        <label for="">Description</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id=""
                                            value="{{ old('description') }}"
                                            name="description"
                                            placeholder="Nhập description"
                                        >
                                  </div>
                                  @error('description')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                  <div class="form-group">
                                    <label for="">Chọn danh mục cha</label>
                                    <select class="form-control custom-select" id="" value="{{ old('parentId') }}" name="parentId">
                                      <option value="0">Chọn danh mục cha</option>
                                      {!!$option!!}
                                    </select>
                                  </div>
                                  @error('parentId')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                  <div class="form-group">
                                        <label for="">key_code</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id=""
                                            value="{{ old('key_code') }}"
                                            name="key_code"
                                            placeholder="Nhập key_code"
                                        >
                                  </div>
                                    @error('key_code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                  {{-- <div class="form-group form-check">
                                  <input type="checkbox" class="form-check-input" name="checkrobot" id="checkrobot" required>
                                  <label class="form-check-label" for="checkrobot">Tôi đồng ý</label>
                                  </div>
                                  @error('checkrobot')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror --}}
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
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
@endsection
