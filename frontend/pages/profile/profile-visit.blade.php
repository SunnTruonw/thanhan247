@extends('frontend.layouts.main-profile-visit')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
@section('css')
<style>
    .info-box {
    box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
    border-radius: .25rem;
    background-color: #fff;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 1rem;
    min-height: 80px;
    padding: .5rem;
    position: relative;
    width: 100%;
}
.info-box .info-box-icon {
    border-radius: .25rem;
    -ms-flex-align: center;
    align-items: center;
    display: -ms-flexbox;
    display: flex;
    font-size: 1.875rem;
    -ms-flex-pack: center;
    justify-content: center;
    text-align: center;
    width: 60px;
    flex:0 0 auto;
}
.info-box .info-box-content {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-pack: center;
    justify-content: center;
    line-height: 1.8;
    -ms-flex: 1;
    flex: 1;
    padding: 0 10px;
}
.info-box .info-box-text, .info-box .progress-description {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.info-box .info-box-number {
    display: block;
    margin-top: .25rem;
    font-weight: 700;
}
.card-title{
    font-size: 25px;
    font-weight: bold;
    margin-top: 0;
}

</style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{-- @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset --}}
            <div class="wrap-content-main">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-cart-plus"></i></span>
                            <div class="info-box-content">
                               <span class="info-box-text"> T???ng s??? ??i???m hi???n c??</span>
                               <span class="info-box-number"> <strong>{{ $sumPointCurrent?$sumPointCurrent:0  }}</strong> ??i???m</span>
                            </div>
                         </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-question"></i></span>
                            <div class="info-box-content">
                               <span class="info-box-text"> S??? c??u h???i</span>
                               <span class="info-box-number"> <strong>{{ $countFaq  }}</strong> c??u</span>
                            </div>
                         </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fas fa-comment-dots"></i></span>
                            <div class="info-box-content">
                               <span class="info-box-text"> S??? c??u tr??? l???i</span>
                               <span class="info-box-number"> <strong>{{ $countFaqAnswer  }}</strong> c??u</span>
                            </div>
                         </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="list-friend mb-3">
                            <div class="title-friend">
                                Danh s??ch b???n b??
                            </div>
                            <ul class="row">

                                @foreach ($user->friends()->latest()->get() as $friend)
                                <li class="col-sm-6 col-md-4">
                                    <a href="{{ route('profile.visit',['code'=>$friend->code]) }}" class="bg-light">
                                        <div class="icon"><img src="{{ $friend->avatar_path?$friend->avatar_path: $shareFrontend['userNoImage'] }}" alt=" {{ $friend->name }}"></div>
                                       <div class="desc">
                                        {{ $friend->name }}
                                       </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                      </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="title-friend mt-4 text-center">
                            Ho???t ?????ng
                        </div>
                        <div class="list-point-user">
                            <ul>
                                @foreach ($data as $point)
                                <li>
                                    <div class="box">
                                        <a href="{{$point->pointInfo()['url'] }}">
                                            <div class="top">
                                                <strong>{{$point->pointInfo()['type'] }} </strong>
                                                <span>{{$point->point>0?'+'. $point->point:$point->point }} ??i???m</span>
                                            </div>
                                            <div class="text">{{ $point->pointInfo()['name'] }}</div>
                                        </a>

                                    </div>
                                </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
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
