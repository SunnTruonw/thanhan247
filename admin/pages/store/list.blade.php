@extends('admin.layouts.main')
@section('title',"Danh sach xuất nhập kho")

@section('css')

@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Kho","key"=>"Danh sách xuất nhập kho"])

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
                    <a href="{{ route('admin.store.create',['type'=>1]) }}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>

                    <div class="card card-outline card-primary">
                        <div class="card-body table-responsive p-0 lb-list-category">
                            <table class="table table-head-fixed" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Kiểu</th>
                                        <th>Số lượng</th>
                                        <th>Mã giao dịch (nếu có)</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->index }}</td>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $typeStore[$item->type]['name']}}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>
                                                @if ($item->transaction_id)
                                                {{ $item->transaction->code}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->type==1)
                                                <a href="{{ route('admin.store.edit',['id'=>$item->id]) }}" class="btn btn-sm  btn-success"><i class="fas fa-edit"></i></a>
                                                <a data-url="{{ route('admin.store.destroy',['id'=>$item->id]) }}" class="btn btn-sm  btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                                @endif

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
