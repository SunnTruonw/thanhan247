@php
    $folder ="";
@endphp

<ul class="lb_list_category">
    <li class="border-bottom font-weight-bold  title-card-recusive">
        <div class="d-flex">
            <div class="box-left lb_list_content_recusive">
                <div class="d-flex">
                    <div class="col-sm-1 pt-2 pb-2 white-space-nowrap folder">
                        #
                    </div>
                    <div class="col-sm-6 pt-2 pb-2 name">
                        Tên danh mục
                    </div>
                    <div class="col-sm-2 pt-2 pb-2 slug text-center">
                        Thứ tự
                    </div>
                    <div class="col-sm-3 pt-2 pb-2 parent text-center">
                        Trạng thái
                    </div>
                </div>
            </div>
            <div class="pt-2 pb-2 lb_list_action_recusive">
                Tác Vụ
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
                            @if (count($value['child'])>0)
                              <i class="fas fa-folder"></i>
                            @else
                            <i class="fas fa-file-alt"></i>
                            @endif
                        </div>
                        <div class="col-sm-6 pt-2 pb-2 name">
                            <a href="{{ route(Route::currentRouteName(),['parent_id'=>$value['id']]) }}">{{ $value['nameL'] }}</a>

                        </div>
                        <div class="col-sm-2 pt-2 pb-2 slug text-center">
                            <input data-url="@if (isset($routeNameOrder)) {{ route($routeNameOrder,['table'=>$table,'id'=>$value['id']]) }} @endif" class="lb-order text-center"  type="number" min="0" value="{{ $value['order']?$value['order']:0 }}" style="width:50px" />
                        </div>
                        <div class="col-sm-3 pt-2 pb-2 parent text-center">
                            {{-- {{ $value->parent->name }} --}}

                            <a  data-url="" class="loadActiveCategory text-center {{ $value['active']==0?"red":"" }}">
                                {!!   $value['active']==1?"<i class='fas fa-check-circle'></i>":"<i class='fas fa-times-circle'></i>" !!}
                            </a>
                            @if (isset($value['hot'])&&($value['hot']===0||$value['hot']===1))
                                @if ($value['hot']===1)
                                <div class="w-100 text-center mt-2">
                                    <a  class="btn btn-success"> Nổi bật</a>
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-1 pb-1 lb_list_action_recusive">
                    <a href="{{route($routeNameEdit,['id'=>$value['id']])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <a href="{{route($routeNameAdd,['parent_id'=>$value['id']])}}" class="btn btn-sm btn-info">+ Thêm</a>
                    <a data-url="{{route($routeNameDelete,['id'=>$value['id']])}}" class="btn btn-sm btn-danger lb_delete_recusive"><i class="far fa-trash-alt"></i></a>
                    @if (isset($routeNameModelChild)&&$routeNameModelChild)
                    <a href="{{route($routeNameModelChild,['category'=>$value['id']])}}" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> {{ $modelChildName }}</a>
                    @endif
                    @if (count($value['child']))
                    <button type="button" class="btn btn-sm btn-primary lb-toggle">
                        <i class="fas fa-plus"></i>
                    </button>
                    @endif
                </div>
            </div>
            @if (count($value['child']))
                <ul class="font-weight-normal" style="display: none;">
                    @foreach ($value['child'] as $childValue)
                        @include('admin.components.category-child', ['childs' => $childValue])
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
