@extends('admin.layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('lib/char\js\Chart.min.css') }}">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #fff !important;
        }

        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap');

        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        ul {
            padding-left: 20px;
        }

        .status>span {
            cursor: pointer;
        }

        .card {
            box-shadow: 0 0 0px rgb(0 0 0 / 13%), 0 0px 0px rgb(0 0 0 / 20%);
            margin-bottom: 1rem;
            background: #f4f6f9;
        }

        .content-wrapper>.content {
            padding: 25px .5rem;
            margin: 0 !important;
        }

        .navbar {
            padding: 13px 0;
        }

        .card-body {
            background: #fff;
        }

        ul {
            padding-left: 0px;
            margin-bottom: 0;
        }

        .card-header {
            background: #333;
        }

        .card-title {
            float: left;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        .list-news-home {}

        .list-news-home li a {}

    </style>
@endsection
@section('title', 'Trang chủ admin')
@section('content')
    <div class="content-wrapper">
        {{-- <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0">Starter Page</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Starter Page</li>
               </ol>
            </div>
         </div>
      </div>
   </div> --}}
        <div class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8" style="display: none">
                        <!-- LINE CHART -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Biểu đồ doanh thu các ngày trong tháng</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="lineChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-12 card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Thống kê chung</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-newspaper"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Bài Viết Dịch vụ</span>
                                        <span class="info-box-number">{{ number_format($totalProduct) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger"><i class="far fa-newspaper"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Danh mục bài viết</span>
                                        <span class="info-box-number">{{ number_format($totalPost) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-cart-plus"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Thông tin liên hệ/ Báo Giá</span>
                                        <span class="info-box-number">{{ number_format($countContact) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Khách đang truy câp</span>
                                        <span class="info-box-number">1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <!--<div class="card card-info">
                  <div class="card-header">
                     <h3 class="card-title">Biểu đồ doanh thu các ngày trong tháng</h3>
                     <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                        </button>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="chart">
                        <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                     </div>
                  </div>
               </div>--> --}}
                    </div>
                    {{-- <!--
            <div class="col-md-4">
               <!-- PIE CHART
               <div class="card card-danger">
                  <div class="card-header">
                     <h3 class="card-title">Thống kê trạng thái đơn hàng</h3>
                     <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                        </button>
                     </div>
                  </div>
                  <div class="card-body">
                     <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                  <!-- /.card-body
               </div>
               <!-- /.card
            </div>--> --}}
                </div>
                <div class="row">
                    {{--
                    <div class="col-md-6">
                        <div class="card card-outline card-primary mb-3">
                            <div class="card-header">
                                <h3 class="card-title">Bài đã duyệt mới nhất</h3>
                            </div>
                            <div class="card-body table-responsive p-0 lb-list-category" style="max-height: 500px;">
                                <table class="table table-head-fixed" style="font-size:13px;">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th class="white-space-nowrap">Avatar</th>
                                            <th class="white-space-nowrap">Trạng thái</th>
                                            @can('post-hot')
                                                <th class="white-space-nowrap">Nổi bật</th>
                                            @endcan
                                            <th class="white-space-nowrap">Danh mục</th>
                                            <th class="white-space-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($postDaduyet as $postItem)
                                            <tr>
                                                <td>{{ $loop->index }}</td>

                                                <td>{{ $postItem->name }}</td>
                                                <td class="wrap-load-status">
                                                    @include('admin.components.load-change-status',['data'=>$postItem])
                                                </td>
                                                @can('post-hot')
                                                <td class="wrap-load-hot"
                                                    data-url="{{ route('admin.post.load.hot', ['id' => $postItem->id]) }}">
                                                    @include('admin.components.load-change-hot',['data'=>$postItem,'type'=>'bài
                                                    viết'])
                                                </td>
                                                @endcan
                                                <td class="white-space-nowrap">
                                                    @can('post-edit', $postItem->id)
                                                        <a href="{{ route('admin.post.edit', ['id' => $postItem->id]) }}"
                                                            class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                    @endcan
                                                    @can('post-delete')
                                                        <a data-url="{{ route('admin.post.destroy', ['id' => $postItem->id]) }}"
                                                            class="btn btn-sm btn-danger lb_delete"><i
                                                                class="far fa-trash-alt"></i></a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    --}}
                    <div class="col-md-6">
                       <div class="card card-outline card-primary">
                          <div class="card-header">
                             <h3 class="card-title">10 Tin tức thêm gần đây</h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body table-responsive p-0" style="height: 345px;">
                                <ul class="list-news-home list-group">

                                    @foreach ($postNews as $item)
                                    <li class="list-group-item">
                                        <a href="{{route('admin.post.edit',['id'=>$item->id])}}"> <i class="fas fa-caret-right"></i> {{ $item->name }}</a>
                                    </li>
                                    @endforeach

                                </ul>
                          </div>
                          <!-- /.card-body -->
                       </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">10 Sản phẩm thêm gần đây</h3>
                            </div>
                            <div class="card-body table-responsive p-0" style="height: 345px;">
                                <ul class="list-news-home list-group">
                                    @foreach ($productNews as $item)
                                    <li class="list-group-item">
                                        <a href="{{route('admin.product.edit',['id'=>$item->id])}}"> <i class="fas fa-caret-right"></i> {{ $item->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    {{--
                    @canany(['view-thu-ky', 'post-pho-tong','post-tong-bien-tap'])
                        <div class="col-md-6">
                            <div class="card card-outline card-primary mb-3">
                                <div class="card-header">
                                    <h3 class="card-title">Bài đang chờ duyệt</h3>
                                </div>
                                <div class="card-body table-responsive p-0 lb-list-category" style="max-height: 500px;">
                                    <table class="table table-head-fixed" style="font-size:13px;">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th class="white-space-nowrap">Avatar</th>
                                                <th class="white-space-nowrap">Trạng thái</th>
                                                @can('post-hot')
                                                    <th class="white-space-nowrap">Nổi bật</th>
                                                @endcan
                                                <th class="white-space-nowrap">Danh mục</th>
                                                <th class="white-space-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($postChoDuyet as $postItem)
                                                <tr>
                                                    <td>{{ $loop->index }}</td>

                                                    <td>{{ $postItem->name }}</td>
                                                    <td class="wrap-load-status">
                                                        @include('admin.components.load-change-status',['data'=>$postItem])
                                                    </td>
                                                    @can('post-hot')
                                                    <td class="wrap-load-hot"
                                                        data-url="{{ route('admin.post.load.hot', ['id' => $postItem->id]) }}">
                                                        @include('admin.components.load-change-hot',['data'=>$postItem,'type'=>'bài
                                                        viết'])
                                                    </td>
                                                    @endcan
                                                    <td class="white-space-nowrap">
                                                        @can('post-edit', $postItem->id)
                                                            <a href="{{ route('admin.post.edit', ['id' => $postItem->id]) }}"
                                                                class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        @can('post-delete')
                                                            <a data-url="{{ route('admin.post.destroy', ['id' => $postItem->id]) }}"
                                                                class="btn btn-sm btn-danger lb_delete"><i
                                                                    class="far fa-trash-alt"></i></a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    @endcanany
                    --}}
                    {{--
                    @canany(['view-phong-vien','post-bien-tap'])
                    <div class="col-md-6">
                        <div class="card card-outline card-primary mb-3">
                            <div class="card-header">
                                <h3 class="card-title">Bài bị trả lại</h3>
                            </div>
                            <div class="card-body table-responsive p-0 lb-list-category" style="max-height: 500px;">
                                <table class="table table-head-fixed" style="font-size:13px;">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th class="white-space-nowrap">Avatar</th>
                                            <th class="white-space-nowrap">Trạng thái</th>
                                            @can('post-hot')
                                                <th class="white-space-nowrap">Nổi bật</th>
                                            @endcan
                                            <th class="white-space-nowrap">Danh mục</th>
                                            <th class="white-space-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($postTraLai as $postItem)
                                            <tr>
                                                <td>{{ $loop->index }}</td>

                                                <td>{{ $postItem->name }}</td>
                                                <td class="wrap-load-status">
                                                    @include('admin.components.load-change-status',['data'=>$postItem])
                                                </td>
                                                @can('post-hot')
                                                <td class="wrap-load-hot"
                                                    data-url="{{ route('admin.post.load.hot', ['id' => $postItem->id]) }}">
                                                    @include('admin.components.load-change-hot',['data'=>$postItem,'type'=>'bài
                                                    viết'])
                                                </td>
                                                @endcan
                                                <td class="white-space-nowrap">
                                                    @can('post-edit', $postItem->id)
                                                        <a href="{{ route('admin.post.edit', ['id' => $postItem->id]) }}"
                                                            class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                    @endcan
                                                    @can('post-delete')
                                                        <a data-url="{{ route('admin.post.destroy', ['id' => $postItem->id]) }}"
                                                            class="btn btn-sm btn-danger lb_delete"><i
                                                                class="far fa-trash-alt"></i></a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                @endcanany
                --}}
                </div>

                {{-- <div class="row" style="display: none">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title">Card title</h5>
                     <p class="card-text">
                        Some quick example text to build on the card title and make up the bulk of the card's
                        content.
                     </p>
                     <a href="#" class="card-link">Card link</a>
                     <a href="#" class="card-link">Another link</a>
                  </div>
               </div>
               <div class="card card-primary card-outline">
                  <div class="card-body">
                     <h5 class="card-title">Card title</h5>
                     <p class="card-text">
                        Some quick example text to build on the card title and make up the bulk of the card's
                        content.
                     </p>
                     <a href="#" class="card-link">Card link</a>
                     <a href="#" class="card-link">Another link</a>
                  </div>
               </div>
               <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">
                     <h5 class="m-0">Featured</h5>
                  </div>
                  <div class="card-body">
                     <h6 class="card-title">Special title treatment</h6>
                     <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                     <a href="#" class="btn btn-primary">Go somewhere</a>
                  </div>
               </div>
               <div class="card card-primary card-outline">
                  <div class="card-header">
                     <h5 class="m-0">Featured</h5>
                  </div>
                  <div class="card-body">
                     <h6 class="card-title">Special title treatment</h6>
                     <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                     <a href="#" class="btn btn-primary">Go somewhere</a>
                  </div>
               </div>
            </div>
            <!-- /.col-md-6 -->
         </div> --}}
                <!-- /.row -->
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')
<script>
    $(function() {
        $(document).on('click', '.lb-status', function() {
            event.preventDefault();

            let wrapActive = $(this).parents('.wrap-load-status');
            let urlRequest = $(this).data("url");

            let type = $(this).data("type");
            let title = '';
            title = 'Bạn có chắc chắn muốn ' + type;
            Swal.fire({
                title: title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: urlRequest,
                        success: function(data) {
                            if (data.code == 200) {
                                let html = data.html;
                                wrapActive.html(html);
                            }
                        }
                    });
                }
            })
        });

    });
</script>
    <script src="{{ asset('lib/char\js\Chart.min.js') }}"></script>
    <script>
        var areaChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                    label: 'Digital Goods',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [28, 48, 40, 19, 86, 27, 90]
                },
                // {
                //     label: 'Electronics',
                //     backgroundColor: 'rgba(210, 214, 222, 1)',
                //     borderColor: 'rgba(210, 214, 222, 1)',
                //     pointRadius: false,
                //     pointColor: 'rgba(210, 214, 222, 1)',
                //     pointStrokeColor: '#c1c7d1',
                //     pointHighlightFill: '#fff',
                //     pointHighlightStroke: 'rgba(220,220,220,1)',
                //     data: [65, 59, 80, 81, 56, 55, 40]
                // },
            ]
        }
        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false,
                    }
                }]
            }
        }

        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
        var lineChartOptions = $.extend(true, {}, areaChartOptions);
        var lineChartData = $.extend(true, {}, areaChartData);
        lineChartData.datasets[0].fill = false;
        //    lineChartData.datasets[1].fill = false;
        lineChartOptions.datasetFill = false;

        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        });



        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutData = {
            labels: [
                'Đặt hàng thành công',
                'Tiếp nhận đơn hàng',
                'Đang vận chuyển',
                'Hoàn thành',
                'Hủy bỏ',
            ],
            datasets: [{
                data: [
                    {{ $countTransaction[1] }},
                    {{ $countTransaction[2] }},
                    {{ $countTransaction[3] }},
                    {{ $countTransaction[4] }},
                    {{ $countTransaction[-1] }}
                ],
                backgroundColor: ['#c3e6cb', '#ffc107', '#17a2b8', '#28a745', '#dc3545'],
            }]
        }
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData = donutData;
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
    </script>

@endsection
