@extends('admin.layouts.main')
@section('title',"Danh sánh about")
@section('css')
@endsection

@section('content')
<div class="content-wrapper lb_template_list_about">

    @include('admin.partials.content-header',['name'=>"About","key"=>"Danh sách about"])

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
                <a href="{{route('admin.about.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                 <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="card-tools w-100 mb-3">
                            <form action="{{ route('admin.about.index') }}" method="GET" style="font-size: 13px;">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">

                                            <div class="form-group col-md-3 mb-0">
                                                <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="admin/email">
                                                <div id="keyword_feedback" class="invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-0" style="min-width:100px;">
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
                                                <label for="">Ngày cấp start:</label>
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

                                            {{-- <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                                <select id="" name="fill_action" class="form-control">
                                                    <option value="">-- Lọc --</option>
                                                    <option value="1" {{ $fill_action==1? 'selected':'' }}>Điểm nạp</option>
                                                    <option value="2" {{ $fill_action==2? 'selected':'' }}>Điểm sử dụng</option>
                                                </select>
                                            </div> --}}

                                        </div>
                                    </div>
                                    <div class="col-md-1 mb-0">
                                        <button type="submit" class="btn btn-success w-100">Search</button>
                                    </div>
                                    <div class="col-md-1 mb-0">
                                        <a  class="btn btn-danger w-100" href="{{ route('admin.about.index') }}">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0 lb-list-category">
                        <table class="table table-head-fixed" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Người được cấp</th>
                                    <th>Admin cấp</th>
                                    <th>Name</th>
                                    {{-- <th class="white-space-nowrap ">Mô tả</th> --}}
                                    <th>Điểm đến</th>
                                    <th>Ngày cấp</th>
                                    <th style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($data as $aboutItem)
                                <tr>
                                    <td>{{$loop->index}}</td>
                                    <td>{{optional($aboutItem->admin)->name}}</td>
                                    <td>{{optional($aboutItem->adminCreate)->name}}</td>
                                    <td>{{$aboutItem->name}}</td>
                                    {{-- <td class="w-50">{!! $aboutItem->description !!}</td> --}}
                                    <td>{{$aboutItem->to}}</td>
                                    <td>{{$aboutItem->created_date}}</td>
                                    <td>
                                        <a href="{{route('admin.about.edit',['id'=>$aboutItem->id])}}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                        <a data-url="{{route('admin.about.destroy',['id'=>$aboutItem->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
@endsection

@section('js')
@endsection
