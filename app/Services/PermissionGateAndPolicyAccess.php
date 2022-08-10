<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin;
use App\Models\User;
class PermissionGateAndPolicyAccess
{

    public function setGateAndPolicyAccess()
    {
        $this->defineGateCategoryProduct();
        $this->defineGateCategoryPost();
        $this->defineGateCategoryGalaxy();
        $this->defineGateSlider();
        $this->defineGateMenu();
        $this->defineGateBank();
        $this->defineGateProduct();
        $this->defineGatePost();
        $this->defineGateGalaxy();
        $this->defineGateSetting();
        $this->defineGateUser();
        $this->defineGateUserFrontend();
        $this->defineGateRole();
        $this->defineGatePermission();
        $this->defineGatePay();
        $this->defineGateStore();
        $this->defineGateTransaction();
        $this->defineGateProgram();
        $this->defineGateCategoryProgram();
        $this->defineGateCategoryExam();
        $this->defineGateExam();
        $this->defineGateAbout();
        $this->defineGateView();
        $this->defineGateOrderManagement();
    }
    public function defineGateCategoryProduct()
    {
        // module category_product
        Gate::define('category-product-list', 'App\Policies\Admins\AdminCategoryProductPolicy@list');
        Gate::define('category-product-add', 'App\Policies\Admins\AdminCategoryProductPolicy@add');
        Gate::define('category-product-edit', 'App\Policies\Admins\AdminCategoryProductPolicy@edit');
        Gate::define('category-product-delete', 'App\Policies\Admins\AdminCategoryProductPolicy@delete');
    }
    public function defineGateCategoryPost()
    {
        // module category_post
        Gate::define('category-post-list', 'App\Policies\Admins\AdminCategoryPostPolicy@list');
        Gate::define('category-post-add',  'App\Policies\Admins\AdminCategoryPostPolicy@add');
        Gate::define('category-post-edit',  'App\Policies\Admins\AdminCategoryPostPolicy@edit');
        Gate::define('category-post-delete', 'App\Policies\Admins\AdminCategoryPostPolicy@delete');
    }
    public function defineGateSlider()
    {
        // module slider
        Gate::define('slider-list', 'App\Policies\Admins\AdminSliderPolicy@list');
        Gate::define('slider-add', 'App\Policies\Admins\AdminSliderPolicy@add');
        Gate::define('slider-edit', 'App\Policies\Admins\AdminSliderPolicy@edit');
        Gate::define('slider-delete', 'App\Policies\Admins\AdminSliderPolicy@delete');
    }
    public function defineGateMenu()
    {
        // module menu
        Gate::define('menu-list', 'App\Policies\Admins\AdminMenuPolicy@list');
        Gate::define('menu-add', 'App\Policies\Admins\AdminMenuPolicy@add');
        Gate::define('menu-edit', 'App\Policies\Admins\AdminMenuPolicy@edit');
        Gate::define('menu-delete', 'App\Policies\Admins\AdminMenuPolicy@delete');
    }

    public function defineGateProduct()
    {
        // module product
        Gate::define('product-list', 'App\Policies\Admins\AdminProductPolicy@list');
        Gate::define('product-add', 'App\Policies\Admins\AdminProductPolicy@add');
        Gate::define('product-edit', 'App\Policies\Admins\AdminProductPolicy@edit');
        Gate::define('product-delete', 'App\Policies\Admins\AdminProductPolicy@delete');
    }
    public function defineGatePost()
    {
        // module post
        Gate::define('post-list', 'App\Policies\Admins\AdminPostPolicy@list');
        Gate::define('post-add', 'App\Policies\Admins\AdminPostPolicy@add');
        Gate::define('post-edit', 'App\Policies\Admins\AdminPostPolicy@edit');
        Gate::define('post-delete', 'App\Policies\Admins\AdminPostPolicy@delete');
        Gate::define('post-hot', 'App\Policies\Admins\AdminPostPolicy@hot');
        Gate::define('post-active', 'App\Policies\Admins\AdminPostPolicy@active');
        Gate::define('post-send-duyet', 'App\Policies\Admins\AdminPostPolicy@guiDuyet');
        Gate::define('post-trabai', 'App\Policies\Admins\AdminPostPolicy@traBai');
        Gate::define('post-duyet', 'App\Policies\Admins\AdminPostPolicy@duyet');

        Gate::define('post-list-self', 'App\Policies\Admins\AdminPostPolicy@listSelf');
    }

