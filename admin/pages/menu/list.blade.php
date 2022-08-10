@extends('admin.layouts.main')
@section('title',"Danh sach menu")

@section('css')

@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Menu","key"=>"Danh sách menu"])

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
                <div class="text-right">
                    <a href="{{route('admin.menu.create',['parent_id'=>request()->parent_id??0])}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                </div>
                <div class="card card-outline card-info">
                    <div class="card-header pt-2 pb-2">
                        <div class="cart-title">
                            <i class="fas fa-list"></i> Menu
                        </div>
                    </div>
                </div>
                @if (isset($parentBr)&&$parentBr)
                <ol class="breadcrumb">
                  <li><a href="{{ route('admin.menu.index',['parent_id'=>0]) }}">Root</a></li>

                  @foreach ($parentBr->breadcrumb as $item)
                   <li><a href="{{ route('admin.menu.index',['parent_id'=>$item['id']]) }}">{{ $item['name'] }}</a></li>
                  @endforeach
                  <li><a href="{{ route('admin.menu.index',['parent_id'=>$parentBr->id]) }}">{{ $parentBr->name }}</a></li>
                </ol>
                @endif
                    <div class="card card-outline card-primary">
                        <div class="card-body table-responsive lb-list-category">
                            @include('admin.components.category', [
                                'data' => $data,
                                'routeNameEdit'=>'admin.menu.edit',
                                'routeNameAdd'=>'admin.menu.create',
                                'routeNameDelete'=>'admin.menu.destroy',
                                'routeNameOrder'=>'admin.loadOrderVeryModel',
                                 'table'=>'menus',
                            ])
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
