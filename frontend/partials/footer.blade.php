@if( isset($footer['doitac']) && $footer['doitac']->count()>0)
<div class="wrap-partner">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="group-title">
                    <h2 class="title">{{ __('footer.congty') }} <span>{{ __('footer.congty1') }}</span></h2>
                </div>
                <div class="list-item autoplay4-doitac category-slide-1">
                    @foreach( $footer['doitac']->childLs()->where('active',1)->orderBy('order')->orderByDesc('created_at')->get() as $item )
                    <div class="item">
                        <div class="box">
                            <a href="{{ $item->slugL }}"><img src="{{ asset($item->image_path) }}" alt="{{ $item->nameL }}"></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if( isset($footer['khachhang']) && $footer['khachhang']->count()>0)
<div class="wrap-partner">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="group-title">
                    <h2 class="title">{{ __('footer.congty2') }} <span>{{ __('footer.congty3') }}</span></h2>
                </div>
                <div class="list-item autoplay4-doitac category-slide-1">
                    @foreach( $footer['khachhang']->childLs()->where('active',1)->orderBy('order')->orderByDesc('created_at')->get() as $item )
                    <div class="item">
                        <div class="box">
                            <a href="{{ $item->slugL }}"><img src="{{ asset($item->image_path) }}" alt="{{ $item->nameL }}"></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<footer class="footer">
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">
							<div class="box_logo_foot">
                                <div class="logo-footer">
                                    @if (isset($footer['logo'])&&$footer['logo'])
                                    <a href="{{ makeLink('home') }}"><img src="{{ asset($footer['logo']->image_path) }}" alt="Logo footer"></a>
                                    @endif
                                </div>
                            </div>
							@if (isset($footer['dataAddress']) && $footer['dataAddress'])
                                <div class="content-address-footer">
                                    {!! $footer['dataAddress']->description !!}
                                </div>
                                <div class="list-address-footer">
                                    <ul>
                                        @foreach ($footer['dataAddress']->childs()->where('active',1)->orderby('order')->latest()->get() as $item)
                                            <li>
												<img src="{{ asset($item->image_path) }}" alt="{{$item->name}}">
                                                <strong>{{ $item->name }}</strong>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {{--
                            
                            @if( isset($footer['socialParent']) && $footer['socialParent']->count()>0)
                            <ul class="pt_social">
                                @foreach( $footer['socialParent'] as $item)
                                <li class="social-item"><a href="{{ $item->slugL }}" target="_blank" rel="noopener noreferrer">{!! $item->valueL !!}</a></li>
                                @endforeach
                            </ul>
                            @endif

                            @if( isset($footer['about']) && $footer['about']->count()>0)
                            <div class="name-company">
                                {{ $footer['about']->valueL }}
                            </div>
                            <div class="address-footer">
                                {!! $footer['about']->descriptionL !!}
                            </div>
                            @endif
                            --}}
                        </div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-6 col-item-footer">
                            @if (isset($footer['lien_ket'])&&$footer['lien_ket'])
                            <div class="title-footer">
                               {{ $footer['lien_ket']->name }}
                            </div>
                            <div class="list-link-footer">
                                <ul class="footer-link">
                                    @foreach ($footer['lien_ket']->childs()->where('active',1)->orderby('order')->latest()->get() as $item)
                                        <li><a href="{{ $item->slug }}">{{ $item->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-4 col-md-5 col-sm-12">
                            @if( isset($footer['hour_open']) && $footer['hour_open']->count()>0)
                            <div class="title-footer">
                                {{ __('footer.bando') }}
                            </div>
                            <div class="hours_open">
                                {!! $footer['hour_open']->descriptionL !!}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-12 col-12">
                    <div class="coppy_right">
                        {{ $footer['coppy_right']->valueL }}
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-12">
                    <div class="menu_bottom">
                        <ul>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
</footer>

<div class="pt_contact_vertical">
    <div class="contact-mobile">
        <div class="contact-item">
            <a class="contact-icon zalo" title="zalo" href="https://zalo.me/{{ optional($header['hotline1'])->valueL }}"
                target="_blank">
                <img src="{{ asset('frontend/images/zalo-icon.png') }}" alt="icon">
            </a>
        </div>
		<div class="contact-item">
            <a class="contact-icon fb-mess" title="messenger2" href="https://m.me/giaohangnhanhhanoi" target="_blank">
                <img src="{{ asset('frontend/images/messenger2.png') }}" alt="icon">
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="quick-alo-phone quick-alo-green quick-alo-show" id="quick-alo-phoneIcon">
    <div class="tel_phone">
        <a href="tel:{{ optional($header['hotline1'])->valueL }}">{{ optional($header['hotline1'])->valueL }}</a>
    </div>
    <a href="tel:{{ optional($header['hotline1'])->valueL }}">
        <div class="quick-alo-ph-circle"></div>
        <div class="quick-alo-ph-circle-fill"></div>
        <div class="quick-alo-ph-img-circle"></div>
    </a>
</div>
<div class="back_to_top hidden-xs" id="back-to-top">
    <a onclick="topFunction();">
        <span>{{ __('footer.ve_dau_trang') }}</span>
        <img src="{{ asset('frontend/images/icon_back_to_top.png') }}">
    </a>
</div>
<div class="contact_fixed">
    <li><a href="tel:{{ optional($header['hotline1'])->valueL }}"><i class="fa fa-phone"></i></a></li>
    <li>
        <a href="https://zalo.me/{{ optional($header['hotline1'])->valueL }}"><img src="{{ asset('frontend/images/zalo2.png') }}" alt="Zalo"></a>
    </li>
    <li>
        <a href="https://m.me/giaohangnhanhhanoi"><img src="{{ asset('frontend/images/messenger2.png') }}" alt="Messenger"></a>
    </li>
    <li>
        <a onclick="topFunction();" href="javascript:;"><img src="{{ asset('frontend/images/icon_back_to_top.png') }}" alt="Back to top"></a>
    </li>
</div>



<script>
    // ajax load form
    
    $(document).on('submit', "[data-ajax='submit']", function() {
        let formValues = $(this).serialize();
        let dataInput = $(this).data();
        // dataInput= {content: "#content", href: "#modalAjax", target: "modal", ajax: "submit", url: "http://127.0.0.1:8000/contact/store-ajax"}

        $.ajax({
            type: dataInput.method,
            url: dataInput.url,
            data: formValues,
            dataType: "json",
            success: function(response) {
                if (response.code == 200) {
                    if (dataInput.content) {
                        $(dataInput.content).html(response.html);
                    }
                    if (dataInput.target) {
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
                } else {
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
            error: function(response) {
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
    

    $(document).on('click', '.btn-colsap', function() {
        $(this).parents('.view-answer').find('.collapse-content').slideToggle();
    });
</script>
