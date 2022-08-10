@php
   $i=1;
   if (!isset($limit)) {
     $limit=99;
   }

@endphp


  {{-- <ul class="nav-main"> --}}
    @foreach ($data as $mega)

    <li class="nav-item nav-megamenu">
        <a class="nav-link" href="{{ $mega['slug_full'] }}"><span>{{ $mega['name'] }}</span>
            @isset($mega['childs'])
                @if (count($mega['childs']))
                {{-- <i class="fa fa-angle-down" aria-hidden="true"></i> --}}
                {!! $icon_d !!}
                @endif
            @endisset
        </a>
        @isset($mega['childs'])
            @if (count($mega['childs']))

            <div class="megamenu-container">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="list-megamenu">
                                @foreach ($mega['childs'] as $item)
                                <li class="megamenu-item">
                                    <div class="megamenu-title">
                                        <a href="{{ $item['slug_full'] }}"> {{ $item['name'] }}</a>
                                    </div>
                                    @isset($item['childs'])
                                        @if (count($item['childs']))
                                            <ul class="list-megamenu-sub">
                                                @foreach ($item['childs'] as $item2)
                                                <li class="megamenu-item-sub">
                                                    <a href="{{ $item2['slug_full'] }}">{{ $item2['name'] }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endisset

                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endisset
    </li>
    @endforeach



{{-- </ul> --}}





