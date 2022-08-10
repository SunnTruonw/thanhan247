
@php
$i=1;
if (!isset($limit)) {
  $limit=99;
}

@endphp
  <ul class="menu-side-bar">
    @foreach ($data as $value)
        @php
        if(isset($categoryActive)){
            $active =collect($categoryActive);
        }else{
            $active=collect();
        }

            // $listIdChildren = $modelCategory->getALlCategoryChildrenAndSelf($value->id);
            // $listItem=$modelCategory->select(['id'])->whereIn('id',$listIdChildren)->get();

            // $listItemSlugFull = $listItem->map(function ($item, $key) {
            //     return $item->slug_full;
            // });
        //   dd($listItemSlugFull->contains($urlActive));
        @endphp
        <li class="nav_item @if(isset($active)&&$active->contains($value->id)) active @endif">
            <a href="{{ makeLink($type,$value->id,$value->slug) }}"><span>{{ $value->name }}</span>
                @if ($value->childs()->where('active',1)->count()&&$limit>=$i+1)
                <i class="fa fa-angle-right pt_icon_right"></i>
                @endif
            </a>

            @if ($value->childs->count()&&$limit>=$i+1)
                <ul class="menu-side-bar-leve-2" @if(isset($active)&&$active->contains($value->id)) style="display:block" @endif>
                    @foreach ($value->childs()->where('active',1)->orderby('order')->orderByDesc('created_at')->get() as $childValue)
                        @include('frontend.components.category-child', ['childs' => $childValue])
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>





