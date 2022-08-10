@extends('admin.layouts.main')
@section('title',"Danh sách thông tin liên hệ")
@section('css')
<style>
ul{
    padding-left: 0px;
}
table{
    font-size: 13px;
}
</style>
@endsection
@section('content')
   <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>"Liên hệ","key"=>"Danh sách"])
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                   <div class="col-sm-12">
                        <div class="list-count">
                            <div class="row">
                                @foreach ($dataContactGroupByStatus as $item)

                                @if ($item['status']!=-1)
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-calculator"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Số liên hệ {{ $item['name'] }} </span>
                                            <span class="info-box-number"><strong>{{ number_format($item['total']??0) }}</strong> / tổng số {{ $totalContact }}</span>
                                        </div>
                                        </div>
                                    </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                   </div>
                    <div class="col-sm-12">
                        <div class="card card-outline card-primary">
                           <div class="card-header">
                              <h3 class="card-title">Danh sách liên hệ</h3>
                              <div class="card-tools w-60">
                                  <form action="{{ route('admin.contact.index') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-0">
                                                    <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="Từ khóa">
                                                    <div id="keyword_feedback" class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group col-md-4 mb-0" style="min-width:100px;">
                                                    <select id="order" name="order_with" class="form-control">
                                                        <option value="">Sắp xếp theo</option>
                                                        <option value="dateASC" {{ $order_with=='dateASC'? 'selected':'' }}>Ngày gửi tăng dần</option>
                                                        <option value="dateDESC" {{ $order_with=='dateDESC'? 'selected':'' }}>Ngày gửi giảm dần</option>
                                                        <option value="statusASC" {{ $order_with=='statusASC'? 'selected':'' }}>Trạng thái 1-n</option>
                                                        <option value="statusDESC" {{ $order_with=='statusDESC'? 'selected':'' }}>Trạng thái n-1</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 mb-0" style="min-width:100px;">
                                                    <select id="status" name="status" class="form-control">
                                                        <option value="">Tình trang </option>
                                                        @foreach ($listStatus as $status)
                                                        <option value="{{ $status['status'] }}" {{ $status['status']==$statusCurrent? 'selected':'' }}> {{ $status['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <button type="submit" class="btn btn-success">Tìm kiếm</button>
                                            <a href="{{ route('admin.contact.index') }}" class="btn btn-danger">Làm lại</a>
                                        </div>

                                    </div>
                                </form>

                              </div>
                           </div>
                           <!-- /.card-header -->
                           <div class="card-body table-responsive p-0">
                              <table class="table table-head-fixed">
                                 <thead>
                                    <tr>
                                       <th style="background: #eee;">ID</th>
                                       <th class="text-nowrap" style="background: #eee;">Thông tin</th>
                                       <th class="text-nowrap" style="background: #eee;">Tài khoản</th>
                                       <th class="text-nowrap" style="background: #eee;">Trạng thái</th>
                                       <th class="text-nowrap" style="background: #eee;">Mô tả</th>
                                       <th class="text-nowrap" style="background: #eee;">Nội dung</th>
                                       <th class="text-nowrap" style="background: #eee;">Thời gian</th>
                                       <th class="text-nowrap" style="background: #eee;">Tình trạng</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($data as $contact)
                                     <tr>
                                         <td>{{ $contact->id }}</td>
                                         <td>
                                             <ul>
                                                 <li>
                                                   <strong>Name:</strong>  {{ $contact->name }}
                                                 </li>
                                                 <li>
                                                    <strong>Email:</strong>   {{ $contact->email }}
                                                 </li>
                                                 <li>
                                                  <strong>Phone:</strong>   {{ $contact->phone }}
                                                 </li>
                                                 <li>
                                                  <strong>Chuyên mục:</strong>   {{ $contact->chuyen_muc }}
                                                 </li>
                                                 <li>
                                                  <strong>Tiêu đề:</strong>   {{ $contact->title }}
                                                 </li>

                                             </ul>
                                         </td>
                                         <td class="text-nowrap">{{ $contact->user_id?'Thành viên':'Khách vãng lai' }}</td>
                                         <td class="text-nowrap status-2" data-url="{{ route('admin.contact.loadNextStepStatus',['id'=>$contact->id]) }}">
                                            @include('admin.components.status-2',[
                                                'dataStatus' => $contact,
                                                'listStatus'=>$listStatus,
                                            ])
                                         </td>
                                         <td class="text-nowrap"> {!! $contact->description !!} </td>
                                         <td class="text-nowrap"> {!! $contact->content !!} </td>
                                         <td class="text-nowrap"> {{ date_format($contact->created_at,"d/m/Y") }} </td>
                                         <td>
                                             <a  class="btn btn-sm btn-info" id="btn-load-transaction-detail" data-url="{{route('admin.contact.detail',['id'=>$contact->id])}}" ><i class="fas fa-eye"></i></a>
                                             <a href="" data-url="{{route('admin.contact.destroy',['id'=>$contact->id])}}"  class="btn btn-sm btn-info btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                         </td>
                                      </tr>
                                     @endforeach

                                 </tbody>
                              </table>
                           </div>
                           <!-- /.card-body -->

                           <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                            <div class="count">
                                Tổng số bản ghi <strong>{{  $data->count() }}</strong> / {{ $totalContact }}
                             </div>
                          </div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        {{$data->appends(request()->input())->links()}}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
     <!-- The Modal chi tiết đơn hàng -->
  <div class="modal fade in" id="transactionDetail">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Thông tin liên hệ</h4>
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

@endsection
