@extends('frontend.layouts.main-profile')

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
                               <span class="info-box-text"> Tổng số điểm hiện có</span>
                               <span class="info-box-number"> <strong>{{ $sumPointCurrent?$sumPointCurrent:0  }}</strong> Điểm</span>
                            </div>
                         </div>
                    </div>

                    @isset($sumEachType)
                        @foreach ($sumEachType as $item)
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-cart-plus"></i></span>
                                    <div class="info-box-content">
                                       <span class="info-box-text"> {{ $typePoint[$item['type']]['name']  }}</span>
                                       <span class="info-box-number"> <strong>{{ $item['total']  }}</strong> Điểm</span>
                                    </div>
                                 </div>
                            </div>
                        @endforeach
                    @endisset
                    <div class="col-md-12 col-sm-12">
                        <div class="title-friend mt-4 text-center">
                            Hoạt động
                        </div>
                        <div class="list-point-user">
                            <ul>
                                @foreach ($data as $point)
                                <li>
                                    <div class="box">
                                        <a href="{{$point->pointInfo()['url'] }}">
                                            <div class="top">
                                                <strong>{{$point->pointInfo()['type'] }} </strong>
                                                <span>{{$point->point>0?'+'. $point->point:$point->point }} điểm</span>
                                            </div>
                                            <div class="text">{{ $point->pointInfo()['name'] }}</div>
                                        </a>

                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                       <div class="mt-2 mb-3"> {{ $data->links() }}</div>
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
