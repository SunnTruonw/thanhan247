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
                        <form action="{{route('profile.updateInfo',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
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
                                                            <input type="file" class="form-control-file img-load-input border" id="" name="avatar_path">
                                                        </div>
                                                        @error('avatar_path')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                        <img class="img-load border p-1 w-100" src="{{$data->avatar_path?$data->avatar_path:$shareFrontend['userNoImage']}}" alt="{{$data->name}}" style="height: auto;width:auto;max-width:150px;object-fit:cover;">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Họ và tên</label>
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror"  value="{{old('name')?? $data->name }}"
                                                        {{ $data->status==1? '':'disabled' }} name="name" placeholder="Họ và tên">
                                                        @error('name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Email liên hệ</label>
                                                        <input type="text" class="form-control @error('email') is-invalid @enderror"  value="{{old('email')?? $data->email }}"
                                                        {{ $data->status==1? '':'disabled'}}
                                                            name="email" placeholder="Email">
                                                        @error('email')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Tài khoản</label>
                                                        <input type="text" class="form-control  @error('username') is-invalid @enderror"
                                                        {{ $data->status==1? '':'disabled'}}
                                                        value="{{old('username')?? $data->username }}" name="username" placeholder="username">
                                                        @error('username')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Số điện thoại</label>
                                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                        {{ $data->status==1? '':'disabled'}}
                                                        value="{{ old('phone')?? $data->phone }}" name="phone" placeholder="Số điện thoại">
                                                        @error('phone')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Ngày sinh</label>
                                                        <input type="date" class="form-control  @error('date_birth') is-invalid @enderror"
                                                        {{ $data->status==1? '':'disabled'}}
                                                        value="{{ old('date_birth')?? $data->date_birth }}" name="date_birth" placeholder="Ngày sinh">
                                                        @error('date_birth')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Địa chỉ</label>
                                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                                        {{ $data->status==1? '':'disabled'}}
                                                        value="{{ old('address')?? $data->address }}" name="address" placeholder="Địa chỉ">
                                                        @error('address')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Hộ khẩu thường trú</label>
                                                        <input type="text" class="form-control  @error('hktt') is-invalid @enderror"
                                                        {{ $data->status==1? '':'disabled'}}
                                                        value="{{ old('hktt')?? $data->hktt }}" name="hktt" placeholder="Hộ khẩu thường trú">
                                                        @error('hktt')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Chứng minh thư</label>
                                                        <input type="text" class="form-control @error('cmt') is-invalid @enderror"
                                                        {{ $data->status==1? '':'disabled' }}
                                                        value="{{  old('cmt')?? $data->cmt }}" name="cmt" placeholder="Chứng minh thư">
                                                        @error('cmt')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

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
                                                            <div class="alert alert-danger">{{ $message }}</div>
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
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Số tài khoản</label>
                                                        <input type="text" class="form-control @error('stk') is-invalid @enderror"
                                                        value="{{  old('stk')??  $data->stk }}" name="stk" placeholder="Số tài khoản">
                                                        @error('stk')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Họ tên chủ tài khoản</label>
                                                        <input type="text" class="form-control @error('ctk') is-invalid @enderror"
                                                        value="{{  old('ctk')?? $data->ctk }}" name="ctk" placeholder="Chủ tài khoản">
                                                        @error('ctk')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Ngân hàng</label>
                                                        <select name="bank_id" class="form-control" id="" >
                                                            <option value="0">Chọn ngân hàng</option>
                                                            @foreach ($banks as $bank)
                                                            <option value="{{ $bank->id }}" {{ (old('bank_id')?? $data->bank_id)==$bank->id ?'selected':''}}>{{ $bank->name }}</option>
                                                            @endforeach
                                                        </select>

                                                        @error('bank_id')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Chi nhánh ngân hàng</label>
                                                        <input type="text" class="form-control @error('bank_branch') is-invalid @enderror"  value="{{old('bank_branch')?? $data->bank_branch }}" name="bank_branch" placeholder="Tên chi nhánh ngân hàng">
                                                        @error('bank_branch')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

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
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" name="checkrobot" id="" required>
                                                        <label class="form-check-label" for="" >Tôi đồng ý</label>
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
<script>

   $(function(){
        // js load image khi upload
    $(document).on('change', '.img-load-input', function() {
        let input = $(this);
        displayImage(input, '.wrap-load-image', '.img-load');
    });

    function displayImage(input, selectorWrap, selectorImg) {
        let img = input.parents(selectorWrap).find(selectorImg);
        let file = input.prop('files')[0];
        let reader = new FileReader();

        reader.addEventListener("load", function() {
            // convert image file to base64 string
            img.attr('src', reader.result);
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
   });

</script>
@endsection
