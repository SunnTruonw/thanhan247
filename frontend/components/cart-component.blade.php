
@php
    $unit="đ";
@endphp
<div class="cart-wrapper">
    <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>{{ __('home.anh') }}</th>
            <th>{{ __('home.ten_sp') }}</th>
            <th>{{ __('home.so_luong') }}</th>
            <th>{{ __('home.gia') }}</th>
            <th>{{ __('home.xoa') }}</th>
          </tr>
        </thead>
        <tbody>
            @foreach($data as $cartItem)
            <tr class="cart-item">
                <td class="cart-image" data-title="{{ __('home.anh') }}:">
                   <div class="image">
                    <img src="{{ $cartItem['avatar_path'] }}" alt="{{ $cartItem['name'] }}" >
                    @if ($cartItem['sale'])
                    <span class="badge badge-pill badge-danger position-absolute sale-cart">{{ $cartItem['sale']}}%</span>
                    @endif

                   </div>
                </td>
                <td class="cart-name" data-title="{{ __('home.ten_sp') }}:"><span>{{ $cartItem['name'] }}</span></td>
                <td class="cart-quantity" data-title="{{ __('home.so_luong') }}:">
                    <div class="quantity-cart">
                        <div class="box-quantity text-center">
                            <span class="prev-cart">-</span>
                            <input class="number-cart" data-url="{{ route('cart.update',[
                                'id'=> $cartItem['id']
                                ]) }}" value="{{ $cartItem['quantity']}}" type="number" id="" name="quantity" disabled="disabled">
                            <span class="next-cart">+</span>
                        </div>
                    </div>
                </td>
                <td class="cart-price" data-title="{{ __('home.gia') }}:">
                    <div class="box-price">
                        <span class="new-price-cart">{{ number_format($cartItem['totalPriceOneItem']) }} {{ $unit }}</span>
                        @if ($cartItem['sale'])
                        <span class="old-price-cart">{{ number_format($cartItem['totalOldPriceOneItem']) }}  {{ $unit }}</span>
                        @endif
                    </div>
                </td>
                <td class="cart-action" data-title="{{ __('home.xoa') }}:">
                    <a data-url="{{ route('cart.remove',[
                        'id'=> $cartItem['id']
                        ]) }}" class="remove-cart"><i class="fas fa-times-circle"></i></a>
                </td>
            </tr>
            @endforeach
            <tr>
              <td colspan="5">
                <div class="d-flex justify-content-end align-item-center pt-1 pb-1">
                    <a data-url="{{ route('cart.clear') }}" class="clear-cart btn btn-danger">{{ __('home.xoa_tat_ca') }}</a>
                </div>
              </td>
            </tr>
        </tbody>
        <tfoot>
            <tr style="border: unset;">
                <td colspan="5" style="border: unset;">
                    <div class="wrap-area">
                        <a href="{{ route('home.index') }}" class="buy-more btn btn-light">{{ __('home.tiep_tuc_muc_hang') }}</a>
                        <div class="area-total">
                            <div class="total d-flex align-items-center justify-content-between">
                                <span class="name">{{ __('home.tong_tien') }}:</span>
                                <span class="total-price">{{ number_format($totalPrice) }} {{ $unit }}</span>
                            </div>
                            @isset($totalOldPrice)
                            @if ($totalPrice!=$totalOldPrice)
                            <div class="total-provisional d-flex align-item-center justify-content-end">
                                <span class="total-provisional-price">{{ number_format($totalOldPrice )}} {{ $unit }}</span>
                            </div>
                            @endif
                            @endisset
                            <div class="total-provisional d-flex align-item-center justify-content-end">
                                <span class="name">{{ __('home.tong') }} <strong>{{ $totalQuantity }}</strong> {{ __('home.san_pham') }}</span>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>


</div>
