@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')

@section('content')
    <div class="content-wrapper">
        <div class="main">
            @include('frontend.components.breadcrumbs',[
                'breadcrumbs'=>$breadcrumbs,
                'breadcrumbs'=>$breadcrumbs,
                'type'=>$typeBreadcrumb,
            ])

            <div class="blog-lienhe-hoptac">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="shadow  padding-content">
                                <div class="group-title">
                                    <div class="title text-left title-red">
                                        {{ $data->name }}
                                    </div>
                                </div>
                                <div class="content-lienhe-hoptac">
                                    {!! $data->content !!}
                                </div>
                                <div class="form-contact-hoptac">
                                    <form  action="{{ route('contact.storeAjax') }}"  data-url="{{ route('contact.storeAjax') }}" data-ajax="submit" data-target="alert" data-href="#modalAjax" data-content="#content" data-method="POST" method="POST" class="row p-75">
                                        @csrf
                                        <div class="col-xs-12 p-75">
                                            <div class="title-form">{{ __('bao-gia.thong_tin_ca_nhan') }}</div>
                                        </div>
                                        <div class="form-group col-xs-12 p-75">
                                            <label for="">{{ __('bao-gia.ho_va_ten') }}</label>
                                            <input name="name" type="text" class="form-control" placeholder="{{ __('bao-gia.ho_va_ten') }}" required>
                                        </div>

                                        <div class="form-group col-md-8 col-sm-8 col-xs-12 p-75">
                                            <label for="">{{ __('bao-gia.so_dien_thoai') }}</label>
                                            <input name="phone" type="text" class="form-control" placeholder="{{ __('bao-gia.so_dien_thoai') }}" required>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12 p-75">
                                            <label for="" style="width: 100%;">{{ __('bao-gia.gioi_tinh') }}</label>
                                            <div class="border-input">
                                                <label class="radio-inline">
                                                    <input type="radio" name="sex" value="{{ __('bao-gia.name') }}">
                                                    <span class="design"></span>
                                                    <span class="text">{{ __('bao-gia.name') }}</span>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="sex" value="{{ __('bao-gia.nu') }}">
                                                    <span class="design"></span>
                                                    <span class="text">{{ __('bao-gia.nu') }}</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 col-sm-12 col-xs-12 p-75">
                                            <label for="">{{ __('bao-gia.email') }}</label>
                                            <input name="email" type="text" class="form-control" placeholder="{{ __('bao-gia.email') }}">
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12 p-75">
                                            <label for="">{{ __('bao-gia.dich_vu_khach_hang_quan_tam') }}</label>
                                            <select name="service" class="form-control">
                                                <option value="0" disabled>{{ __('bao-gia.chon_dich_vu') }}</option>
                                                @isset($listCategoryHome)
                                                @foreach ($listCategoryHome as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12 p-75">
                                            <label for="">{{ __('bao-gia.tuyen_du_dinh_van_chuyen') }}</label>
                                            <div class="row p-75">
                                                <div class="col-md-6 col-sm-6 col-xs-6  p-75">
                                                    <input name="from" type="text" class="form-control" placeholder="{{ __('bao-gia.tu') }}">
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6  p-75">
                                                    <input name="to" type="text" class="form-control" placeholder="{{ __('bao-gia.den') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12 p-75">
                                            <label for="">{{ __('bao-gia.mong_muon_cua_khach_hang') }}</label>
                                            <textarea name="content" class="form-control" rows="8" placeholder="{{ __('bao-gia.mong_muon_cua_khach_hang') }}"></textarea>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12 p-75">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="" id="agree">{{ __('bao-gia.toi_dong_y_voi') }} <a href="" target="_blank">{{ __('bao-gia.dieu_khoan_dich_vu') }}</a> </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 p-75">
                                            <div class="text-center">
                                                <button name="gone" type="submit" class="btn-view">{{ __('bao-gia.gui_yeu_cau') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $("#form-contact").submit(function(event) {
                if ($("#agree").prop("checked")) {
                    return true
                } else {
                    alert("{{ __('bao-gia.ban_phai_dong_y') }}");
                    return false;
                }
            });
        });
    </script>


@endsection
@section('js')

@endsection
