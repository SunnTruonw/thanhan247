@extends('admin.layouts.main')
@section('title',"Danh sách vai trò")
@section('css')
@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Vai trò","key"=>"Danh sách vai trò"])

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
                <a href="{{route('admin.role.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>

                <div class="card card-outline card-primary">
                    <div class="card-body table-responsive p-0 lb-list-category">
                        <table class="table table-head-fixed" style="font-size:13px;">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>ID</th>
                                    <th>name</th>
                                    <th>description</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($data as $roleItem)
                                <tr>
                                    <td>{{$loop->index}}</td>
                                    <td>{{$roleItem->id}}</td>
                                    <td>{{$roleItem->name}}</td>
                                    <td>{{$roleItem->description}}</td>
                                    <td>
                                        <a href="{{route('admin.role.edit',['id'=>$roleItem->id])}}" class="btn btn-sm  btn-success"><i class="fas fa-edit"></i></a>
                                        <a data-url="{{route('admin.role.destroy',['id'=>$roleItem->id])}}" class="btn btn-sm  btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
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
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

@endsection
@section('js')
@endsection
