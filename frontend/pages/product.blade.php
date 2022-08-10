@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
@section('content')
    <div class="content-wrapper">
        <div class="main">
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset
            <div class="wrap_home">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="main_left">
                                @if (isset($data) && $data)
								<table id="customers">
								    <tr>
    									<th class="stt_pc">{{ __('product-by-category.stt') }}</th>
    									<th>{{ $category->name }}</th>
    									<th class="file_pc">{{ __('product-by-category.tai_file') }}</th>
								    </tr>
                                    @guest
    									@foreach ($data as $product)
                                            @php
                                                $Link = $product->slug_full;
                                                $productTran = $product->translationsLanguage()->first();
                                            @endphp
        								    <tr>
            									<td class="text-center">{{ $loop->index+1 }}</td>
            									<td>{{ $productTran->name }}</td>
            									<td>
                                                    <a href="{{ route('login') }}" target="blank" class="file_download"><img src="{{ asset('frontend/images/taifile.png') }}"  alt="taifile"> <span>{{ number_format( $product->price) }} {{ __('product-by-category.diem') }}</span></a>
                                                </td>
            								  </tr>
    								    @endforeach
                                    @else
                                        @foreach ($data as $product)
                                            @php
                                                $Link = $product->slug_full;
                                                $productTran = $product->translationsLanguage()->first();
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $loop->index+1 }}</td>
                                                <td>{{ $productTran->name }}</td>
                                                <td>
                                                    <a href="{{route('product.download',['slug'=>$productTran->slug]) }}" target="blank" class="file_download"><img src="{{ asset('frontend/images/taifile.png') }}"  alt="taifile"> <span>{{ number_format( $product->price) }} {{ __('product-by-category.diem') }}</span></a>
                                                </td>
                                              </tr>
                                        @endforeach
                                    @endguest
								</table>

                                <div class="text-center">
                                    {{ $data->links() }}
                                </div>
                                @endif
                            </div>

                                @include('frontend.components.sidebar',[
                                    // "categoryPost"=>$categoryPost,
                                    // "categoryPostActive"=>$categoryPostActive,
                                    // "post"=>true,
                                    ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@if (isset($dowload)&&$dowload)
<script>
   window.location.href="{{ $dowload }}";
</script>
@endif
<script>

    $(function(){
        $(document).on('click','.pt_icon_right',function(){
            event.preventDefault();
            $(this).parentsUntil('ul','li').children("ul").slideToggle();
            $(this).parentsUntil('ul','li').toggleClass('active');
        })
    })
</script>
@endsection
