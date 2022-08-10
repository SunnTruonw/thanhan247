@extends('admin.layouts.main')
@section('title',"Danh sach ngân hàng")

@section('css')

@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Ngân hàng","key"=>"Danh sách Ngân hàng"])

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
                <div class="col-md-12">
                    <a href="{{ route('admin.bank.create') }}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>

                    <div class="card card-outline card-primary">
                        <div class="card-body table-responsive p-0 lb-list-category">
                            <table class="table table-head-fixed" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>name</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->index }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <a href="{{ route('admin.bank.edit',['id'=>$item->id]) }}" class="btn btn-sm  btn-success"><i class="fas fa-edit"></i></a>
                                                <a data-url="{{ route('admin.bank.destroy',['id'=>$item->id]) }}" class="btn btn-sm  btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
@endsection
