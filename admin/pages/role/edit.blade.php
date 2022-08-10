@extends('admin.layouts.main')
@section('title',"Edit role")
@section('css')
@endsection
@section('content')
<div class="content-wrapper">
   @include('admin.partials.content-header',['name'=>"Vai trò","key"=>"Sửa vai trò"])
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
               <form action="{{route('admin.role.update',['id'=>$data->id])}}" method="POST">
                  @csrf
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card card-outline card-primary">
                           <div class="card-header">
                              <h3 class="card-title">Thông tin vai trò</h3>
                           </div>
                           <div class="card-body table-responsive p-3">
                              <div class="form-group">
                                 <label for="">Tên role</label>
                                 <input
                                    type="text"
                                    class="form-control"
                                    id=""
                                    value="{{ $data->name }}"  name="name"
                                    placeholder="Nhập name"
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
                                    value="{{ $data->description }}"  name="description"
                                    placeholder="Nhập description"
                                    >
                                 @error('description')
                                 <div class="alert alert-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                              <div class="mt-3 mb-2 wrap-permission">
                                 <div class="item-permission mt-2 mb-2 ">
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
                                                      <input
                                                      type="checkbox"
                                                      class="form-check-input check-children"
                                                      name="permission_id[]"
                                                      value="{{ $permissionsChildrenItem->id }}"
                                                      @if ($dataPermissionsOfRole->get()->contains($permissionsChildrenItem->id))
                                                      {{ 'checked' }}
                                                      @endif
                                                      >
                                                      {{ $permissionsChildrenItem->name }}
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
                                 <input type="checkbox" class="form-check-input" name="checkrobot" id="checkrobot">
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
@endsection
