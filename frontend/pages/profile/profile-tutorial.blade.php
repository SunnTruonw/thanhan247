@extends('frontend.layouts.main')

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
            <div class="block-tutorial">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="title-tutorial">
                                Hệ thống tính điểm
                            </div>
                            <div class="title-bg">
                                Điểm khởi tạo
                            </div>
                            <div class="content-tutorial">
                                <ul>
                                    <li><i class="fas fa-check-double"></i> Đăng ký thành viên thành công: <strong>15 điểm</strong></li>
                                    <li><i class="fas fa-check-double"></i> Check Thêm mới ảnh đại diện lần đầu: <strong>5 điểm</strong></li>
                                    <li><i class="fas fa-check-double"></i> Check Đăng nhập hàng ngày: <strong>2 điểm</strong></li>
                                </ul>
                            </div>
                            <div class="title-bg mt-3">
                                Bảng tính điểm thưởng
                            </div>
                            <div class="content-tutorial">
                                <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th>Nội dung</th>
                                        <th>Số điểm</th>

                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                            Các em sẽ dùng điểm HP tích lũy để đổi câu trả lời.
                                                Điểm HP càng lớn thì khả năng nhận được câu trả lời càng nhanh
                                        </td>
                                        <td>
                                            Số HP cần đổi
                                            <strong>2,4,8,10</strong>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                            Trả lời câu hỏi
                                        </td>
                                        <td>
                                            Được  <strong>50% số điểm </strong> của câu hỏi
                                        </td>
                                      </tr>
                                      {{-- <tr>
                                        <td>Mỗi lượt <b>cảm ơn</b> trong câu trả lời sẽ được tính <b>1 điểm</b>.
                                            <br>Do đó các em hãy đầu tư câu trả lời để kiếm được cảm ơn!
                                        </td>
                                        <td class="canhgiua">1 Cảm ơn = 1 điểm</td>
                                      </tr> --}}
                                      <tr>
                                        <td>
                                            <p>Đối các hình thức làm bài tập Online điểm số sẽ được tính dựa vào tổng điểm bài làm và sẽ được phân chia hệ số sau:</p>
                                            <p>Hệ số 1 - Trắc nghiệm theo bài học: =&gt; điểm kết quả x1
                                                <br>Hệ số 2 - Bài kiểm tra : =&gt; điểm kết quả x2
                                                <br>Hệ số 3 - Đề thi HK1, HK2, THPT QG: =&gt; điểm kết quả x3
                                            </p>
                                            <p class="cred">Lưu ý: điểm chỉ được tính cho lần đầu tiên làm bài và phải hoàn thành tất cả các câu trong đề. Các lần sau sẽ không được tính điểm</p>
                                        </td>
                                        <td class="canhgiua">
                                            <p>TB: 5 - 6.4 = 1 điểm</p>
                                            <p>Khá: 6.5 - 7.9 = 2 điểm</p>
                                            <p>Giỏi: 8 - 10 = 3 điểm</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Trừ điểm khi bị báo vi phạm</p>
                                            <p class="cred">Các sai phạm bao gồm: spam, lời lẽ thiếu lịch sự, nói tục.
                                                Nếu vi phạm quá 5 lần sẽ bị Ban nick vĩnh viễn</p>
                                        </td>
                                        <td class="canhgiua">-10 điểm</td>
                                    </tr>
                                    </tbody>
                                  </table>
                            </div>
                            <div class="title-bg">
                                Danh hiệu
                            </div>
                            <div class="list-danh-hieu">
                                <div class="dhieu">
                                    <div class="trai">
                                        <img src="{{ asset('frontend/images/1sao.png') }}">
                                    </div>
                                    <div class="phai">
                                        <p>MỚI THAM GIA: 0 HP</p>
                                        <p>Chào mừng bạn đến với Cộng đồng HỌC TRẠNG. Hãy bắt đầu làm bài trắc nghiệm và trả lời các câu hỏi để tăng điểm và thăng hạng nhé!</p>
                                    </div>
                                </div>
                                <div class="dhieu">
                                    <div class="trai">
                                        <img src="{{ asset('frontend/images/2sao.png') }}">
                                    </div>
                                    <div class="phai">
                                        <p>QUAN TÂM: 50 HP</p>
                                        <p>Bạn đã bắt đầu tương tác với những điều thú vị trên HỌC TRẠNG và muốn giúp đỡ thêm nhiều người bằng những câu trả lời hữu ích của mình rồi chứ? Cố gắng lên để đạt điểm số cao hơn nào!</p>
                                    </div>
                                </div>
                                <div class="dhieu">
                                    <div class="trai">
                                        <img src="{{ asset('frontend/images/3sao.png') }}">
                                    </div>
                                    <div class="phai">
                                        <p>TÍCH CỰC: 100 HP</p>
                                        <p>Mọi người trên HỌC TRẠNG đều thấy bạn là một học sinh tích cực. Hãy chăm chỉ và nỗ lực hơn nữa để có kết quả trắc nghiệm tốt hơn và có những câu trả lời hay hơn!</p>
                                    </div>
                                </div>
                                <div class="dhieu">
                                    <div class="trai">
                                        <img src="{{ asset('frontend/images/4sao.png') }}">
                                    </div>
                                    <div class="phai">
                                        <p>HIỂU BIẾT: 300 HP</p>
                                        <p>Bạn thực sự là một thành viên nổi bật của Cộng đồng HỌC TRẠNG. Chỉ có những người có kiến thức tốt và được ghi nhận như bạn mới có thể được gọi là hiểu biết.</p>
                                    </div>
                                </div>
                                <div class="dhieu">
                                    <div class="trai">
                                        <img src="{{ asset('frontend/images/5sao.png') }}">
                                    </div>
                                    <div class="phai">
                                        <p>THÔNG MINH: 900 HP</p>
                                        <p>Bạn có khả năng xuất sắc trong những môn học thế mạnh của mình khi đã dành điểm 8+ trong làm bài trắc nghiệm và được nhiều thành viên đánh giá cao với những câu trả lời không chỉ chính xác mà còn thú vị nữa.</p>
                                    </div>
                                </div>
                                <div class="dhieu">
                                    <div class="trai">
                                        <img src="{{ asset('frontend/images/6sao.png') }}">
                                    </div>
                                    <div class="phai">
                                        <p>TÀI NĂNG: 2700 HP</p>
                                        <p>Không chỉ đơn thuần là một học sinh thông minh, bạn còn thực sự là một tài năng không thể thiếu của Cộng đồng HỌC TRẠNG. Một chút cố gắng nữa để có thể đạt tới hạng cao nhất nào!</p>
                                    </div>
                                </div>
                                <div class="dhieu">
                                    <div class="trai">
                                        <img src="{{ asset('frontend/images/7sao.png') }}">
                                    </div>
                                    <div class="phai">
                                        <p>VƯỢT TRỘI: 8100 HP</p>
                                        <p>Bạn thực sự là một học sinh vượt trội trong Cộng đồng HỌC TRẠNG! Trí tuệ, sự cống hiến và thái độ tích cực của bạn xứng đáng được tôn trọng. Cho đi là nhận lại, những điều bạn chia sẻ đã giúp đỡ rất nhiều người. Đừng từ bỏ thói quen tốt đẹp đó để cộng đồng của chúng ta ngày càng phát triển hơn nữa nhé!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="support">
                                <p>Mọi thắc mắc các em có thể gửi về địa chỉ Email: <a class="cb2" href="mailto:{{ optional($header['email'])->slug }}">{{ optional($header['email'])->slug }}</a> hoặc HOTLINE: <a href="tel:{{ optional($header['hotline'])->slug }}">{{ optional($header['hotline'])->value }}</a></p>
                            </div>
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
