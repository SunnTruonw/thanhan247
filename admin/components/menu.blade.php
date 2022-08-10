

<ul class="pl-0">
    <li class="border-top font-weight-bold pl-3">
        <div class="row">
            <div class="box-left" style="width:calc(100% - 110px);">
                <div class="row">
                    <div class="col-sm-1 pt-2 pb-2">
                        ID
                    </div>
                    <div class="col-sm-4 pt-2 pb-2">
                        Tên danh mục
                    </div>
                    <div class="col-sm-4 pt-2 pb-2">
                        Đường dẫn
                    </div>
                    <div class="col-sm-3 pt-2 pb-2">
                        Danh mục cha
                    </div>
                </div>
            </div>
            <div class="pt-2 pb-2" style="width:110px;">
                Action
            </div>
        </div>
    </li>
    @foreach ($data as $value)
        <li class="border-top border-success font-weight-bold pl-3 ">
            <div class="row">
                <div class="box-left" style="width:calc(100% - 110px);">
                    <div class="row">
                        <div class="col-sm-1 pt-2 pb-2">
                            {{$value->id}}
                        </div>
                        <div class="col-sm-4 pt-2 pb-2">
                            {{ $value->name }}
                        </div>
                        <div class="col-sm-4 pt-2 pb-2">
                            {{ $value->slug }}
                        </div>
                        <div class="col-sm-3 pt-2 pb-2">
                            {{-- {{ $value->parent->name }} --}}
                            Cha
                        </div>
                    </div>
                </div>

                <div class="pt-2 pb-2" style="width:110px;">
                    <a href="{{route('admin.menu.getEdit',['id'=>$value->id])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <a data-url="{{route('admin.menu.getDelete',['id'=>$value->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                    @if ($value->childs->count())
                        <button type="button" class="btn btn-sm btn-primary lb-toggle">
                            <i class="fas fa-plus"></i>
                        </button>
                    @endif
                </div>
            </div>
            @if ($value->childs->count())
                <ul class="border font-weight-normal" style="display: none;">
                    @foreach ($value->childs as $childValue)
                        @include('admin.components.menu-child', ['childs' => $childValue])
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
