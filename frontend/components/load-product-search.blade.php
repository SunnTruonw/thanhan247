@isset($data)
    @if ($data->count())
        <h2 class="count-search">Đã tìm thấy {{ $data->count() }} sản phẩm</h2>
    @else
    <h2 class="count-search">Không tìm thấy sản phẩm nào</h2>
    @endif
    <div class="list-product-card">
        <div class="row">
            @foreach($data as $product)
            <div class="col-md-4 col-product-card">
                <div class="product-card">
                    <div class="box">
                        <div class="image">
                            <a href="{{ $product->slug_full }}"><img src="{{ asset($product->avatar_path) }}" alt="{{ asset($product->name) }}"></a>
                            <span class="hot">New</span>
                            @if ($product->sale)
                            <span class="sale">-{{ $product->sale }}%</span>
                            @endif
                        </div>
                        <div class="content">
                            <h3 class="name"><a href="{{ $product->slug_full }}">{{$product->name}}</a></h3>
                            <div class="box-price">
                                <span class="new-price">{{ $product->price_after_sale?number_format($product->price_after_sale)." ".$unit :"Liên hệ" }}</span>
                                @if ($product->sale>0)
                                <span class="old-price">{{ number_format($product->price) }} {{ $unit  }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="action">
                            <ul>
                                <li class="a-cart"><a class="add-to-cart" data-url="{{ route('cart.add',['id' => $product->id,]) }}"><i class="fas fa-cart-plus"></i></a></li>
                                <li class="a-view"><a href="{{ $product->slug_full }}"><i class="fas fa-eye"></i></a></li>
                                <li class="a-view"><a class="add-compare" data-url="{{ route('compare.add',['id' => $product->id,]) }}">   <svg viewBox="-5 0 459 459.648" xmlns="http://www.w3.org/2000/svg"><path d="m416.324219 293.824219c0 26.507812-21.492188 48-48 48h-313.375l63.199219-63.199219-22.625-22.625-90.511719 90.511719c-6.246094 6.25-6.246094 16.375 0 22.625l90.511719 90.511719 22.625-22.625-63.199219-63.199219h313.375c44.160156-.054688 79.945312-35.839844 80-80v-64h-32zm0 0"></path><path d="m32.324219 165.824219c0-26.511719 21.488281-48 48-48h313.375l-63.199219 63.199219 22.625 22.625 90.511719-90.511719c6.246093-6.25 6.246093-16.375 0-22.625l-90.511719-90.511719-22.625 22.625 63.199219 63.199219h-313.375c-44.160157.050781-79.949219 35.839843-80 80v64h32zm0 0"></path></svg></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-12">
        @if (count($data))
        {{$data->appends(request()->all())->links()}}
        @endif
    </div>

@endisset
