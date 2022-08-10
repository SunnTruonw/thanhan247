@extends('admin.layouts.main')
@section('title',"Thêm vai trò")
@section('css')
@endsection

@section('content')
<div class="content-wrapper">
   @include('admin.partials.content-header',['name'=>"Vai trò","key"=>"Thêm vai trò"])
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
               <form action="{{route('admin.role.store')}}" method="POST">
                  @csrf
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card card-outline card-primary">
                           <div class="card-header">
                              <h3 class="card-title">Thông tin vai trò</h3>
                           </div>
                           <div class="card-body table-responsive p-3">
                              <div class="form-group">
                                 <label for="">Tên Vai trò</label>
                                 <input
                                    type="text"
                                    class="form-control"
                                    id=""
                                    value="{{ old('name') }}"  name="name"
                                    placeholder="Nhập role"
                                    >
                                 @error('name')
                                 <div class="alert alert-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                              <div class="form-group">
                                 <label for="">Mô tả</label>
                                 <input
                                    type="text"
                                    class="form-control"
                                    id=""
                                    value="{{ old('description') }}"  name="description"
                                    placeholder="Nhập mô tả"
                                    >
                                 @error('description')
                                 <div class="alert alert-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                              <div class="form-group mt-3 mb-2 wrap-permission">
                                 <div class="item-permission mt-2 mb-2">
                                    <div class="form-check  permission-title">
                                       <label class="form-check-label p-3 ">
                                       <input  type="checkbox" class="form-check-input checkall" value="">Chọn tất cả
                                       </label>
                                    </div>
                                 </div>
                                 <div class="row">
                                    @foreach ($dataPermissions as $permissionsItem)
                                    <div class="col-md-4">
                                       <div class="item-permission mt-2 mb-2">
                                          <div class="form-check  permission-title">
                                             <label class="form-check-label p-3">
                                                <input type="checkbox" class="form-check-input check-parent" value="{{ $permissionsItem->id }}">{{ $permissionsItem->name }}
                                             </label>
                                          </div>
                                          <div class="list-permission p-3">
                                             <div class="row">
                                                @foreach ($permissionsItem->childs as $permissionsChildrenItem)
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                   <div class="form-check">
                                                      <label class="form-check-label">
                                                      <input type="checkbox" class="form-check-input check-children" name="permission_id[]" value="{{ $permissionsChildrenItem->id }}">{{ $permissionsChildrenItem->name }}
                                                      </label>
                                                   </div>
                                                </div>
                                                @endforeach
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    @endforeach
                                 </div>
                              </div>
                              @error('permission_id')
                              <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
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
