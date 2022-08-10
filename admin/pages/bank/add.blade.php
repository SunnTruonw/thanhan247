@extends('admin.layouts.main')
@section('title',"thêm category")

@section('content')
<div class="content-wrapper">
   @include('admin.partials.content-header',['name'=>"Ngân hàng","key"=>"Thêm Ngân hàng"])
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
               <form action="{{route('admin.bank.store')}}" method="POST">
                  @csrf
                  <div class="card card-outline card-primary">
                     <div class="card-header">
                        <h3 class="card-title">Thông tin ngân hàng</h3>
                     </div>
                     <div class="card-body table-responsive p-3">
                        <div class="form-group">
                           <label for="">Tên danh mục</label>
                           <input
                              type="text"
                              class="form-control"
                              id="name"
                              value="{{ old('name') }}"  name="name"
                              placeholder="Nhập tên ngân hàng"
                              >
                           @error('name')
                           <div class="alert alert-danger">{{ $message }}</div>
                           @enderror
                        </div>

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
                        @enderror
                        <div class="form-group form-check">
                           <input type="checkbox" class="form-check-input" name="checkrobot" id="checkrobot" required>
                           <label class="form-check-label" for="checkrobot" required>Check me out</label>
                        </div>
                        @error('checkrobot')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                           <button type="reset" class="btn btn-danger">Reset</button>
                           <button type="submit" class="btn btn-primary">Chấp nhận</button>
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
