<style>
    body {
        font-family: 'Open Sans', sans-serif;
        background-color: #fff !important;
    }

    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap');

    .nav-item i {
        padding-right: 5px;
    }

    .nav-sidebar>.nav-item a p {
        font-size: 14px;
    }

    .nav-treeview>.nav-item>.nav-link {
        color: #eee;
        padding: 4px 20px 4px 32px;
    }

    .nav-item i {
        color: #b3cbdd;
        padding-right: 5px;
    }

    .nav-treeview>.nav-item>.nav-link p {
        font-size: 12px;
        color: #b3cbdd
    }

    .nav-treeview>.nav-item>.nav-link i {
        font-size: 12px;
        color: #b3cbdd
    }

    .sidebar {
        background: #2A3F54;
        padding: 0;
    }

    .sidebar a {
        color: #17a2b8;
    }

    .form-inline {
        padding: 15px 0;
    }

    .nav-sidebar>.nav-item {
        color: #b3cbdd;
        font-size: 14px;
        padding-left: 0px;
        border-bottom: 1px solid #25384c;
        border-top: 1px solid #304558;
    }

</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary" style="background: #2A3F54;">
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3  d-flex" style="padding: 0px 0 0 0;">
            <div class="image">
                <img src="{{ asset('admin_asset/images/username.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    @if (Auth::guard('admin')->check())
                        {{ Auth::guard('admin')->user()->name }}
                    @endif
                </a>
            </div>
        </div>
        {{-- <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
             <input class="form-control form-control-sidebar" type="search" placeholder="Tìm kiếm" aria-label="Tìm kiếm">
             <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
             </div>
          </div>
       </div> --}}
        <!-- Sidebar Menu -->
        @php
            $routerName = request()
                ->route()
                ->getName();
        @endphp
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.index') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>BẢNG ĐIỀU KHIỂN</p>
                    </a>
                </li>
                @canany(['category-post-list', 'post-list', 'post-list-self'])
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-globe-americas"></i>
                            <p>
                                Quản lý tin bài dịch vụ
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('category-post-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.categorypost.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Danh mục</p>
                                    </a>
                                </li>
                            @endcan

                            @can('post-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.post.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Tin tức</p>
                                    </a>
                                </li>
                            @endcan
							{{--
                            @can('post-list-self')
                                <li class="nav-item">
                                    <a href="{{ route('admin.post.listSelf') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Tin tức của tôi</p>
                                    </a>
                                </li>
                            @endcan--}}
                        </ul>
                    </li>
                @endcanany
{{--
                @canany(['category-product-list', 'product-list'])
                    <li class="nav-item">
                        <a href="#" class="nav-link ">
                            <i class="fas fa-chart-bar"></i>
                            <p>
                                Quản lý sản phẩm
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('category-product-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.categoryproduct.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Danh mục sản phẩm</p>
                                    </a>
                                </li>
                            @endcan
                            @can('product-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Sản phẩm</p>
                                    </a>
                                </li>
                            @endcan
                             @can('product-list')
                            <li class="nav-item">
                                <a href="{{ route('admin.attribute.index') }}" class="nav-link">
                                    <i class="fas fa-angle-double-right"></i>
                                    <p>Thuộc tính sản phẩm</p>
                                </a>
                            </li>
                        @endcan
                        @can('product-list')
                            <li class="nav-item">
                                <a href="{{ route('admin.supplier.index') }}" class="nav-link">
                                    <i class="fas fa-angle-double-right"></i>
                                    <p>Nhà cung cấp sản phẩm</p>
                                </a>
                            </li>
                        @endcan 
                        </ul>
                    </li>
                @endcanany--}}

                {{-- @canany(['about-list'])
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-images"></i>
                        <p>
                            Quản lý giấy giới thiệu
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('about-list')
                            <li class="nav-item">
                                <a href="{{ route('admin.about.index') }}" class="nav-link">
                                    <i class="fas fa-angle-double-right"></i>
                                    <p>Danh sách</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @endcanany 

                @canany(['category-galaxy-list', 'galaxy-list'])
                    <li class="nav-item">
                        <a href="#" class="nav-link ">
                            <i class="fas fa-chart-bar"></i>
                            <p>
                                Quản lý video và hình ảnh
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('category-galaxy-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.categorygalaxy.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Danh mục video và hình ảnh</p>
                                    </a>
                                </li>
                            @endcan
                            @can('galaxy-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.galaxy.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Video và hình ảnh</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany--}}

                @canany(['setting-list'])
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <p>
                                Quản lý thông tin/Banner
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('setting-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.setting.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Thông tin/Banner</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany


                @canany(['menu-list', 'menu-add'])
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <p>
                                Menu
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('menu-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.menu.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>List menu</p>
                                    </a>
                                </li>
                            @endcan
                            @can('menu-add')
                                <li class="nav-item">
                                    <a href="{{ route('admin.menu.create') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Thêm menu</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany




                @canany(['category-program-list', 'program-list'])
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-globe-americas"></i>
                            <p>
                                Chương trình
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('category-program-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.categoryprogram.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Danh mục</p>
                                    </a>
                                </li>
                            @endcan
                            @can('program-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.program.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Chương trình</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['category-exam-list', 'exam-list'])
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-globe-americas"></i>
                            <p>
                                Đề thi
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('category-exam-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.categoryexam.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Danh mục</p>
                                    </a>
                                </li>
                            @endcan
                            @can('exam-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.exam.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Đề thi</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                {{-- @canany(['slider-list']) --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-images"></i>
                        <p>
                            Quản lý slide
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- @can('slider-list') --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.slider.index') }}" class="nav-link">
                                <i class="fas fa-angle-double-right"></i>
                                <p>Slider</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                {{-- @endcanany --}}


                @canany(['admin-user_frontend-list', 'admin-user_frontend-add'])
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i>
                            <p>
                                Quản lý khách hàng
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('admin-user_frontend-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.user_frontend.index') }}" class="nav-link">
                                        <i class="fas fa-user-check"></i>
                                        <p>Danh sách khách hàng</p>
                                    </a>
                                </li>
                            @endcan
                            {{-- @can('admin-user_frontend-nap')
                      <li class="nav-item">
                        <a href="{{route('admin.user_frontend.historyPoint')}}" class="nav-link">
                           <i class="fas fa-user-check"></i>
                           <p>Lịch sử nạp, sử dụng điểm</p>
                        </a>
                     </li>
                     @endcan --}}
                            {{-- <li class="nav-item">
                           <a href="{{route('admin.user_frontend.index',['fill_action'=>'userActive'])}}" class="nav-link">
                           <i class="fas fa-user-check"></i>
                           <p>Đã kích hoạt</p>
                           </a>
                       </li>

                      <li class="nav-item">
                           <a href="{{route('admin.user_frontend.index',['fill_action'=>'userNoActive'])}}" class="nav-link">
                           <i class="fas fa-user-clock"></i>
                           <p>Đang đợi kích hoạt</p>
                           </a>
                       </li> --}}

                            {{-- @can('admin-user_frontend-add')
                      <li class="nav-item">
                         <a href="{{route('admin.user_frontend.create')}}" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <p>Thêm thành viên</p>
                         </a>
                      </li>
                      @endcan --}}
                        </ul>
                    </li>
                @endcanany


                @canany(['transaction-list'])
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cart-plus"></i>
                            <p>
                                Quản lý đơn hàng
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission-add')
                                <li class="nav-item">
                                    <a href="{{ route('admin.transaction.index') }}" class="nav-link">
                                        <i class="fas fa-cart-plus"></i>
                                        <p>Đơn hàng</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cart-plus"></i>
                        <p>
                            Quản lý đơn hàng
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.order_management.index') }}" class="nav-link">
                                <i class="fas fa-cart-plus"></i>
                                <p>Danh sách đơn hàng</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('admin.csv-management.index') }}" class="nav-link">
                                <i class="fas fa-cart-plus"></i>
                                <p>Quản lý csv</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users-cog"></i>
                        <p>
                            Quản lý shippers
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.shipper.index') }}" class="nav-link">
                                <i class="fas fa-users-cog"></i>
                                <p>Danh sách nhân viên giao hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-id-card-alt"></i>
                        <p>
                            Thông tin liên hệ
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.contact.index') }}" class="nav-link">
                                <i class="fas fa-angle-double-right"></i>
                                <p>Danh sách liên hệ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @canany(['admin-user-list', 'role-add', 'permission-list'])
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <p>
                                Hệ thống
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('admin-user-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.user.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Quản trị viên</p>
                                    </a>
                                </li>
                            @endcan
                            @can('role-add')
                                <li class="nav-item">
                                    <a href="{{ route('admin.role.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Vai trò</p>
                                    </a>
                                </li>
                            @endcan
                            @can('permission-list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.permission.index') }}" class="nav-link">
                                        <i class="fas fa-angle-double-right"></i>
                                        <p>Mô đun</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                <!--
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="nav-icon fas fa-th"></i>
                   <p>
                      Simple Link
                      <span class="right badge badge-danger">New</span>
                   </p>
                </a>
             </li>-->
            </ul>
        </nav>
    </div>
</aside>
