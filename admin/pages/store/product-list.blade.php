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
                        <div class="card-header">
                            <div class="card-tools w-100 mb-3">
                                <form action="{{ route('admin.store.productList') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
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
                                                        <option value="viewASC" {{ $order_with=='viewASC'? 'selected':'' }}>Lượt xem tăng dần</option>
                                                        <option value="viewDESC" {{ $order_with=='viewDESC'? 'selected':'' }}>Lượt xem giảm dần</option>
                                                        <option value="priceASC" {{ $order_with=='priceASC'? 'selected':'' }}>Giá tăng dần</option>
                                                        <option value="priceDESC" {{ $order_with=='priceDESC'? 'selected':'' }}>Giá giảm dần</option>
                                                        <option value="payASC" {{ $order_with=='payASC'? 'selected':'' }}>Số lượt mua tăng dần</option>
                                                        <option value="payDESC" {{ $order_with=='payDESC'? 'selected':'' }}>Số lượt mua giảm dần</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                    <select id="" name="fill_action" class="form-control">
                                                        <option value="">-- Lọc --</option>
                                                        <option value="hot" {{ $fill_action=='hot'? 'selected':'' }}>Sản phẩm hot</option>
                                                        <option value="no_hot" {{ $fill_action=='no_hot'? 'selected':'' }}>Sản phẩm không hot</option>
                                                        <option value="active" {{ $fill_action=='active'? 'selected':'' }}>Sản phẩm hiển thị</option>
                                                        <option value="no_active" {{ $fill_action=='no_active'? 'selected':'' }}>Sản phẩm bị ẩn</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                    <select id="categoryProduct" name="category" class="form-control">
                                                        <option value="">-- Tất cả danh mục --</option>
                                                        {{-- <option value="-1" {{ $status==0? 'selected':'' }}>Đơn hàng đã hủy</option> --}}
                                                        {!!$option!!}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-1 mb-0">
                                            <button type="submit" class="btn btn-success w-100">Search</button>
                                        </div>
                                        <div class="col-md-1 mb-0">
                                            <a  class="btn btn-danger w-100" href="{{ route('admin.product.index') }}">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0 lb-list-category">
                            <table class="table table-head-fixed" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->index }}</td>
                                            <td>{{ $item->masp }}</td>
                                            <td>{{ $item->name}}</td>

                                            <td>
                                             {{$item->stores()->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total  }}

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
