
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
            @php
               $dataTran=$data->translationsLanguage()->first();
            @endphp
            <div class="blog-product-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12  block-content-right">
                            <div class="row" >
                                <div class="col-sm-12" id="dataProductSearch">
                                    <div class="box-product-main">
                                        <div class="row" >
                                            <div class="col-md-6 col-sm-12 col-12">
                                                  
                                                <div class="box-image-product">
                                                    <div class="image-main block">
                                                        <a class="hrefImg" href="{{ asset($data->avatar_path) }}" data-lightbox="image">
                                                            <i class="fas fa-expand-alt"></i>
                                                            <img id="expandedImg" src="{{  asset($data->avatar_path) }}">
                                                        </a>
                                                    </div>
                                                    {{-- <div class="share">
                                                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-591d2f6c5cc3d5e5"></script>
                                                        <div class="addthis_inline_share_toolbox"></div>
                                                    </div> --}}
                                                    @if ($data->images()->count())
                                                    <div class="list-small-image">
                                                        <div class="pt-box autoplay5-product-detail">
                                                            <div class="small-image column">
                                                                <img src="{{ asset($data->avatar_path) }}" alt="{{ asset($data->name) }}">
                                                            </div>
                                                            @foreach ($data->images as $image)
                                                            <div class="small-image column">
                                                                <img src="{{ asset($image->image_path) }}" alt="{{ asset($image->name) }}">
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-12 product-detail-infor">
                                                <div class="box-infor">
                                                    <div class="title_sp_detail">
                                                        <h1>{{ $data->name }}</h1>
                                                    </div>
                                                    <div class="info-desc">
                                                        <div class="desc">
                                                            {!! $data->content2 !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-product">
                                        <div role="tabpanel">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">

                                                <li class="nav-item">
                                                  <a class="nav-link active"  data-toggle="tab" href="#mota" role="tab" aria-controls="profile" aria-selected="false">{{ __('product-detail.thong_tin_chi_tiet') }}</a>
                                                </li>
                                                {{--
                                                <li class="nav-item">
                                                    <a class="nav-link"  data-toggle="tab" href="#chinhsach" role="tab" aria-controls="home" aria-selected="true">Bảo Hành Đổi Trả</a>
                                                </li>
                                                --}}
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade  show active" id="mota" role="tabpanel" aria-labelledby="profile-tab">
                                                    {!! $data->content !!}
                                                </div>
                                                {{--
                                                <div class="tab-pane fade" id="chinhsach" role="tabpanel" aria-labelledby="home-tab">
                                                    {!! $data->content2 !!}
                                                </div>
                                                --}}
               
                                            </div>


                                        </div>

                                    </div>
                                    <div class="product-relate">
										<div class="col-sm-12 col-12">
											<div class="group-title">
												<h2 class="title">{{ __('product-detail.san_pham_lien_quan') }}</h2>
											</div>
										</div>
                                        <div class="list-product-card">
                                            @isset($dataRelate)
                                                @if ($dataRelate->count())
                                                    <div class="row">
                                                        @foreach ($dataRelate as $product)
                                                            @php
                                                                $tran=$product->translationsLanguage()->first();
                                                                $link=$product->slug_full;
                                                            @endphp
                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                                <div class="product-card">
                                                                    <div class="box">
                                                                        <div class="card-top">
                                                                            <div class="image">
                                                                                <a href="{{ $link }}">
                                                                                    <img src="{{ asset($product->avatar_path) }}" alt="{{ $tran->name }}" class="image-card image-default">
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
                                                @endif
                                            @endisset
                                        </div>
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-3 col-sm-12 col-xs-12 block-content-left">
                            @isset($sidebar)
                                @include('frontend.components.sidebar',[
                                    "categoryProduct"=>$sidebar['categoryProduct'],
                                    "categoryPost"=>$sidebar['categoryPost'],
                                    'fill'=>true,
                                    'product'=>true,
                                    'post'=>false,
                                    'urlActive'=>makeLink('category_products',$data->category->id,$data->category->slug) ,
                                ])
                            @endisset

                        </div> --}}
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('js')
<script type="text/javascript">
        $(document).ready(function() {
            $('.autoplay1').slick({
                dots: false,
                arrows: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                speed: 300,
                autoplaySpeed: 3000,
            });
            $('.column').click(function() {
                var src = $(this).find('img').attr('src');
                $(".hrefImg").attr("href", src);
                $("#expandedImg").attr("src", src);
            });
            $('.slide_small').slick({
                dots: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: 2000,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    }
                }]
            });


            $(document).on('click','.tab-link ul li a',function(){
                    $('.tab-link ul li a').removeClass('active');
                    $(this).addClass('active');
            });
            $('.autoplay5-product-detail').slick({
                dots: false,
                vertical:true,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                responsive: [{
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 551,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            vertical: false,
                        }
                    }
                ]
            });

            $(document).on('change','.field-form',function(){
          // $( "#formfill" ).submit();

                let contentWrap = $('#dataProductSearch');

                let urlRequest = '{{ makeLinkById('category_products',$data->category->id) }}';
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
    </script>
<script type="text/javascript">
        $(document).ready(function() {
            var boxnumber = $('.box-add-cart input').val();
            parseInt(boxnumber);
            $('.cart_qty_add').click(function() {
                if ($(this).parent().parent().find('input').val() < 50) {
                    var a = $(this).parent().parent().find('input').val(+$(this).parent().parent().find(
                        'input').val() + 1);
                         let url = $('#addCart').data('start');
                         url += "?quantity=" + $('#cart_quantity').val();
                         $('#addCart').attr('data-url',url);
                        //$("#optionChange").trigger('change');
                }
            });
            $('.cart_qty_reduce').click(function() {
                if ($(this).parent().parent().find('input').val() > 1) {
                    if ($(this).parent().parent().find('input').val() > 1) $(this).parent().parent().find(
                        'input').val(+$(this).parent().parent().find('input').val() - 1);
                        let url = $('#addCart').data('start');
                        url += "?quantity=" + $('#cart_quantity').val();

                        $('#addCart').attr('data-url',url);
                        //$("#optionChange").trigger('change');
                }
            });

            $(document).on('change','#cart_quantity',function(){
                if ($(this).parent().parent().find('input').val() > 1) {
                    var a = $(this).val();
                    let url = $('#addCart').data('start');
                    url += "?quantity=" + $('#cart_quantity').val();
                    $('#addCart').attr('data-url',url);
                }
            });

            $(document).on('change','.optionChange',function(){
                let val= ($(this).val()) ;
                let arrPriceAndId = val.split("-").map(function(value,index){
                    return parseInt(value);
                });
 
                var nf = Intl.NumberFormat();

                let text= 'Liên hệ';
                let url = $('#addCart').data('start');
                url += "?quantity=" + $('#cart_quantity').val();
                /*if(arrPriceAndId[1]){
                    url += "&option=" + arrPriceAndId[1];
                }
                if(arrPriceAndId[0]>0){
                    let price= nf.format(arrPriceAndId[0]);
                    text=price+'<span class="donvi"> đ</span>';
                }*/
                $('#addCart').attr('data-url',url);
                $('#priceChange').html(text);
            });
        });
    </script>
@endsection
