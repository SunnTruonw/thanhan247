@php
    $i++;
@endphp
<li class="@if(isset($active)&&$active->contains($childs->id)) active @endif">
    <a href="{{ makeLink($type,$childs->id,$childs->slug) }}"><span>{{ $childs->name }}</span>
        @if ($childs->childs()->where('active',1)->count()&&$limit>=$i+1)
        <i class="fa fa-angle-right pt_icon_right"></i>
        @endif
    </a>

    @if ($childs->childs->count()&&$limit>=$i+1)
        <ul class="" @if(isset($active)&&$active->contains($childs->id)) style="display:block" @endif>
            @foreach ($childs->childs()->where('active',1)->orderby('order')->orderByDesc('created_at')->get() as $childValue2)
                @include('frontend.components.category-child', ['childs' => $childValue2])
            @endforeach
        </ul>
    @endif
</li>

