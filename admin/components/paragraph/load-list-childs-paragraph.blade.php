

@php
$folder .="<i class='fas fa-long-arrow-alt-right'></i>";
@endphp
<li class=" lb_item_delete  border-bottom">
    <div class="d-flex flex-wrap">
        <div class="box-left lb_list_content_recusive">
            <div class="d-flex">
                <div class="col-sm-10 pt-2 pb-2 name">
                    {!! $folder !!}
                    @if ($childValue->childs->count())
                            <i class="fas fa-folder"></i>
                    @else
                            <i class="fas fa-file-alt"></i>
                    @endif
                    {{ $childValue->name }}
                </div>
                <div class="col-sm-2 pt-2 pb-2 slug text-center">
                    {{ $childValue->order }}
                </div>
            </div>
        </div>
        <div class="pt-1 pb-1 lb_list_action_recusive" >
            <a  class="btn btn-sm btn-danger lb_delete_recusive" data-url="{{ route($configParagraph['routeDelete'],['id'=>$childValue->id]) }}"><i class="far fa-trash-alt"></i></a>
            <a  class="btn btn-sm btn-info btnShowParagraph" data-url="{{ route($configParagraph['routeEdit'],['id'=>$childValue->id]) }}"><i class="fas fa-edit"></i></a>
            @if ($childValue->childs->count())
                <button type="button" class="btn btn-sm btn-primary lb-toggle">
                    <i class="fas fa-plus"></i>
                </button>
            @endif
        </div>
    </div>
    @if ($childValue->childs->count())
        <ul class="" style="display: none;">
            @foreach ($childValue->childs()->orderby('order')->orderByDesc('created_at')->get() as $childValue2)
                @include('admin.components.paragraph.load-list-childs-paragraph', ['childValue' => $childValue2])
            @endforeach
        </ul>
    @endif

</li>

