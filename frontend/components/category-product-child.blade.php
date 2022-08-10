
@php
     $listIdChildren = $modelCategory->getALlCategoryChildrenAndSelf($childs->id);
        $listItem=$modelCategory->select(['id'])->whereIn('id',$listIdChildren)->get();
        $listItemSlugFull = $listItem->map(function ($item, $key) {
            return $item->slug_full;
    });
@endphp

<li class="@if($listItemSlugFull->contains($urlActive)) active @endif">
    <a href="{{ makeLink($type,$childs->id,$childs->slug) }}"><span>{{ $childs->name }} ({{ $childs->count_product }})</span>
        @if ($childs->childs->count())
        <i class="fa fa-angle-right pt_icon_right"></i>
        @endif
    </a>

    @if ($childs->childs->count())
        <ul class="" @if($listItemSlugFull->contains($urlActive)) style="display:block" @endif>
            @foreach ($childs->setAppends(['count_product'])->childs()->orderby('order')->orderByDesc('created_at')->get() as $childValue2)
                @include('frontend.components.category-child', ['childs' => $childValue2])
            @endforeach
        </ul>
    @endif
</li>

