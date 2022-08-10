@extends('admin.layouts.main')
@section('title',"Thêm kho")

@section('content')
<div class="content-wrapper">
   @include('admin.partials.content-header',['name'=>"Kho","key"=>"Thêm kho"])
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
               <form action="{{route('admin.store.store',['type'=>$request->type??0])}}" method="POST">
                  @csrf
                  <div class="card card-outline card-primary">
                     <div class="card-header">
                        <h3 class="card-title">
                            @if ($request->type==1)
                                Nhập kho
                            @elseif ($request->type==3)
                                Xuất kho
                            @else
                            Thông tin kho
                            @endif
                        </h3>
                     </div>
                     <div class="card-body table-responsive p-3">
                        @if ($request->type==1)
                        <div class="form-group">
                            <label for="">Mã sản phẩm</label>
                            <input
                               type="text"
                               class="form-control"
                               id="masp"
                               value="{{ old('masp') }}"  name="masp"
                               placeholder="Nhập mã sản phẩm"
                               >
                            @error('code')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                         </div>

                         <div class="form-group">
                            <label for="">Nhập số lượng sản phẩm</label>
                            <input
                               type="number"
                               class="form-control"
                               id="name"
                               value="{{ old('quantity') }}"  name="quantity"
                               placeholder="Nhập số lượng sản phẩm"
                               >
                            @error('quantity')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                         </div>

                        @endif

                        @if ($request->type==3)
                        <div class="form-group">
                            <label for="">Nhập mã đơn hàng</label>
                            <input
                               type="text"
                               class="form-control"
                               id="name"
                               value="{{ old('transaction_code') }}"  name="transaction_code"
                               placeholder="Nhập mã đơn hàng"
                               >
                            @error('transaction_code')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                         </div>
                        @endif


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
                                    Hiện
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
                                    Ẩn
                              </label>
                           </div>
                        </div>
                        @error('active')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group form-check">
                           <input type="checkbox" class="form-check-input" name="checkrobot" id="checkrobot" required>
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
