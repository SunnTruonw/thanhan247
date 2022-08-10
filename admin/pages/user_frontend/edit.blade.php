@extends('admin.layouts.main')
@section('title',"Sửa thành viên")
@section('css')
<link href="{{asset('lib/select2/css/select2.min.css')}}" rel="stylesheet" />
<style>
   .select2-container--default .select2-selection--multiple .select2-selection__choice{
   background-color: #000 !important;
   }
   .select2-container .select2-selection--single{
   height: auto;
   }
</style>
@endsection

@section('content')
<div class="content-wrapper">
   @include('admin.partials.content-header',['name'=>"Amin User","key"=>"Sửa thành viên"])
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
               <form action="{{route('admin.user_frontend.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
                  @csrf

                  <div class="row">
                     <div class="col-md-12">

                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thông tin tài khoản</h3>
                            </div>
                            <div class="card-body table-responsive p-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="wrap-load-image mb-3">
                                            <div class="form-group">
                                                <label for="">Ảnh đại diện</label>
                                                <input type="file" class="form-control-file img-load-input border " id="" name="avatar_path">
                                                @error('avatar_path')
                                                <div class="invalid-feedback  d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <img class="img-load border p-1 w-100" src="{{$data->avatar_path?$data->avatar_path:$shareFrontend['userNoImage']}}" alt="{{$data->name}}" style="height: auto;width:auto;max-width:150px;object-fit:cover;">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Họ và tên</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"  value="{{old('name')?? $data->name }}"
                                            name="name" placeholder="Họ và tên">
                                            @error('name')
                                            <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Email liên hệ</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror"  value="{{old('email')?? $data->email }}"

                                                name="email" placeholder="Email">
                                            @error('email')
                                            <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Tài khoản</label>
                                            <input type="text" class="form-control  @error('username') is-invalid @enderror"

                                            value="{{old('username')?? $data->username }}" name="username" placeholder="username">
                                            @error('username')
                                            <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Số điện thoại</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"

                                            value="{{ old('phone')?? $data->phone }}" name="phone" placeholder="Số điện thoại">
                                            @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Ngân hàng</label>
                                            <input type="text" class="form-control @error('ctk') is-invalid @enderror"

                                            value="{{ old('ctk')?? $data->ctk }}" name="ctk" placeholder="Ngân hàng">
                                            @error('ctk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Số tài khoản ngân hàng</label>
                                            <input type="text" class="form-control @error('stk') is-invalid @enderror"

                                            value="{{ old('stk')?? $data->stk }}" name="stk" placeholder="Số tài khoản ngân hàng">
                                            @error('stk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Ngày sinh</label>
                                            <input type="date" class="form-control  @error('date_birth') is-invalid @enderror"

                                            value="{{ old('date_birth')?? $data->date_birth }}" name="date_birth" placeholder="Ngày sinh">
                                            @error('date_birth')
                                            <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Địa chỉ</label>
                                            <input type="text" class="form-control @error('address') is-invalid @enderror"

                                            value="{{ old('address')?? $data->address }}" name="address" placeholder="Địa chỉ">
                                            @error('address')
                                            <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{--
                                        <div class="form-group">
                                            <label for="">Hộ khẩu thường trú</label>
                                            <input type="text" class="form-control  @error('hktt') is-invalid @enderror"

                                            value="{{ old('hktt')?? $data->hktt }}" name="hktt" placeholder="Hộ khẩu thường trú">
                                            @error('hktt')
                                            <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Chứng minh thư</label>
                                            <input type="text" class="form-control @error('cmt') is-invalid @enderror"
                                            value="{{  old('cmt')?? $data->cmt }}" name="cmt" placeholder="Chứng minh thư">
                                            @error('cmt')
                                            <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        --}}
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Mật khẩu</label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                id=""
                                                value="{{ old('password') }}"  name="password"
                                                placeholder="Mật khẩu"
                                            >
                                            @error('password')
                                                <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nhập lại mật khẩu </label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                id=""
                                                value="{{ old('password_confirmation') }}"  name="password_confirmation"
                                                placeholder="Nhập lại mật khẩu"
                                            >
                                            @error('password_confirmation')
                                                <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-0">
                                            <label for="">Ngày thanh toán </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id=""
                                                value="{{ old('date_payment') }}"  name="date_payment"
                                                placeholder="Nhập ngày thanh toán"
                                            >
                                            @error('date_payment')
                                                <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                            {{-- <select id="" name="date_payment" class="form-control">
                                                <option value="">-- Ngày thanh toán --</option>
                                                <option value="Thứ 2">Thứ 2</option>
                                                <option value="Thứ 3">Thứ 3</option>
                                                <option value="Thứ 4">Thứ 4</option>
                                                <option value="Thứ 5">Thứ 5</option>
                                                <option value="Thứ 6">Thứ 6</option>
                                                <option value="Thứ 7">Thứ 7</option>
                                                <option value="Chủ nhật">Chủ nhật</option>
                                            </select> --}}
                                        </div>
{{--
                                        <div class="form-group">
                                            <label for="">Số tài khoản</label>
                                            <input type="text" class="form-control @error('stk') is-invalid @enderror"
                                            value="{{  old('stk')??  $data->stk }}" name="stk" placeholder="Số tài khoản">
                                            @error('stk')
                                            <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Họ tên chủ tài khoản</label>
                                            <input type="text" class="form-control @error('ctk') is-invalid @enderror"
                                            value="{{  old('ctk')?? $data->ctk }}" name="ctk" placeholder="Chủ tài khoản">
                                            @error('ctk')
                                            <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Ngân hàng</label>
                                            <select name="bank_id" class="form-control" id="" >
                                                <option value="">Chọn ngân hàng</option>
                                                @foreach ($banks as $bank)
                                                <option value="{{ $bank->id }}" {{ (old('bank_id')?? $data->bank_id)==$bank->id ?'selected':''}}>{{ $bank->name }}</option>
                                                @endforeach
                                            </select>

                                            @error('bank_id')
                                                <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Chi nhánh ngân hàng</label>
                                            <input type="text" class="form-control @error('bank_branch') is-invalid @enderror"  value="{{old('bank_branch')?? $data->bank_branch }}" name="bank_branch" placeholder="Tên chi nhánh ngân hàng">
                                            @error('bank_branch')
                                            <div class="invalid-feedback  d-block">{{ $message }}</div>
                                            @enderror
                                        </div> --}}

                                        <div class="form-group">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="1" name="sex" @if((old('sex')?? $data->sex)=="1"||$data->sex==null) {{'checked'}} @endif>Nam
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="0" @if( (old('sex')?? $data->sex)=="0"){{'checked'}} @endif name="sex">Nữ
                                                </label>
                                            </div>
                                            @error('sex')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" name="checkrobot" id="" required>
                                            <label class="form-check-label" for="" >Tôi đồng ý</label>
                                        </div>
                                        @error('checkrobot')
                                        <div class="invalid-feedback  d-block">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Chấp nhận</button>
                                            <button type="reset" class="btn btn-danger">Làm lại</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                     </div>
                  </div>
               </form>
            </div>
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content -->
</div>
@endsection
@section('js')
<script src="{{asset('lib/select2/js/select2.min.js')}}"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
<script>
   $(function(){
     $(".select-2-init").select2({
       placeholder: "Chọn role",
       allowClear: true
     })
   })
</script>
@endsection
