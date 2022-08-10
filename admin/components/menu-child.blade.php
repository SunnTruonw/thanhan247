
<li class="border pl-3">
    <div class="row">
        <div class="box-left" style="width:calc(100% - 110px );">
            <div class="row">
                <div class="col-sm-1 pt-2 pb-2">
                    {{$childValue->id}}
                </div>
                <div class="col-sm-4 pt-2 pb-2">
                    {{ $childValue->name }}
                </div>
                <div class="col-sm-4 pt-2 pb-2">
                    {{ $childValue->slug }}
                </div>
                <div class="col-sm-3">
                    @include('admin.components.breadcrumbs',['breadcrumbs'=>$childValue->breadcrumb])
                </div>
            </div>
        </div>
        <div class="pt-2 pb-2" style="width:110px;">
            <a href="{{route('admin.menu.getEdit',['id'=>$childValue->id])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
            <a data-url="{{route('admin.menu.getDelete',['id'=>$childValue->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
            @if ($childValue->childs->count())
            <button type="button" class="btn btn-sm btn-primary lb-toggle">
                <i class="fas fa-plus"></i>
            </button>
            @endif
        </div>
    </div>
    @if ($childValue->childs->count())
        <ul class="" style="display: none;">
            @foreach ($childValue->childs as $childValue2)
                @include('admin.components.menu-child', ['childValue' => $childValue2])
            @endforeach
        </ul>
    @endif
</li>

