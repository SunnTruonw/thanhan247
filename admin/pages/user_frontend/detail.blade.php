@extends('admin.layouts.main')
@section('title',"Edit user")
@section('css')
<link href="{{asset('lib/select2/css/select2.min.css')}}" rel="stylesheet" />
<style>
   .select2-container--default .select2-selection--multiple .select2-selection__choice{
   background-color: #000 !important;
   }
   .select2-container .select2-selection--single{
   height: auto;
   }
</style>
@endsection

@section('content')
<div class="content-wrapper">
   @include('admin.partials.content-header',['name'=>"Thành viên","key"=>"Thông tin thành viên"])
   <!-- Main content -->
   <div class="content">
      <div class="container-fluid">
         <div class="row">
             <div class="col-12">
                @if(session("alert"))
                <div class="alert alert-success">
                    {{session("alert")}}
                </div>
                @elseif(session('error'))
                <div class="alert alert-warning">
                    {{session("error")}}
                </div>
                @endif
                
                <form action="{{ route('admin.user_frontend.nap',['id'=>$user->id]) }}" method="POST" class="form-inline justify-content-end" enctype="multipart/form-data">
                    @csrf
                    <label for="email">Thanh toán:</label>
                    <input type="number" class="form-control" placeholder="Nhập số tiền" name="point">
                    

                    
                    <div id="hidden-div" onclick="getElementById('hidden-div').style.display = 'block'; this.style.display = 'none'" class="btn btn-primary" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Thanh toán</div>
                    
                    <style>
                           

                    </style>
                    <div class="row" style="width: 100%;">
                        <div class="col-12">
                          <div class="collapse multi-collapse" id="multiCollapseExample2">
                            <div class="card card-body" style="float: right; margin-top: 15px;">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group" style="width: 450px; ">
                                        <label for="exampleFormControlTextarea1">Ghi chú</label>
                                        <textarea style="width: 100%;display: block;border-radius:16px;" rows="2" class="form-control" id="exampleFormControlTextarea1" rows="3" name="note"></textarea>
                                    </div>
                                    <div class="form-group" style="padding: 20px 0">
                                        <label for="">Tải file đính kèm</label>
                                        <input type="file" style="width:200px" id="image" class="form-control-file img-load-input borderz" name="file">
                                    </div>
                                    <img id="preview-image-before-upload" class="img-load border p-1 w-100" src="https://247delivery.net/admin_asset/images/upload-image.png" style="height: 120px;object-fit:cover; max-width: 160px;">
                                </div>
                                <button type="submit" class="btn btn-primary" style="margin: 10px 0">Tiếp tục</button>
                            </div>
                          </div>
                        </div>
                    </div>
                </form>
             </div>
            <div class="col-md-12 col-sm-12 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Tổng công nợ</span>
                        <span class="info-box-number">{{ $sumPointCurrent  }}</span>
                    </div>
                </div>
            </div>
            @foreach ($sumEachType as $item)
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ $typePoint[$item->type]['name']  }}</span>
                            <span class="info-box-number">{{ $item->total  }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-12">
               <div class="row">
                   <div class=" col-md-12 col-lg-12">
                        <div class="wrap-user-frontend">
                            {!! $htmlPointNapUserFrontend !!}
                        </div>
                   </div>
                    {{-- <div class="col-md-12 col-lg-6">
                        <div class="wrap-rose-user-frontend">
                            {!! $htmlPointUseUserFrontend !!}
                        </div>
                   </div> --}}
               </div>


            </div>

         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content -->
</div>
@endsection
@section('js')
<script type="text/javascript">
      
    $(document).ready(function (e) {
     
       
       $('#image').change(function(){
                
        let reader = new FileReader();
     
        reader.onload = (e) => { 
     
          $('#preview-image-before-upload').attr('src', e.target.result); 
        }
     
        reader.readAsDataURL(this.files[0]); 
       
       });
       
    });
     
</script>
<script>
   $(function(){
    $(document).on('click','.pagination a',function(){
        event.preventDefault();
        let href=$(this).attr('href');
        //alert(href);
        $.ajax({
            type: "Get",
            url: href,
           // data: "data",
            dataType: "JSON",
            success: function (response) {
                if(response.type=='rose-user_frontend'){
                    $('.wrap-rose-user-frontend').html(response.html);
                } else if(response.type=='user_frontend'){
                    $('.wrap-user-frontend').html(response.html);
                }

            }
        });
    });
   })
</script>
@endsection
