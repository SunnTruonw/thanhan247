

@php
    $i++;
@endphp
@if ($limit>=$i)
<li class="">
    <a href="{{ $childs['slug_full'] }}"><span>{{ $childs['nameL'] }}</span>
        @isset($childs['childs'])
            @if (count($childs['childs'])>0&&$limit>=$i+1)
            {!! $icon_r??"" !!}
            @endif
        @endisset
    </a>
    @isset($childs['childs'])
        @if (count($childs['childs'])&&$limit>=$i+1)
            <ul class="nav-sub-c{{ $i }}">
                @foreach ($childs['childs'] as $childValue2)
                    @include('frontend.components.menu-child', ['childs' => $childValue2])
                @endforeach
            </ul>
        @endif
    @endisset
</li>
@endif


