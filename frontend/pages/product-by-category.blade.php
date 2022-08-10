@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')
@section('content')
    <div class="content-wrapper">
        <div class="main">
            
            @isset($breadcrumbs, $typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                'breadcrumbs'=>$breadcrumbs,
                'type'=>$typeBreadcrumb,
                ])
            @endisset

            @php
                $modelCateProduct = new App\Models\CategoryProduct;
                $tranMerge = $modelCateProduct->mergeLanguage()->find($category->id);
            @endphp
            
            <div class="wrap-content-main wrap-template-product template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12  block-content-right">
                            <h3 class="title-template-news">{{ $category->name??"" }}</h3>
                            @if (isset($category) && $category)
                            <div class="box-text">
                                {!! $tranMerge->contentL !!}
                            </div>
                            @endif
                            @isset($data)
                                <div class="wrap-list-product">
                                    <div class="list-product-card">
                                        <div class="row">
                                            @foreach($data as $product)
                                                @php
                                                    $tran=$product->translationsLanguage()->first();
                                                    $link=$product->slug_full;
                                                @endphp
                                                <div class="col-md-3 col-sm-6 col-6">
                                                    <div class="product-card">
                                                        <div class="box">
                                                            <div class="card-top">
                                                                <div class="image">
                                                                    <a href="{{ $link }}">
                                                                        <img src="{{ asset($product->avatar_path) }}" alt="{{$tran->name}}" class="image-card image-default">
                                                                    </a>
                                                                    @if ($product->sale)
                                                                    <span class="sale-1">-{{ $product->sale }}%</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <h4 class="card-name"><a href="{{ $link }}">{{ $tran->name }}</a></h4>
                                                                {{--<div class="card-price">
                                                                    @if($product->price)
                                                                        <span class="new-price">{{ $product->price_after_sale }} {{ $unit  }}</span>
                                                                        @if ($product->sale>0)
                                                                        <span class="old-price">{{ $product->price }} {{ $unit  }}</span>
                                                                        @endif
                                                                    @else
                                                                        <span class="new-price">{{ __('home.lien_he') }}
                                                                        </span>
                                                                    @endif  
                                                                </div>--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        @if (count($data))
                                        {{$data->links()}}
                                        @endif
                                    </div>
                                </div>
                            @endisset

                        </div>
                        {{--<div class="col-lg-3 col-sm-12 col-xs-12 block-content-left">
                            <div id="side-bar">
                                @if( isset($listate) && $listate->count()>0)
                                <div class="side-bar">
                                    <div class="title-sider-bar">
                                        {{ $listate->nameL }}
                                    </div>
                                    <div class="list-category">
                                        <ul class="menu-side-bar">
                                            @foreach($listate->childLs()->where('active',1)->orderBy('order')->get() as $item)
                                            <li class="nav_item">
                                                <a href="{{ $item->slug_full }}"><span>{{ $item->nameL }}</span>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif

                                @if( isset($banner_sidebar) && $banner_sidebar->count()>0)
                                <div class="side-bar">
                                    <div class="banner_right">
                                        
                                            <img src="{{ asset($banner_sidebar->image_path) }}" alt="{{ $banner_sidebar->nameL }}">
                                        
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>--}}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
    {{-- <script>
    $(function(){
        $(document).on('change','.field-form',function(){
          // $( "#formfill" ).submit();

           let contentWrap = $('#dataProductSearch');

            let urlRequest = '{{ url()->current() }}';
            let data=$("#formfill").serialize();
            $.ajax({
                type: "GET",
                url: urlRequest,
                data:data,
                success: function(data) {
                    if (data.code == 200) {
                        let html = data.html;
                        contentWrap.html(html);
                    }
                }
            });
        });
        // load ajax phaan trang
        $(document).on('click','.pagination a',function(){
            event.preventDefault();
            let contentWrap = $('#dataProductSearch');
            let href=$(this).attr('href');
            //alert(href);
            $.ajax({
                type: "Get",
                url: href,
            // data: "data",
                dataType: "JSON",
                success: function (response) {
                    let html = response.html;

                    contentWrap.html(html);
                }
            });
        });
    });
</script> --}}
@endsection
