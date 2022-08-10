@extends('admin.layouts.main')
@section('title',"Danh sach quyền")
@section('css')


@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Quyền","key"=>"Danh sách quyền"])

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
                <a href="{{route('admin.permission.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                <div class="card card-outline card-primary">

                    <div class="card-body table-responsive lb-list-category">
                        @include('admin.components.permission', [
                            'data' => $data,
                            'routeNameEdit'=>'admin.permission.edit',
                            'routeNameAdd'=>'admin.permission.create',
                            'routeNameDelete'=>'admin.permission.destroy',
                        ])
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
