<div class="text-left wrap-breadcrumbs">

        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                        <ul class="breadcrumb">
                            <li class="breadcrumbs-item">
                                <a href="{{ makeLink('home') }}">{{ __('home.home') }}</a>
                            </li>
                           
                            @foreach ($breadcrumbs as $item)
                            @if ($loop->last)
                            <li class="breadcrumbs-item active"><a href="{{ optional($item)->slug_full }}" class="currentcat">{{ optional($item)->nameL }}</a></li>
                            @else
                            <li class="breadcrumbs-item"><a href="{{ optional($item)->slug_full }}" class="currentcat">{{  optional($item)->nameL  }}</a></li>
                            @endif
                            @endforeach
                        </ul>
                </div>
            </div>
        </div>
</div>
