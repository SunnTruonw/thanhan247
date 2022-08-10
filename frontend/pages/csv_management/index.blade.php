@extends('frontend.layouts.main-profile')

@section('content')

    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="m-0 font-weight-bold">Tải file đơn hàng lên hệ thống</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center">
                    <form id="form_upload_file" action="{{ route('csv_management.import.csv.order') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                        <input name="csv_file" id="customFile" type="file" class="d-none custom-file-input">
                        <label class="btn btn-warning btn-icon-split btn-sm btn-upload-file" for="customFile">
                            <span class="icon text-white-50 tai-file">
                                <i class="fas fa-upload"></i>
                            </span>Tải file lên
                        </label>
                    </form>
    
                    <a href="{{ route('csv_management.download.csv.order') }}" class="btn btn-primary btn-icon-split btn-sm mt-3 btn-dowload-file">
                        <span class="icon text-white-50">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="text">Tải file danh sách đơn hàng mẫu</span>
                    </a>
                </div>

                {{-- <div class="card-body text-center">
                    <a href="#" class="btn btn-warning btn-icon-split btn-sm" data-toggle="modal" data-target="#uploadOrder">
                        <span class="icon text-white-50">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="text">Tải file lên</span>
                    </a>
                    <div class="modal fade" id="uploadOrder" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form action="{{ route('csv_management.import.csv.order') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tải file danh sách đơn hàng mẫu</h5>
                                        <button class="close" type="button" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12">
                                                <div class="text-center bg-light box-upload p-3">
                                                    <input name="csv_file" id="customFile" type="file"
                                                        class="d-none custom-file-input">
                                                    <label class="small mt-5">Mẫu CSV
                                                        <a class="text-primary"
                                                            href="{{ route('csv_management.download.csv.order') }}">tại
                                                            đây</a>
                                                            <a class="text-primary"
                                                            href="{{ route('admin.product.export.excel.database') }}">tại
                                                            đây</a>
                                                            
                                                    </label>
                                                    <label class="custom-file-label mycustom-file-label small"
                                                        for="customFile">Chọn tệp tin</label>
                                                    <div class="text-center" id="imageUploadList"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal-body -->
                                    <div class="modal-footer">
                                        <div class="text-center col-12">
                                            <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Hủy
                                                bỏ</button>
                                            <button class="btn btn-primary btn-sm">Tải lên</button>
                                        </div>
                                    </div>
                                    <!-- End modal footer -->
                                </form>
                            </div>
                            <!-- end modal-content -->
                        </div>
                    </div>
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm mt-3" data-toggle="modal"
                        data-target="#uploadProduct">
                        <span class="icon text-white-50">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="text">Tải lên csv sản phẩm</span>
                    </a>
                    <div class="modal fade" id="uploadProduct" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form action="{{ route('csv_management.import.csv.product') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tải lên CSV sản phẩm thuộc đơn
                                            hàng </h5>
                                        <button class="close" type="button" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12">
                                                <div class="text-center bg-light box-upload p-3">
                                                    <input name="csv_product_file" id="customFileProduct" type="file"
                                                        class="d-none custom-file-input">
                                                    <label class="small mt-5">Mẫu CSV
                                                        <a class="text-primary"
                                                            href="{{ route('csv_management.download.csv.product') }}">tại
                                                            đây</a>
                                                    </label>
                                                    <label class="custom-file-label mycustom-file-name small"
                                                        for="customFileProduct">Chọn tệp tin</label>
                                                    <div class="text-center" id="imageUploadList"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal-body -->
                                    <div class="modal-footer">
                                        <div class="text-center col-12">
                                            <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Hủy
                                                bỏ</button>
                                            <button class="btn btn-primary btn-sm">Tải lên</button>
                                        </div>
                                    </div>
                                    <!-- End modal footer -->
                                </form>
                            </div>
                            <!-- end modal-content -->
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="col-md-8">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="m-0 font-weight-bold text-primary">Quản lý csv</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Số thứ tự</th>
                                    <th class="text-nowrap">Tên file</th>
                                    <th class="text-nowrap">Tình trạng</th>
                                    <th class="text-nowrap">Ngày tạo</th>
                                    <th class="text-nowrap">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($csvOrders as $key =>  $order)
                                {{-- @if(Auth::id() === $order->user_id) --}}
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td><a href="{{ asset($order->file_name) }}" target="_blank" rel="noopener noreferrer">Xem</a></td>
                                        <td class="text-nowrap">
                                            @include('admin.components.status-2',[
                                                'dataStatus' => $order,
                                                'listStatus'=>$listStatus,
                                            ])
                                         </td>                                        <td>{{ date_format($order->created_at, 'd/m/y H:i') }}</td>
                                        <td style="text-align: center">
                                            <a data-url="{{route('csv_management.delete.csv.product',['id'=>$order->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    {{-- @endif --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-7 mt-3">
                            <div id="dataTable_info" role="status" aria-live="polite" class="dataTables_info">
                                Show：{{ $csvOrders->firstItem() }} / {{ $csvOrders->lastItem() }} | Total:
                                {{ $csvOrders->total() }}
                            </div>
                        </div>
                        <div class="col-md-5 text-center">
                            <div class="d-inline-block float-right">
                                {{ $csvOrders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#customFile').change(function() {
            file = $(this)[0].files[0];
            fileName = file.name;
            fileSize = file.size;
            $('.mycustom-file-label').html(`${fileName}`);
            $('#form_upload_file').submit();
        });
        $('#customFileProduct').change(function(e) {
            try {
                file = $(this)[0].files[0];
                fileName = file.name;
                fileSize = file.size;
                $('.mycustom-file-name').html(`${fileName}`);
            } catch (e) {

            }
        })
    </script>

<script>
    $(document).on("click", ".lb_delete", actionDelete);

    function actionDelete(event) {

        event.preventDefault();
        let urlRequest = $(this).data("url");
        let mythis = $(this);
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa',
            text: "Bạn sẽ không thể khôi phục điều này",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {

                            mythis.parents("tr").remove();
                        }
                    },
                    error: function() {

                    }
                });
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
            }
        })
    }
</script>


@endsection

