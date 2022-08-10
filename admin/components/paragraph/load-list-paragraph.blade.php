
@php
$folder ="";
@endphp

<ul class="nav nav-tabs">
    @foreach ($configParagraph['type'] as $key=> $value)
    <li class="nav-item">
        <a class="nav-link {{$loop->first?'active':''}}" data-toggle="tab" href="#type_paragraph_{{$key}}">{{ $value }}</a>
    </li>
    @endforeach
</ul>

<div class="tab-content">
    @foreach ($configParagraph['type'] as $key=> $value)
    <div id="type_paragraph_{{$key}}" class="container tab-pane {{$loop->first?'active show':''}} fade">
        <div class="">
            <ul class="lb_list_category">
                <li class="border-bottom font-weight-bold  title-card-recusive">
                    <div class="d-flex">
                        <div class="box-left lb_list_content_recusive">
                            <div class="d-flex">
                                <div class="col-sm-10 pt-2 pb-2 name">
                                    Danh sách đoạn văn
                                </div>
                                <div class="col-sm-2 pt-2 pb-2 slug text-center">
                                    STT
                                </div>
                            </div>
                        </div>
                        <div class="pt-2 pb-2 lb_list_action_recusive">
                            Tác Vụ
                        </div>
                    </div>
                </li>


                @foreach ($data->paragraphs()->where('type',$key)->where('parent_id',0)->orderby('order')->orderByDesc('created_at')->get() as $paragraphItem)

                <li class="lb_item_recusive font-weight-bold  lb_item_delete  border-bottom">
                    <div class="d-flex">
                        <div class="box-left lb_list_content_recusive ">
                            <div class="d-flex">
                                <div class="col-sm-10 pt-2 pb-2 name">
                                    @if ($paragraphItem->childs->count())
                                        <i class="fas fa-folder"></i>
                                    @else
                                    <i class="fas fa-file-alt"></i>
                                    @endif
                                    {{ $paragraphItem->name }}
                                </div>
                                <div class="col-sm-2 pt-2 pb-2 slug text-center">
                                    {{ $paragraphItem->order }}
                                </div>
                            </div>
                        </div>

                        <div class="pt-1 pb-1 lb_list_action_recusive">
                            <a  class="btn btn-sm btn-danger lb_delete_recusive" data-url="{{ route($configParagraph['routeDelete'],['id'=>$paragraphItem->id]) }}"><i class="far fa-trash-alt"></i></a>
                            <a  class="btn btn-sm btn-info btnShowParagraph" data-url="{{ route($configParagraph['routeEdit'],['id'=>$paragraphItem->id]) }}"><i class="fas fa-edit"></i></a>
                            @if ($paragraphItem->childs->count())
                            <button type="button" class="btn btn-sm btn-primary lb-toggle">
                                <i class="fas fa-plus"></i>
                            </button>
                            @endif
                        </div>
                    </div>

                    @if ($paragraphItem->childs->count())
                        <ul class="font-weight-normal" style="display: none;">
                            @foreach ($paragraphItem->childs()->orderby('order')->orderByDesc('created_at')->get() as $childValue)
                                  @include('admin.components.paragraph.load-list-childs-paragraph', [
                                      'childs' => $childValue
                                  ])
                            @endforeach
                        </ul>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endforeach
</div>
