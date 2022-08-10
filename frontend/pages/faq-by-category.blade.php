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
                                    @if ($loop->first)
                                        <li class="breadcrumbs-item active"><a
                                                href="{{ makeLink($typeBreadcrumb, $item['id'] ?? '', $item['slug'] ?? '') }}"
                                                class="currentcat">Hỏi đáp</a></li>
                                    @else
                                        <li class="breadcrumbs-item"><a
                                                href="{{ makeLink($typeBreadcrumb, $item['id'] ?? '', $item['slug']) ?? '' }}"
                                                class="currentcat">{{ $item['name'] }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <h1 class="title-template-news d-none">{{ $category->name }}</h1>
            <div class="blog-news">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12 block-content-right">
                            <h1 class="title-template">
                                <span class="title-inner"><i class="fas fa-angle-double-right"></i>
                                    {{ $category->name }} </span>
                            </h1>
                            <div class="wrap-add-faq">
                                <div class="text-right"><a href="" class="btn btn-warning" id="addFaq"><i
                                            class="far fa-question-circle"></i> Đặt câu hỏi</a></div>
                                <div class="form-add-faq">
                                    <form action="" method="get">
                                        @csrf
                                        <div class="title-form-add-faq">
                                            Đặt câu hỏi
                                        </div>
                                        <div class="content-form-add-faq">
                                            <div class="cout-point">
                                                Bạn đang có <strong>14</strong> Hp
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" value="" name="point"
                                                            checked>2 HP
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" value="" name="point">4
                                                        HP
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" value="" name="point">8
                                                        HP
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" value=""
                                                            name="point">10 HP
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="alert alert-danger">
                                                Điểm HP càng cao thì khả năng nhận câu trả lời càng nhanh
                                            </div>
                                            <div class="form-group">
                                                <label for="">Tiêu đề câu hỏi</label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Bạn muốn hỏi về vấn đề gì">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="">Nội dung câu hỏi</label>
                                                <textarea class="form-control" name="content" rows="3"
                                                    placeholder="Nhập nội dung câu hỏi"></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label" for="">Lớp</label>
                                                        <select class="form-control custom-select select-2-init" id="" value="" name="class">
                                                            <option value="0">--- Lớp ---</option>
                                                            {{-- {!!$option!!} --}}

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label" for="">Môn</label>
                                                        <select class="form-control custom-select select-2-init" id="" value="" name="subject">
                                                            <option value="0">--- Môn ---</option>
                                                            {{-- {!!$option!!} --}}

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label" for="">Bài</label>
                                                        <select class="form-control custom-select select-2-init" id="" value="" name="subject">
                                                            <option value="0">--- Bài ---</option>
                                                            {{-- {!!$option!!} --}}

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button class="btn btn-warning">Gửi câu hỏi</button>
                                                <button class="btn btn-light">Hủy bỏ</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                            <div class="list-faq-question">
                                <div class="row">
                                    <div class="col-faq-question-item col-lg-6 col-md-12 col-sm-12">
                                        <div class="faq-question-item">
                                            <div class="box">
                                                <div class="top">
                                                    <div class="icon">
                                                        <img src="https://hoc247.net/images/avatar/library/8.jpg" alt="">
                                                    </div>
                                                    <div class="content-top">
                                                        <h3><a href="">Phan văn tân</a></h3>
                                                        <div class="desc-top">6/6/2021</div>
                                                    </div>
                                                </div>
                                                <div class="mid">
                                                    <h3>
                                                        <a href="">
                                                            Biết có một xí nghiệp dự định sản xuất
                                                            Biết có một xí nghiệp dự định sản xuất
                                                            Biết có một xí nghiệp dự định sản xuất
                                                            Biết có một xí nghiệp dự định sản xuất
                                                        </a>
                                                    </h3>
                                                    <div class="desc">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                        Harum officia nostrum quisquam dolorum dicta similique,
                                                        maxime veritatis consequatur voluptates! Consequatur pariatur
                                                        mollitia iste placeat,
                                                        dolore repellendus corrupti ratione repudiandae at!
                                                    </div>
                                                </div>
                                                <div class="bot">
                                                    <div class="left">
                                                        <i class="fas fa-comment-dots"></i> 5
                                                    </div>
                                                    <div class="right">
                                                        <span class="point">0 điểm</span>
                                                        <a href="" class="btn btn-warning btn-sm">Trả lời</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-faq-question-item col-lg-6 col-md-12 col-sm-12">
                                        <div class="faq-question-item">
                                            <div class="box">
                                                <div class="top">
                                                    <div class="icon">
                                                        <img src="https://hoc247.net/images/avatar/library/8.jpg" alt="">
                                                    </div>
                                                    <div class="content-top">
                                                        <h3><a href="">Phan văn tân</a></h3>
                                                        <div class="desc-top">6/6/2021</div>
                                                    </div>
                                                </div>
                                                <div class="mid">
                                                    <h3>
                                                        <a href="">
                                                            Biết có một xí nghiệp dự định sản xuất
                                                            Biết có một xí nghiệp dự định sản xuất
                                                            Biết có một xí nghiệp dự định sản xuất
                                                            Biết có một xí nghiệp dự định sản xuất
                                                        </a>
                                                    </h3>
                                                    <div class="desc">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                        Harum officia nostrum quisquam dolorum dicta similique,
                                                        maxime veritatis consequatur voluptates! Consequatur pariatur
                                                        mollitia iste placeat,
                                                        dolore repellendus corrupti ratione repudiandae at!
                                                    </div>
                                                </div>
                                                <div class="bot">
                                                    <div class="left">
                                                        <i class="fas fa-comment-dots"></i> 5
                                                    </div>
                                                    <div class="right">
                                                        <span class="point">0 điểm</span>
                                                        <a href="" class="btn btn-warning btn-sm">Trả lời</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            @isset($data)
                                <div class="list-faq-question">
                                    <div class="row">
                                        @foreach ($data as $faq)
                                            <div class="col-faq-question-item col-lg-4 col-md-4 col-sm-6">
                                                <div class="faq-question-item">
                                                    <div class="box">
                                                        <div class="top">
                                                            <div class="icon">
                                                                <img src="https://hoc247.net/images/avatar/library/8.jpg"
                                                                    alt="">
                                                            </div>
                                                            <div class="content-top">
                                                                <h3><a href="">Phan văn tân</a></h3>
                                                                <div class="desc-top">6/6/2021</div>
                                                            </div>
                                                        </div>
                                                        <div class="mid">
                                                            <h3>
                                                                <a href="">
                                                                    Biết có một xí nghiệp dự định sản xuất
                                                                    Biết có một xí nghiệp dự định sản xuất
                                                                    Biết có một xí nghiệp dự định sản xuất
                                                                    Biết có một xí nghiệp dự định sản xuất
                                                                </a>
                                                            </h3>
                                                            <div class="desc">
                                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                Harum officia nostrum quisquam dolorum dicta similique,
                                                                maxime veritatis consequatur voluptates! Consequatur pariatur
                                                                mollitia iste placeat,
                                                                dolore repellendus corrupti ratione repudiandae at!
                                                            </div>
                                                        </div>
                                                        <div class="bot">
                                                            <div class="left">
                                                                <i class="fas fa-comment-dots"></i> 5
                                                            </div>
                                                            <div class="right">
                                                                <span class="point">0 điểm</span>
                                                                <a href="" class="btn btn-warning btn-sm">Trả lời</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="pagination-group">
                                    <div class="pagination">
                                        @if (count($data))
                                            {{ $data->links() }}
                                        @endif
                                    </div>
                                </div>
                            @endisset
                        </div>
                        <div class="col-lg-3 col-sm-12  block-content-left">
                            @include('frontend.components.sidebar',[
                            "categoryFaq"=>$categoryFaq,
                            "categoryFaqActive"=>$categoryFaqActive,
                            "faq"=>true,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- <script>
        $(function() {
            $(document).on('click', '.pt_icon_right', function() {
                event.preventDefault();
                $(this).parentsUntil('ul', 'li').children("ul").slideToggle();
                $(this).parentsUntil('ul', 'li').toggleClass('active');
            })
        })
    </script> --}}
@endsection
