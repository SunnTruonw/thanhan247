@extends('admin.layouts.main')
@section('title',"danh sach nhân viên")

@section('css')
<link rel="stylesheet" href="{{asset('lib/sweetalert2/css/sweetalert2.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>" Admin User","key"=>"Danh sách thành viên"])

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
                <a href="{{route('admin.user_frontend.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="card-tools w-100 mb-3">
                            <form action="{{ route('admin.user_frontend.historyPoint') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">

                                            <div class="form-group col-md-2 mb-0">
                                                <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="user/username">
                                                <div id="keyword_feedback" class="invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                                <select id="order" name="order_with" class="form-control">
                                                    <option value="">-- Sắp xếp theo --</option>
                                                    <option value="dateASC" {{ $order_with=='dateASC'? 'selected':'' }}>Ngày tạo tăng dần</option>
                                                    <option value="dateDESC" {{ $order_with=='dateDESC'? 'selected':'' }}>Ngày tạo giảm dần</option>
                                                    {{-- <option value="usernameASC" {{ $order_with=='usernameASC'? 'selected':'' }}>Username A-> Z</option>
                                                    <option value="usernameDESC" {{ $order_with=='usernameDESC'? 'selected':'' }}>Username Z -> A</option> --}}
                                                    {{-- <option value="activeDESC" {{ $order_with=='activeDESC'? 'selected':'' }}>Trạng thái</option> --}}
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Ngày start:</label>
                                                <div class="d-inline-block">
                                                    <input type="date" class="form-control @error('start') is-invalid  @enderror" placeholder="" id="" name="start" value="{{ $start }}">
                                                    @error('start')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <label for="">end:</label>
                                                <div class="d-inline-block">

                                                    <input type="date" class="form-control @error('end') is-invalid  @enderror" placeholder="" id="" name="end" value="{{$end}}">
                                                    @error('end')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                                <select id="" name="fill_action" class="form-control">
                                                    <option value="">-- Lọc --</option>
                                                    <option value="1" {{ $fill_action==1? 'selected':'' }}>Điểm nạp</option>
                                                    <option value="2" {{ $fill_action==2? 'selected':'' }}>Điểm sử dụng</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-1 mb-0">
                                        <button type="submit" class="btn btn-success w-100">Search</button>
                                    </div>
                                    <div class="col-md-1 mb-0">
                                        <a  class="btn btn-danger w-100" href="{{ route('admin.user_frontend.historyPoint') }}">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                        <div class="count">
                            Tổng số bản ghi <strong>{{  $data->count() }}</strong> / {{ $totalUser }}
                         </div>
                      </div> --}}

                    <div class="card card-outline card-primary">
                        <div class="card-header">Lịch sử thanh toán thành viên</div>
                        <div class="card-body table-responsive p-0 lb-list-category">
                            <table class="table table-head-fixed">
                                <thead>
                                    <tr>
                                      <th>Thời gian</th>
                                      <th>User</th>
                                      <th>Kiểu</th>
                                      <th>Admin nạp</th>
                                      <th>Số tiền đã thanh toán</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @isset($data)
                                        @if ($data->count()>0)
                                            @foreach ($data as $item)
                                            <tr>
                                                <td>{{ date_format($item->created_at,'d/m/Y H:i:s') }}</td>
                                                <td><a href="{{ route('admin.user_frontend.detail',['id'=>$item->user->id]) }}">{{ optional($item->user)->name }}</a></td>
                                                <td>{{ $typePoint[$item->type]['name'] }}</td>
                                                <td>{{ optional($item->admin)->name }}</td>
                                                <td>{{ $item->point }}</td>

                                            </tr>
                                            @endforeach
                                        @else
                                        <tr class="text-center"><td class="p-3" colspan="4">Chưa có </td></tr>
                                        @endif
                                    @endisset
                                  </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                {{$data->appends(request()->all())->links()}}
            </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade in" id="transactionDetail">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Thông tin chi tiết thành viên</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
         <div class="content" id="loadTransactionDetail">

         </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
        $(document).on('click','#btnTranferPoint',function(){
            event.preventDefault();
            let urlRequest = $(this).data("url");
            let title = '';
            title ='Bạn có chắc chắn muốn bắn điểm';
            $this=$(this);
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
                                $this.text('Đã bắn');
                                $this.removeClass('btn-danger').addClass('btn-info');
                            }else{
                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: 'Bắn điểm không thành công',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click','#btnKeyUser',function(){
            event.preventDefault();
            let urlRequest = $(this).data("url");
            let title = '';

            let   $this=$(this);
            if($this.hasClass('key')){
                title ='Bạn có chắc chắn muốn mở khóa thành viên';
            }else{
                title ='Bạn có chắc chắn muốn khóa thành viên';

            }

            let loadActive=$(this).parents('tr').find('.wrap-load-active');
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
                                loadActive.html(data.html);

                                if($this.hasClass('key')){
                                    $this.removeClass('key');
                                    $this.text('Khóa user');
                                }else{
                                    $this.addClass('key');
                                    $this.text('Mở khóa');
                                }
                            }else{
                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: data.title,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        },
                        error:function(data){

                            Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: "Khóa không thành công",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                        }
                    });
                }
            });
        });
    });
</script>

@endsection
