
  <ul class="menu-side-bar">


    @foreach ($data as $value)


        @php

            $listIdChildren = $modelCategory->getALlCategoryChildrenAndSelf($value->id);
            $listItem=$modelCategory->select(['id'])->whereIn('id',$listIdChildren)->get();

            $listItemSlugFull = $listItem->map(function ($item, $key) {
                return $item->slug_full;
            });
         //   dd($listItemSlugFull->contains($urlActive));
        @endphp
        <li class="nav_item @if($listItemSlugFull->contains($urlActive)) active @endif">
            <a href="{{ makeLink($type,$value->id,$value->slug) }}"><span>{{ $value->name }} ({{ $value->count_product }})</span>
                @if ($value->childs->count())
                <i class="fa fa-angle-right pt_icon_right"></i>
                @endif
            </a>
            @if ($value->childs->count())
                <ul class="menu-side-bar-leve-2" @if($listItemSlugFull->contains($urlActive)) style="display:block" @endif>
                    @foreach ($value->setAppends(['count_product'])->childs()->orderby('order')->orderByDesc('created_at')->get() as $childValue)
                        @include('frontend.components.category-product-child', ['childs' => $childValue])
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>





