@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')
@section('content')
    <div class="content-wrapper">
        <div class="main">
            @if (isset($category) && $category)
            <div class="wrap-list-tien-ich">
                @foreach($category->childLs()->where('category_products.active','1')->orderBy('order')->get() as $item)
                <div class="item-tien-ich">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="box-tien-ich">
                                    <div class="left">
                                        <div class="title-tien-ich">
                                            {{ $item->nameL }}
                                        </div>
                                        <div class="box-text">
                                            {{ $item->descriptionL }}
                                        </div>
                                        <div class="text-left">
                                            <a href="{{ $item->slugL }}" class="btn btn-xemthem">{{ __('home.xem_them') }} <i class="fas fa-minus"></i></a>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="image">
                                            <img src="{{ asset($item->avatar_path) }}" alt="{{ $item->nameL }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
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
