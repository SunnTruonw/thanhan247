@extends('admin.layouts.main')
@section('title',"Thêm menu")

@section('content')

  <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>"Menu","key"=>"Sửa menu"])
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                @if(session("alert"))
                    <div class="alert alert-success">
                        {{session("alert")}}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-warning">
                        {{session("error")}}
                    </div>
                @endif
                <form action="{{route('admin.store.update',['id'=>$data->id])}}" method="POST">
                    @csrf
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                        <h3 class="card-title">Thông tin nhập kho</h3>
                        </div>
                        <div class="card-body table-responsive p-3">
                            <div class="form-group">
                                <label for="">Mã sản phẩm</label>
                                <input type="text" class="form-control" id="masp" value="{{ $data->product->masp }}"  name="masp" placeholder="Mã sản phẩm">
                                @error('masp')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Số lượng nhập kho</label>
                                <input type="text" class="form-control"  value="{{ $data->quantity }}"  name="quantity" placeholder="Số lượng nhập kho">
                                @error('quantity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="form-check-inline">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" value="1" name="active" @if( $data->active==="1"||old('active')===null||old('active')==="1") {{'checked'}}  @endif>Hiện
                                </label>
                                </div>
                                <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="0" @if( $data->active==="0"||old('active')==="0"){{'checked'}}  @endif name="active">Ẩn
                                </label>
                                </div>
                            </div>
                            @error('active')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="checkrobot" id="checkrobot">
                            <label class="form-check-label" for="checkrobot" required>Tôi đồng ý</label>
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
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('js')

@endsection
