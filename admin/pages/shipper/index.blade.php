@extends('admin.layouts.main')

@section('title', 'Danh sách shipper')

@section('content')
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>"Shipper","key"=>"Danh sách shipper"])
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('admin.shipper.create') }}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                        <div class="card card-outline card-primary">
                            <div class="card-body table-responsive p-0 lb-list-category">
                                <table class="table table-head-fixed" style="font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên</th>
                                            <th class="white-space-nowrap ">Email</th>
                                            <th class="white-space-nowrap">Số điện thoại</th>
                                            <th class="white-space-nowrap">Địa chỉ</th>
                                            <th class="white-space-nowrap">Biển số xe</th>
                                            <th class="white-space-nowrap">Số đơn đã giao</th>
                                            <th style="width:150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shippers as $key => $shipper)
                                            <tr>
                                                <td>{{ $shipper->id }}</td>
                                                <td>{{ $shipper->name }}</td>
                                                <td>{{ $shipper->email }}</td>
                                                <td>{{ $shipper->phone }}</td>
                                                <td>{{ $shipper->address }}</td>
                                                <td>{{ $shipper->license_plates }}</td>
                                                <td>{{ $counts[$key] }}</td>
                                                <td>
                                                    <a href="{{ route('admin.shipper.edit', ['id' => $shipper->id]) }}"
                                                        class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                                    <button title="delete"
                                                        class="btn btn btn-outline-danger btn-last btnDelete1"
                                                        data-id="{{ $shipper->id }}" data-target="#deleteItem"
                                                        data-text="url"
                                                        data-action="{{ route('admin.shipper.destroy', ['id' => $shipper->id]) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row mt-3">
                                <div class="col-md-7 mt-3 pl-3">
                                    <div id="dataTable_info" role="status" aria-live="polite" class="dataTables_info">
                                        Show：{{ $shippers->firstItem() }} / {{ $shippers->lastItem() }} | Total: {{ $shippers->total() }}
                                    </div>
                                </div>
                                <div class="col-md-5 text-center pr-3">
                                    <div class="d-inline-block float-right">
                                        {{ $shippers->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" id="deleteItemAction" class="form-submit">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteItemText">Xóa nhân viên giao hàng</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0" id="deleteItemMessage">sau khi xóa nhân viên giao hàng bạn không thể khôi
                            phục nó.
                            Vẫn xóa?</span>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center col-12">
                            <button class="btn btn-secondary btn-sm " type="button" data-dismiss="modal">Hủy bỏ</button>
                            <button class="btn btn-danger btn-sm btn-submit" type="submit">Xóa</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('.btnDelete1').click(function(e) {
            $('#deleteItemAction').attr('action', $(this).attr('data-action'));
            $($(this).attr('data-target')).modal('show');
        })
    </script>
@endsection