    public function defineGateSetting()
    {
        // module setting
        Gate::define('setting-list', 'App\Policies\Admins\AdminSettingPolicy@list');
        Gate::define('setting-add', 'App\Policies\Admins\AdminSettingPolicy@add');
        Gate::define('setting-edit', 'App\Policies\Admins\AdminSettingPolicy@edit');
        Gate::define('setting-delete', 'App\Policies\Admins\AdminSettingPolicy@delete');
    }

    public function defineGateUser()
    {
        // module user
        Gate::define('admin-user-list', 'App\Policies\Admins\AdminUserPolicy@list');
        Gate::define('admin-user-add', 'App\Policies\Admins\AdminUserPolicy@add');
        Gate::define('admin-user-edit', 'App\Policies\Admins\AdminUserPolicy@edit');
        Gate::define('admin-user-delete', 'App\Policies\Admins\AdminUserPolicy@delete');
    }

    public function defineGateUserFrontend()
    {
        // module user
        Gate::define('admin-user_frontend-list', 'App\Policies\Admins\AdminUserFrontendPolicy@list');
        Gate::define('admin-user_frontend-add', 'App\Policies\Admins\AdminUserFrontendPolicy@add');
        Gate::define('admin-user_frontend-edit', 'App\Policies\Admins\AdminUserFrontendPolicy@edit');
        Gate::define('admin-user_frontend-delete', 'App\Policies\Admins\AdminUserFrontendPolicy@delete');
        Gate::define('admin-user_frontend-active', 'App\Policies\Admins\AdminUserFrontendPolicy@active');
        Gate::define('admin-user_frontend-transfer-point', 'App\Policies\Admins\AdminUserFrontendPolicy@transferPoint');
        Gate::define('admin-user_frontend-nap', 'App\Policies\Admins\AdminUserFrontendPolicy@nap');
    }

    public function defineGateRole()
    {
        // module role
        Gate::define('role-list', 'App\Policies\Admins\AdminRolePolicy@list');
        Gate::define('role-add', 'App\Policies\Admins\AdminRolePolicy@add');
        Gate::define('role-edit', 'App\Policies\Admins\AdminRolePolicy@edit');
        Gate::define('role-delete', 'App\Policies\Admins\AdminRolePolicy@delete');
    }

    public function defineGatePermission()
    {
        // module permission
        Gate::define('permission-list', 'App\Policies\Admins\AdminPermissionPolicy@list');
        Gate::define('permission-add', 'App\Policies\Admins\AdminPermissionPolicy@add');
        Gate::define('permission-edit', 'App\Policies\Admins\AdminPermissionPolicy@edit');
        Gate::define('permission-delete', 'App\Policies\Admins\AdminPermissionPolicy@delete');
    }

    public function defineGatePay()
    {
        // module permission
        Gate::define('pay-list', 'App\Policies\Admins\AdminPayPolicy@list');
        Gate::define('pay-add', 'App\Policies\Admins\AdminPayPolicy@add');
        Gate::define('pay-edit', 'App\Policies\Admins\AdminPayPolicy@edit');
        Gate::define('pay-update-draw-point', 'App\Policies\Admins\AdminPayPolicy@payUpdateDrawPoint');
        Gate::define('pay-delete', 'App\Policies\Admins\AdminPayPolicy@delete');
        Gate::define('pay-export-excel', 'App\Policies\Admins\AdminPayPolicy@exportExcel');
    }

    public function defineGateBank()
    {
        // module menu

        Gate::define('bank-list', 'App\Policies\Admins\AdminBankPolicy@list');
        Gate::define('bank-add', 'App\Policies\Admins\AdminBankPolicy@add');
        Gate::define('bank-edit', 'App\Policies\Admins\AdminBankPolicy@edit');
        Gate::define('bank-delete', 'App\Policies\Admins\AdminBankPolicy@delete');
    }
    public function defineGateStore()
    {
        // module menu

        Gate::define('store-list', 'App\Policies\Admins\AdminStorePolicy@list');
        Gate::define('store-input', 'App\Policies\Admins\AdminStorePolicy@input');
        Gate::define('store-output', 'App\Policies\Admins\AdminStorePolicy@output');
        Gate::define('store-delete', 'App\Policies\Admins\AdminStorePolicy@delete');
    }
    public function defineGateTransaction()
    {
        Gate::define('transaction-list', 'App\Policies\Admins\AdminTransactionPolicy@list');
        Gate::define('transaction-status', 'App\Policies\Admins\AdminTransactionPolicy@status');
        Gate::define('transaction-delete', 'App\Policies\Admins\AdminTransactionPolicy@delete');
    }

