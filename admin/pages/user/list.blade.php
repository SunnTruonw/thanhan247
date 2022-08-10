@extends('admin.layouts.main')
@section('title',"danh sach nhân viên")

@section('css')
<link rel="stylesheet" href="{{asset('lib/sweetalert2/css/sweetalert2.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>" Admin User","key"=>"Danh sách admin user"])

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
                <a href="{{route('admin.user.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                <div class="card card-outline card-primary">
                    <div class="card-body table-responsive p-0 lb-list-category">
                        <table class="table table-head-fixed" style="font-size:13px;">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>ID</th>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $adminItem)
                                <tr>
                                    <td>{{$loop->index}}</td>
                                    <td>{{$adminItem->id}}</td>
                                    <td>{{$adminItem->name}}</td>
                                    <td>{{$adminItem->email}}</td>
                                    <td>
                                        <a href="{{route('admin.user.edit',['id'=>$adminItem->id])}}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                        <a data-url="{{route('admin.user.destroy',['id'=>$adminItem->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                {{$data->links()}}
            </div>
        </div>
      </div>
    </div>
</div>

@endsection
@section('js')
{{-- <script src="{{asset('')}}"></script> --}}
<script src="{{asset('lib/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('admin_asset/ajax/deleteAdminAjax.js')}}"></script>
@endsection
