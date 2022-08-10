


@php
    $folder ="";
@endphp

<ul class="lb_list_category">
    <li class="border-bottom font-weight-bold  title-card-recusive">
        <div class="d-flex">
            <div class="box-left lb_list_content_recusive">
                <div class="d-flex">
                    <div class="col-sm-1 pt-2 pb-2 white-space-nowrap folder">
                        Folder
                    </div>
                    <div class="col-sm-3 pt-2 pb-2 name">
                        Tên danh mục
                    </div>
                    <div class="col-sm-3 pt-2 pb-2 slug">
                        Mô tả
                    </div>
                    <div class="col-sm-3 pt-2 pb-2 slug">
                       Key code
                    </div>
                    <div class="col-sm-3 pt-2 pb-2 parent">
                        Danh mục cha
                    </div>
                </div>
            </div>
            <div class="pt-2 pb-2 lb_list_action_recusive">
                Action
            </div>
        </div>
    </li>
    @foreach ($data as $value)
        <li class="lb_item_recusive font-weight-bold  lb_item_delete  border-bottom">
            <div class="d-flex">
                <div class="box-left lb_list_content_recusive ">
                    <div class="d-flex">
                        <div class="col-sm-1 pt-2 pb-2 white-space-nowrap folder">
                            {{-- {{$value->id}} --}}
                            @if ($value->childs->count())
                              <i class="fas fa-folder"></i>
                            @else
                            <i class="fas fa-file-alt"></i>
                            @endif
                        </div>
                        <div class="col-sm-3 pt-2 pb-2 name">
                            {{ $value->name }}
                        </div>
                        <div class="col-sm-3 pt-2 pb-2 slug">
                            {{ $value->description }}
                        </div>
                        <div class="col-sm-3 pt-2 pb-2 slug">
                            {{ $value->key_code }}
                        </div>
                        <div class="col-sm-2 pt-2 pb-2 parent">
                            {{-- {{ $value->parent->name }} --}}
                            Cha
                        </div>
                    </div>
                </div>

                <div class="pt-2 pb-2 lb_list_action_recusive">
                    <a href="{{route($routeNameEdit,['id'=>$value->id])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <a href="{{route($routeNameAdd,['parent_id'=>$value->id])}}" class="btn btn-sm btn-info">+ Thêm</a>
                    <a data-url="{{route($routeNameDelete,['id'=>$value->id])}}" class="btn btn-sm btn-danger lb_delete_recusive"><i class="far fa-trash-alt"></i></a>
                    @if ($value->childs->count())
                    <button type="button" class="btn btn-sm btn-primary lb-toggle">
                        <i class="fas fa-plus"></i>
                    </button>
                    @endif
                </div>
            </div>
            @if ($value->childs->count())
                <ul class="font-weight-normal" style="display: none;">
                    @foreach ($value->childs as $childValue)
                        @include('admin.components.permission-child', ['childs' => $childValue])
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>

