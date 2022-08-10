@extends('admin.layouts.main')
@section('title',"danh sach rút điểm")

@section('css')
<link rel="stylesheet" href="{{asset('lib/sweetalert2/css/sweetalert2.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>" Rút điểm","key"=>"Danh sách rút điểm"])

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

                @if(session("numberUpdate"))
                <div class="alert alert-success">
                   {{session("numberUpdate")}}
                </div>
                @endif
                {{-- <a href="{{route('admin.user.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a> --}}
                <div class="d-flex justify-content-end">

                    <div class="group-button-right d-flex">
                        {{-- <form action="{{route('admin.pay.import.excel.database')}}" class="form-inline" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" style="max-width: 250px">
                                <input type="file" class="form-control-file" name="fileExcel" accept=".xlsx" required>
                              </div>
                            <input type="submit" value="Import Execel" class=" btn btn-info ml-1">
                        </form> --}}
                        <form class="form-inline ml-3" action="{{route('admin.pay.export.excel.database')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="">Ngày bắt đầu:</label>
                            <div class="d-inline-block">
                                <input type="date" class="form-control @error('start') is-invalid  @enderror" placeholder="" id="" name="start" value="{{ old('start')}}">
                                @error('start')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="">Ngày kết thúc:</label>
                            <div class="d-inline-block">

                                <input type="date" class="form-control @error('end') is-invalid  @enderror" placeholder="" id="" name="end" value="{{ old('end')}}">
                                @error('end')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="submit" value="Export Execel" class=" btn btn-danger">
                        </form>
                    </div>
                </div>
                <div class="card-header">
                    <div class="card-tools w-100 mb-3">
                        <form action="{{ route('admin.pay.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="form-group col-md-3 mb-0">
                                            <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="Từ khóa">
                                            <div id="keyword_feedback" class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                            <select id="order" name="order_with" class="form-control">
                                                <option value="">-- Sắp xếp theo --</option>
                                                <option value="dateASC" {{ $order_with=='dateASC'? 'selected':'' }}>Ngày tạo tăng dần</option>
                                                <option value="dateDESC" {{ $order_with=='dateDESC'? 'selected':'' }}>Ngày tạo giảm dần</option>
                                                <option value="statusASC" {{ $order_with=='statusASC'? 'selected':'' }}>Trạng thái</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                            <select id="" name="fill_action" class="form-control">
                                                <option value="">-- Lọc --</option>
                                                <option value="cancel" {{ $fill_action=='cancel'? 'selected':'' }}>Đã hủy</option>
                                                <option value="complate" {{ $fill_action=='complate'? 'selected':'' }}>Đã hoàn thành</option>
                                                <option value="handle" {{ $fill_action=='handle'? 'selected':'' }}>Chờ xử lý</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-1 mb-0">
                                    <button type="submit" class="btn btn-success w-100">Search</button>
                                </div>
                                <div class="col-md-1 mb-0">
                                    <a  class="btn btn-danger w-100" href="{{ route('admin.pay.index') }}">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                    <div class="count">
                        Tổng số bản ghi <strong>{{  $data->count() }}</strong> / {{ $totalPay }}
                     </div>
                  </div>



                <div class="card card-outline card-primary">
                    <form action="{{route('admin.pay.updateDrawPointAll')}}" method="GET" id="updateAll" name="updateAll">
                        @csrf
                        <div class="card-body table-responsive p-0 lb-list-category">
                            <table class="table table-head-fixed wrap-pay" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Username</th>
                                        <th>Điểm</th>
                                        <th>Trạng thái</th>
                                        <th>action</th>
                                        <th>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input checkallPay" value="">Chọn tất cả
                                                </label>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{$loop->index}}</td>
                                        <td>{{$item->user->name}}</td>
                                        <td>{{$item->point}}</td>
                                        <td class="content-type">{{$typePay[$item->status]['name']}}</td>
                                        <td>
                                            @if ($item->status==1)
                                            <div class="wrap-remove">
                                                <a  data-url="{{route('admin.pay.updateDrawPoint',['id'=>$item->id,'type'=>'complate'])}}" data-type="complate" class="btn btn-sm btn-success updateStatusDrawPoint">Hoàn thành</a>
                                                <a data-url="{{route('admin.pay.updateDrawPoint',['id'=>$item->id,'type'=>'error'])}}" data-type="error" class="btn btn-sm btn-danger updateStatusDrawPoint">Hủy bỏ</a>
                                            </div>
                                            @endif

                                        </td>
                                        <td>
                                            @if ($item->status==1)
                                            <div class="wrap-remove">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" name="id[]" class="form-check-input checkChildren" value="{{ $item->id }}">Chọn
                                                    </label>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                        <td class="content-type"></td>
                                        <td colspan="2">
                                            <div class="text-right">
                                                <input type="hidden" value="" name="type" class="hidden">
                                                <button type="submit" data-type="complate" class="btn btn-sm btn-success updateAll">Hoàn thành các mục đã chọn </button>
                                                <button type="submit" data-type="error" class="btn btn-sm btn-danger updateAll">Hủy bỏ các mục đã chọn </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
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
<script>
    $(function(){
        $(document).on('click','.updateStatusDrawPoint',function(){
            event.preventDefault();
            let urlRequest = $(this).data("url");
            let type = $(this).data("type");
            let title = '';
            let content=$(this).parents('tr').find('.content-type');
            let re=$(this).parents('tr').find('.wrap-remove');
            switch (type) {
                case 'complate':
                    title ='Bạn có chắc chắn muốn chuyển sang trạng thái rút điểm thành công'
                    break;
                case 'error':
                    title='Bạn có chắc chắn muốn chuyển sang trạng thái rút điểm thất bại và hoàn lại điểm';
                break;
                default:
                    break;
            }
            Swal.fire({
                title: title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, next step!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: urlRequest,
                        success: function(data) {
                            if (data.code == 200) {
                                let html = data.html;
                                content.text(html);
                                re.remove();
                            }
                        }
                    });
                }
            });
        });

        $('.checkallPay').on('click', function() {
            $(this).parents('.wrap-pay').find('.checkChildren').prop('checked', $(this).prop('checked'));
        });

        $(document).on('click','.updateAll',function(){
            event.preventDefault();
            let urlRequest = $(this).data("url");
            let type = $(this).data("type");
            $("input[name='type']").val(type);
            $("#updateAll").submit();
        });
    });
</script>
@endsection
