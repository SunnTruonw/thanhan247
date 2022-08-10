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


                <div class="block-news">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-9 col-sm-12  block-content-right">
                                <h1 class="title-template">
                                    <span class="title-inner"> {{ $category->name??"" }} </span>
                                </h1>
                                @isset($data)
                                    <div class="wrap-list-news">
                                        <div class="list-card-news-horizontal">
                                            <div class="row">
                                                @foreach($data as $post_item)

                                                <div class="col-card-news-horizontal col-sm-12">
                                                    <div class="card-news-horizontal card-news-horizontal-2">
                                                        <div class="box">
                                                            <div class="image">
                                                                <a href="{{ makeLink('post',$post_item->id,$post_item->slug) }}"><img src="{{asset($post_item->avatar_path)}}" alt="{{$post_item->name}}"></a>
                                                            </div>
                                                            <div class="content">
                                                                <h3><a href="{{ makeLink('post',$post_item->id,$post_item->slug) }}">{{$post_item->name}}</a></h3>
                                                                 <div class="date">{{ Illuminate\Support\Carbon::parse($post_item->created_at)->format('d/m/Y') }} - Đăng bởi Admin</div>
                                                                <div class="desc">
                                                                    {{$post_item->description}}
                                                                </div>
                                                               <div class="text-right">
                                                                <a href="{{ makeLink('post',$post_item->id,$post_item->slug) }}" class="btn-viewmore btn btn-light">Xem thêm</a>
                                                               </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            @if (count($data))
                                            {{$data->appends(request()->all())->links()}}
                                            @endif
                                        </div>
                                    </div>
                                @endisset
                                @if ($category->content)
                                <div class="content-category" id="wrapSizeChange">
                                    {!! $category->content !!}
                                </div>
                                @endif
                            </div>

                            <div class="col-lg-3 col-sm-12 col-xs-12 block-content-left">
                                @isset($sidebar)
                                    @include('frontend.components.sidebar',[
                                        "categoryProduct"=>$sidebar['categoryProduct'],
                                        "categoryPost"=>$sidebar['categoryPost'],
                                        "categoryPost"=>$categoryPostSidebar,
                                        'fill'=>false,
                                        'product'=>false,
                                        'post'=>true,

                                    ])
                                @endisset

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

    })
</script>
@endsection