    public function defineGateProgram()
    {
        // module product
        Gate::define('program-list', 'App\Policies\Admins\AdminProgramPolicy@list');
        Gate::define('program-add', 'App\Policies\Admins\AdminProgramPolicy@add');
        Gate::define('program-edit', 'App\Policies\Admins\AdminProgramPolicy@edit');
        Gate::define('program-delete', 'App\Policies\Admins\AdminProgramPolicy@delete');
    }

    public function defineGateCategoryProgram()
    {
        // module category_post
        Gate::define('category-program-list', 'App\Policies\Admins\AdminCategoryProgramPolicy@list');
        Gate::define('category-program-add',  'App\Policies\Admins\AdminCategoryProgramPolicy@add');
        Gate::define('category-program-edit',  'App\Policies\Admins\AdminCategoryProgramPolicy@edit');
        Gate::define('category-program-delete', 'App\Policies\Admins\AdminCategoryProgramPolicy@delete');
    }

    public function defineGateCategoryGalaxy()
    {
        // module category_galaxy
        Gate::define('category-galaxy-list', 'App\Policies\Admins\AdminCategoryGalaxyPolicy@list');
        Gate::define('category-galaxy-add',  'App\Policies\Admins\AdminCategoryGalaxyPolicy@add');
        Gate::define('category-galaxy-edit',  'App\Policies\Admins\AdminCategoryGalaxyPolicy@edit');
        Gate::define('category-galaxy-delete', 'App\Policies\Admins\AdminCategoryGalaxyPolicy@delete');
    }

    public function defineGateGalaxy()
    {
        // module post
        Gate::define('galaxy-list', 'App\Policies\Admins\AdminGalaxyPolicy@list');
        Gate::define('galaxy-add', 'App\Policies\Admins\AdminGalaxyPolicy@add');
        Gate::define('galaxy-edit', 'App\Policies\Admins\AdminGalaxyPolicy@edit');
        Gate::define('galaxy-delete', 'App\Policies\Admins\AdminGalaxyPolicy@delete');
    }

    public function defineGateCategoryExam()
    {
        // module category_exam
        Gate::define('category-exam-list', 'App\Policies\Admins\AdminCategoryExamPolicy@list');
        Gate::define('category-exam-add',  'App\Policies\Admins\AdminCategoryExamPolicy@add');
        Gate::define('category-exam-edit',  'App\Policies\Admins\AdminCategoryExamPolicy@edit');
        Gate::define('category-exam-delete', 'App\Policies\Admins\AdminCategoryExamPolicy@delete');
    }

    public function defineGateExam()
    {
        // module exam
        Gate::define('exam-list', 'App\Policies\Admins\AdminExamPolicy@list');
        Gate::define('exam-add', 'App\Policies\Admins\AdminExamPolicy@add');
        Gate::define('exam-edit', 'App\Policies\Admins\AdminExamPolicy@edit');
        Gate::define('exam-delete', 'App\Policies\Admins\AdminExamPolicy@delete');
    }

    public function defineGateAbout()
    {
        // module slider
        Gate::define('about-list', 'App\Policies\Admins\AdminAboutPolicy@list');
        Gate::define('about-add', 'App\Policies\Admins\AdminAboutPolicy@add');
        Gate::define('about-edit', 'App\Policies\Admins\AdminAboutPolicy@edit');
        Gate::define('about-delete', 'App\Policies\Admins\AdminAboutPolicy@delete');
    }
    public function defineGateView()
    {
        // module slider
        Gate::define('view-phong-vien', 'App\Policies\Admins\AdminViewPolicy@phongVien');
        Gate::define('view-bien-tap', 'App\Policies\Admins\AdminViewPolicy@bienTap');
        Gate::define('view-thu-ky', 'App\Policies\Admins\AdminViewPolicy@thuKy');
        Gate::define('view-pho-tong', 'App\Policies\Admins\AdminViewPolicy@phoTong');
        Gate::define('view-tong-bien-tap', 'App\Policies\Admins\AdminViewPolicy@tongBienTap');
    }

    public function defineGateOrderManagement()
    {
        Gate::define('order-management-list', 'App\Policies\Admins\AdminOrderManagementPolicy@list');
        Gate::define('order-management-delete', 'App\Policies\Admins\AdminOrderManagementPolicy@delete');
    }
}
