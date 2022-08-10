@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')

@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="text-left wrap-breadcrumbs">

                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumbs-item">
                                    <a href="{{ makeLink('home') }}">{{ __('home.home') }}</a>
                                </li>
                                @foreach ($breadcrumbs as $item)
                                    <li class="breadcrumbs-item"><a href="{{ $item['slug'] }}"
                                            class="currentcat">{{ $item['name'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @if($data)
            <div class="block-post-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="title-l">
                                {{ $data->descriptionL }}
                            </div>
                        </div>
                    </div>
                </div>

                @if( isset($trai_nghiem) && $trai_nghiem->count()>0)
                <div class="wrap-about-home" style="background-color: #fff;">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-12">
                                <div class="group-title">
                                    <div class="title">
                                        {{ $trai_nghiem->nameL }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-12">
                                        <div class="box-text">
                                            {{ $trai_nghiem->descriptionL }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-12">
                                        <div class="box-text">
                                            {!! $trai_nghiem->contentL !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-content-detail">
                                <h3>Hố 1 part 4 435</h3>
                                <div class="desc">
                                    <div>
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Officiis beatae fuga aperiam saepe non? A, ab! Quos, fuga, amet ut consequuntur perspiciatis, eaque animi molestias autem eius consequatur cumque corrupti! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore eaque inventore distinctio ullam ipsam voluptatum cupiditate iste! Enim corrupti ipsam, vero, itaque nostrum consequuntur libero id dicta, quasi magnam veritatis! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde fugiat excepturi amet eaque ipsa eius cumque a, nulla itaque deserunt alias. Praesentium omnis tenetur cumque quis odit blanditiis totam magnam.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="wrap-number-detail">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="item-number">
                                   <div class="box">
                                       <div class="left">
                                           <div class="image">
                                               <img src="https://tuanchau.dkcauto.net/frontend/images/img-number.jpg" alt="">
                                           </div>
                                       </div>
                                       <div class="right">
                                            <div class="box-number">
                                                <div class="number">
                                                    1
                                                </div>
                                                <ul class="p1">
                                                    <li><span>Par</span><strong>4</strong></li>
                                                    <li><span>Index</span><strong>4</strong></li>
                                                </ul>
                                                <div class="list-number">
                                                    <ul>
                                                        <li>437</li>
                                                        <li>437</li>
                                                        <li>437</li>
                                                        <li>437</li>
                                                    </ul>
                                                </div>
                                            </div>
                                       </div>
                                   </div>
                                </div>
                                <div class="list-navbar">
                                    <ul>
                                        <li><a href="" class="active">1</a></li>
                                        <li><a href="">2</a></li>
                                        <li><a href="">3</a></li>
                                        <li><a href="">4</a></li>
                                        <li><a href="">5</a></li>
                                        <li><a href="">6</a></li>
                                        <li><a href="">7</a></li>
                                        <li><a href="">8</a></li>
                                        <li><a href="">9</a></li>
                                        <li><a href="">10</a></li>
                                        <li><a href="">11</a></li>
                                        <li><a href="">12</a></li>
                                        <li><a href="">13</a></li>
                                        <li><a href="">14</a></li>
                                        <li><a href="">15</a></li>
                                        <li><a href="">16</a></li>
                                        <li><a href="">17</a></li>
                                        <li><a href="">18</a></li>
                                     </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="logo-home mt-2" style="background-color: #fff;">
                    <span></span>
                    <img src="{{ asset($header['logo']->image_path) }}" alt="Logo">
                    <span></span>
                </div>
            </div>
            @endif

        </div>
    </div>

@endsection
@section('js')

@endsection
