@extends('frontend.layouts.main')
@section('title', __('contact.thong_tin_lien_he'))
@section('keywords', __('contact.thong_tin_lien_he'))
@section('description', __('contact.thong_tin_lien_he'))
@section('image', asset(optional($header['seo_home'])->image_path))

@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{--
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset
            --}}

            <div class="text-left wrap-breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumbs-item">
                                    <a href="{{ makeLink('home') }}">{{ __('home.home') }}</a>
                                </li>
                                <li class="breadcrumbs-item active"><a href="" class="currentcat">{{ __('home.lien_he') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="block-contact">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                     

                            @if (isset($footer['dataAddress']) && $footer['dataAddress'])
                                <div class="title-contact">
                                    {{ $footer['dataAddress']->slug }}
                                </div>
                                <div class="content-address-footer">
                                    {!! $footer['dataAddress']->description !!}
                                </div>
                                <div class="list-address-footer">
                                    <ul>
                                        @foreach ($footer['dataAddress']->childs()->where('active',1)->orderby('order')->latest()->get() as $item)
                                            <li>
                                                <strong>{{ $item->name }}</strong>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            @isset($map)
                            <div class="map-contact">
                                {!! $map->description !!}
                            </div>
                            @endisset
                                    
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="contact-form">
                                <div>
                                    <div class="title_form">
                                       {{ __('contact.loi_nhan') }}
                                    </div>
                                    <form  action="{{ route('contact.storeAjax') }}"  data-url="{{ route('contact.storeAjax') }}" data-ajax="submit" data-target="alert" data-href="#modalAjax" data-content="#content" data-method="POST" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <i class="fas fa-phone-square-alt"></i>
                                            <input class="form-control" type="text" required="required" name="phone" placeholder="{{ __('contact.phone') }} (*)">
                                        </div>
                                        <div class="form-group">
                                            <i class="fas fa-envelope"></i>
                                            <input class="form-control" type="text" required="required" name="email" placeholder="Email (*)">
                                        </div>
                                        <div class="form-group">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input class="form-control" type="text" name="address_detail" placeholder="{{ __('contact.address') }}">
                                        </div>
                                        <div class="form-group">
                                            <i class="fas fa-pen"></i>
                                            <textarea class="form-control" name="content" cols="30" placeholder="{{ __('contact.noi_dung') }}" rows="3"></textarea>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-primary btn-lg btn-block" name="sublit">{{ __('contact.gui_thong_tin') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--
                <div class="wrap-form-tu-van">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-register">
                                    <div class="title-form-tv">
                                        Đăng ký nhận tin khuyến mại
                                    </div>
                                    <div class="box-form">
                                        <form action="index.php?act=newsletter" method="post" name="frmnewsletter" id="frmnewsletter" onsubmit="return validate('Vui lòng nhập email của bạn.');">
                                            <div class="input-group">
                                                <input type="text" name="txtemail" class="form-control" placeholder="Nhập địa chỉ email">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="submit" name="gone" id="gone">Đăng ký</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                --}}
            </div>
            {{--
            <div class="text-left wrap-breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumbs-item">
                                    <a href="{{ route('home.index') }}">{{ __('contact.trang_chu') }}</a>
                                </li>
                                <li class="breadcrumbs-item active"><a href="" class="currentcat">{{ __('contact.lien_he_toa_soan') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrap-content-main wrap-template-contact template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="contact-form">

                                <div>
                                    
                                    <p>Quý khách vui lòng điền đầy đủ các thông tin vào các ô dưới đây để gửi thông tin đến chúng tôi !</p>
                                    
                                    <div class="title_form">
                                        {{ __('contact.chu_the_lien_he') }}
                                    </div>

                                    <form  action="{{ route('contact.storeAjax') }}"  data-url="{{ route('contact.storeAjax') }}" data-ajax="submit" data-target="alert" data-href="#modalAjax" data-content="#content" data-method="POST" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label>{{ __('contact.name_address') }}</label>
                                            <input class="form-control" type="text" required="required" name="name">
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('contact.tieu_de') }}</label>
                                            <input class="form-control" type="text" required="required" name="title">
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('contact.noi_dung') }}</label>
                                            <textarea class="form-control" name="content" cols="30" rows="3"></textarea>
                                        </div>

                                        <button class="btn btn-primary btn-lg btn-block">{{ __('contact.gui_thong_tin') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="contact-infor">
                                <div class="infor">
                                    @isset($dataAddress)
                                        <div class="address">
                                            <div class="footer-layer">
                                                <div class="title">
                                                {{ __('contact.lien_he_tap_chi') }}
                                                </div>
                                                <div class="nd_lienhe">
                                                    {!! $dataAddress->description !!}
                                                </div>
                                                
                                                <ul class="pt_list_addres">
                                                    @foreach ($dataAddress->childs as $item)
                                                    <li>{!! $item->slug !!} {{ $item->value }}</li>
                                                    @endforeach
                                                </ul>
                                                
                                            </div>
                                        </div>
                                    @endisset
                                    
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            --}}
        </div>
    </div>

    <div class="modal fade in" id="modalAjax">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Chi tiết đơn hàng</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
             <div class="content" id="content">

             </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
@endsection
@section('js')
    {{--
    <script>

        // ajax load form
        $(document).on('submit',"[data-ajax='submit']",function(){
            let formValues = $(this).serialize();
            let dataInput=$(this).data();
            // dataInput= {content: "#content", href: "#modalAjax", target: "modal", ajax: "submit", url: "http://127.0.0.1:8000/contact/store-ajax"}

            $.ajax({
                type: dataInput.method,
                url: dataInput.url,
                data: formValues,
                dataType: "json",
                success: function (response) {
                    if(response.code==200){
                        if(dataInput.content){
                            $(dataInput.content).html(response.html);
                        }
                        if(dataInput.target){
                            switch (dataInput.target) {
                                case 'modal':
                                    $(dataInput.href).modal();
                                    break;
                                case 'alert':
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: response.html,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                default:
                                    break;
                            }
                        }
                    }else{
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: response.html,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                   // console.log( response.html);
                },
                error:function(response){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
            return false;
        });
    </script>
    --}}
@endsection
