@extends('admin.layouts.main')
@section('title',"Danh sach chương trình")
@section('css')
@endsection
@section('content')
<div class="content-wrapper lb_template_list_post">

    @include('admin.partials.content-header',['name'=>"Chương trình","key"=>"Danh sách chương trình"])

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

                <div class="d-flex justify-content-between ">
                    <a href="{{route('admin.program.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                </div>

                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="card-tools w-100 mb-3">
                            <form action="{{ route('admin.program.index') }}" method="GET">
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
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                <select id="" name="fill_action" class="form-control">
                                                    <option value="">-- Lọc --</option>
                                                    <option value="hot" {{ $fill_action=='hot'? 'selected':'' }}> Nổi bật</option>
                                                    <option value="noHot" {{ $fill_action=='noHot'? 'selected':'' }}>Không nổi bật</option>
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
                                        <button type="submit" class="btn btn-success w-100">Tìm kiếm</button>
                                    </div>
                                    <div class="col-md-1 mb-0">
                                        <a  class="btn btn-danger w-100" href="{{ route('admin.program.index') }}">Làm lại</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0 lb-list-category">
                        <table class="table table-head-fixed" style="font-size:13px;">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>STT</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th class="white-space-nowrap">Giới thiệu</th>
                                        {{--<th class="white-space-nowrap">Số lượt xem</th>--}}
                                        <th class="white-space-nowrap">Avatar</th>
                                        <th class="white-space-nowrap">Active</th>
                                        <th class="white-space-nowrap">Nổi bật</th>
                                        <th class="white-space-nowrap">Danh mục</th>
                                        <th class="white-space-nowrap">Action</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $programItem)
                                <tr>
                                    <td>{{$loop->index}}</td>
                                    <td>{{$programItem->id}}</td>
                                    <td>{{$programItem->name}}</td>
                                    <td>{{$programItem->description}}</td>
                                    {{--<td>{{$programItem->view}}</td>--}}
                                    <td><img src="{{asset($programItem->avatar_path)}}" alt="{{$programItem->name}}" style="width:80px;"></td>
                                    <td class="wrap-load-active" data-url="{{ route('admin.program.load.active',['id'=>$programItem->id]) }}">
                                       @include('admin.components.load-change-active',['data'=>$programItem,'type'=>'bài viết'])
                                    </td>
                                    <td class="wrap-load-hot" data-url="{{ route('admin.program.load.hot',['id'=>$programItem->id]) }}">
                                        @include('admin.components.load-change-hot',['data'=>$programItem,'type'=>'bài viết'])
                                     </td>
                                    <td>{{optional($programItem->category)->name}}</td>
                                    {{--
                                    <td>{{$programItem->created_at}}</td>
                                    <td>{{$programItem->updated_at}}</td> --}}
                                    <td class="white-space-nowrap">
                                        {{-- href="{{route('admin.program.destroy',['id'=>$programItem->id])}}" --}}
                                        <a href="{{route('admin.program.edit',['id'=>$programItem->id])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                        <a data-url="{{route('admin.program.destroy',['id'=>$programItem->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                {{$data->appends(request()->input())->links()}}
            </div>
        </div>
      </div>
    </div>
</div>

@endsection

@section('js')

@endsection
