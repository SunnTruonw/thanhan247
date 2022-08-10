@extends('frontend.layouts.main')
@section('title', optional($header['seo_home'])->nameL)
@section('keywords', optional($header['seo_home'])->slugL)
@section('description', optional($header['seo_home'])->valueL)
@section('image', asset(optional($header['seo_home'])->image_path))
@php
     $postM=new App\Models\Post();
     $galaxyM=new App\Models\Galaxy();
@endphp
@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="wrap_home">
                <div class="slide">
                    @isset($slider)
                    <div class="box-slide faded cate-arrows-1 d-none d-md-block">
                        @foreach ($slider as $item)
                        <div class="item-slide">
                            <a href="{{ $item->slug }}"><img src="{{ $item->image_path }}" alt="{{ $item->name }}"></a>
                        </div>
                        @endforeach
                    </div>
                    @endisset

                    @isset($slidersM)
                    <div class="box-slide faded cate-arrows-1 d-block d-md-none" >
                        @foreach ($slidersM as $item)
                        <div class="item-slide">
                            <a href="{{ $item->slug }}"><img src="{{ $item->image_path }}" alt="{{ $item->name }}"></a>
                        </div>
                        @endforeach
                    </div>
                    @endisset
                </div>
                <div class="tracuu_vandon">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-12">
								<div class="tab-product">
                                    <div role="tabpanel">
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade  show active" id="mota" role="tabpanel" aria-labelledby="profile-tab">
                                                <form action="{{ route('search.index') }}" method="get">
                                                    <div class="tim_don">
                                                        <div class="title_timdon">
                                                            <h2>Tra Cứu Hành Trình Đơn Hàng</h2>
                                                            <p>Mã vận đơn (Tra nhiều bill bằng cách thêm dấu phẩy giữa các bill VD: 12313123,57787317)</p>
                                                        </div>
                                                        <div class="form-dn">
                                                            <input placeholder="Nhập mã vận đơn" name="order_code" type="text" value="">
                                                            <div class="form_dn_in">
                                                                <button type="submit">Tra cứu</button>
                                                            </div>
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
		@if( isset($dichvupost) && $dichvupost->count()>0)
				<div class="wrap-pro-tab-home">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="group-title">
                                    <h2 class="title">{{ $dichvupost->value }}</h2>
                                </div>
                            </div>
							<div class="col-sm-12 col-12">
								<div class="wrap-box-top item-about">
									<div class="left">
										<a href="{{ $dichvupost->slug }}">
											  <img src="{{ asset($dichvupost->image_path) }}" alt="{{ $dichvupost->name }}">
										  </a>
									</div>
									<div class="right padding-r">
										<div class="content">
											<div class="box_info">
												<div class="desc2">
													{!! $dichvupost->description !!}
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="buttom_gui">
									<a href="post-category/dich-vu">Xem thêm</a>
								</div>
							</div>
                        </div>
                    </div>
                </div>
                @endif
                @php
                    $modalPost = new App\Models\Post;
                @endphp
				
                @if( isset($listWhy) && $listWhy->count()>0)
                <div class="why_choose_us">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="group-title">
                                    <h2 class="title">{{ __('home.taisao') }} <span>{{ __('home.taisao1') }}</span></h2>
									<div class="desc_home">
										{{ $listWhy->valueL }}
									</div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <div class="row">
                                    @foreach($listWhy->childLs()->where('active',1)->orderBy('order')->get() as $item)
                                    <div class="col-sm-3 col-12">
                                        <div class="list_why">
                                            <div class="box">
                                                <div class="image">
                                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->nameL }}">
                                                </div>
                                                <div class="desc">
                                                    <h2>{{ $item->nameL }}</h2>
                                                    <p>{{ $item->valueL }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
				
                @if( isset($catePostHot) && $catePostHot->count()>0)
                <div class="wrap-new-hot">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="group-title">
                                    <div class="title">
                                        {{ __('home.tin_tuc_noi_bat') }}
                                    </div>
                                    <div class="desc-title">
                                        {{ $catePostHot->valueL }}
                                    </div>
                                </div>
									<div class="pt_box_left">
										@php
											$listPostHot = $modalPost->mergeLanguage()->whereIn('category_id', $listIdCatePost)->where('active',1)->orderByDesc('created_at')->limit(1)->get();
											@endphp
											@foreach( $listPostHot as $item )
										<div class="pt_list_new_main">
											<div class="pt_new_main">
												<div class="pt_images">
													<a href="{{ $item->slug_full }}"><img src="{{ asset( $item->avatar_path) }}" alt="{{ $item->nameL }}"></a>
												</div>
												<div class="pt_box_content">
													<h3><a href="{{ $item->slug_full }}">{{ $item->nameL }}</a></h3>
													<div class="pt_desc">
														{{ $item->descriptionL }}
													</div>
													<div class="detail_home">
														<a href="{{ $item->slug_full }}">{{ __('home.xemthem1') }}</a>
														<p><i class="far fa-clock"></i> {{ date_format($item->updated_at,"d/m/Y")}}</p>
													</div>
												</div>
											</div>
										</div>
										
										@endforeach
										<div class="pt_list_new_small">
											@php
											$listPostHot = $modalPost->mergeLanguage()->whereIn('category_id', $listIdCatePost)->where('active',1)->where('hot',1)->orderByDesc('created_at')->limit(4)->get();
											@endphp
											@foreach( $listPostHot as $item )
											<div class="pt_new_small">
												<div class="pt_images">
													<a href="{{ $item->slug_full }}"><img src="{{ asset( $item->avatar_path) }}" alt="{{ $item->nameL }}"></a>
												</div>
												<div class="pt_box_content">
													<h3><a href="{{ $item->slug_full }}">{{ $item->nameL }}</a></h3>
													<div class="pt_desc">
														{{ $item->descriptionL }}
													</div>
													<div class="detail_home">
														<a href="{{ $item->slug_full }}">{{ __('home.xemthem1') }}</a>
														<p><i class="far fa-clock"></i> {{ date_format($item->updated_at,"d/m/Y")}}</p>
													</div>
												</div>
											</div>
										@endforeach
										</div>
									</div>
                            </div>
							
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

@endsection
@section('js')

@endsection
