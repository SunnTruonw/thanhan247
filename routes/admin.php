<?php

use Illuminate\Support\Facades\Route;

Route::get('admin/login', "Auth\AdminLoginController@showLoginForm")->name("admin.login");
Route::post('admin/logout', "Auth\AdminLoginController@logout")->name("admin.logout");
Route::post('admin/login', "Auth\AdminLoginController@login")->name("admin.login.submit");

Route::get('admin/password/confirm', 'Auth\AdminConfirmPasswordController@showConfirmForm')->name('admin.password.confirm');
Route::get('admin/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');





Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {
    // Route::get('/', function () {
    //     return view("admin.master.main");
    // });

    Route::get('/', "AdminHomeController@index")->name("admin.index");

    // Route::get('login', "AdminController@getLoginAdmin")->name("admin.getLoginAdmin");
    // Route::post('login', "AdminController@postLoginAdmin")->name("admin.postLoginAdmin");

    Route::group(['prefix' => 'ajax'], function () {
    });

    Route::get('/load-order/{table}/{id}', "AdminHomeController@loadOrderVeryModel")->name("admin.loadOrderVeryModel");
    //  Route::get('/lang-cr', "AdminCategoryProductController@langCr");
    Route::group(['prefix' => 'categoryproduct'], function () {
        Route::get('/', "AdminCategoryProductController@index")->name("admin.categoryproduct.index")->middleware(['can:category-product-list']);
        Route::get('/create', "AdminCategoryProductController@create")->name("admin.categoryproduct.create")->middleware('can:category-product-add');
        Route::post('/store', "AdminCategoryProductController@store")->name("admin.categoryproduct.store")->middleware('can:category-product-add');
        Route::get('/edit/{id}', "AdminCategoryProductController@edit")->name("admin.categoryproduct.edit")->middleware('can:category-product-edit');
        Route::post('/update/{id}', "AdminCategoryProductController@update")->name("admin.categoryproduct.update")->middleware('can:category-product-edit');
        Route::get('/destroy/{id}', "AdminCategoryProductController@destroy")->name("admin.categoryproduct.destroy")->middleware('can:category-product-delete');
        Route::post('/export/excel/database', "AdminCategoryProductController@excelExportDatabase")->name("admin.categoryproduct.export.excel.database");
        Route::post('/import/excel/database', "AdminCategoryProductController@excelImportDatabase")->name("admin.categoryproduct.import.excel.database");
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', "AdminProductController@index")->name("admin.product.index")->middleware('can:product-list');
        Route::get('/create', "AdminProductController@create")->name("admin.product.create")->middleware('can:product-add');
        Route::post('/store', "AdminProductController@store")->name("admin.product.store")->middleware('can:product-add');
        Route::get('/edit/{id}', "AdminProductController@edit")->name("admin.product.edit")->middleware('can:product-edit');
        Route::post('/update/{id}', "AdminProductController@update")->name("admin.product.update")->middleware('can:product-edit');
        Route::get('/destroy/{id}', "AdminProductController@destroy")->name("admin.product.destroy")->middleware('can:product-delete');
        Route::get('/update-active/{id}', "AdminProductController@loadActive")->name("admin.product.load.active")->middleware('can:product-edit');
        Route::get('/update-hot/{id}', "AdminProductController@loadHot")->name("admin.product.load.hot")->middleware('can:product-edit');
        Route::get('/delete-image/{id}', "AdminProductController@destroyProductImage")->name("admin.product.destroy-image")->middleware('can:product-edit');
        Route::get('/export/excel/database', "AdminProductController@excelExportDatabase")->name("admin.product.export.excel.database");
        Route::post('/import/excel/database', "AdminProductController@excelImportDatabase")->name("admin.product.import.excel.database");

        Route::get('/destroy-file/{id}/{field}', "AdminProductController@destroyFile")->name("admin.product.destroyFile")->middleware('can:product-edit');
    });

    Route::group(['prefix' => 'categorypost'], function () {
        Route::get('/', "AdminCategoryPostController@index")->name("admin.categorypost.index")->middleware('can:category-post-list');
        Route::get('/create', "AdminCategoryPostController@create")->name("admin.categorypost.create")->middleware('can:category-post-add');
        Route::post('/store', "AdminCategoryPostController@store")->name("admin.categorypost.store")->middleware('can:category-post-add');
        Route::get('/edit/{id}', "AdminCategoryPostController@edit")->name("admin.categorypost.edit")->middleware('can:category-post-edit');
        Route::post('/update/{id}', "AdminCategoryPostController@update")->name("admin.categorypost.update")->middleware('can:category-post-edit');
        Route::get('/destroy/{id}', "AdminCategoryPostController@destroy")->name("admin.categorypost.destroy")->middleware('can:category-post-delete');
        Route::post('/export/excel/database', "AdminCategoryPostController@excelExportDatabase")->name("admin.categorypost.export.excel.database");
        Route::post('/import/excel/database', "AdminCategoryPostController@excelImportDatabase")->name("admin.categorypost.import.excel.database");

        // đoạn văn
        Route::get('load-paragraph-category-post', "AdminCategoryPostController@loadParagraphCategoryPost")->name("admin.categorypost.loadParagraphCategoryPost");
        Route::get('/load-edit-paragraph-category-post/{id}', "AdminCategoryPostController@loadEditParagraphCategoryPost")->name("admin.categorypost.loadEditParagraphCategoryPost");
        Route::get('/load-create-paragraph-category-post/{id}', "AdminCategoryPostController@loadCreateParagraphCategoryPost")->name("admin.categorypost.loadCreateParagraphCategoryPost");
        Route::get('/load-parent-paragraph-category-post/{id}', "AdminCategoryPostController@loadParentParagraphCategoryPost")->name("admin.categorypost.loadParentParagraphCategoryPost");
        Route::post('/store-paragraph-category-post/{id}', "AdminCategoryPostController@storeParagraphCategoryPost")->name("admin.categorypost.storeParagraphCategoryPost");
        Route::post('/update-paragraph-category-post/{id}', "AdminCategoryPostController@updateParagraphCategoryPost")->name("admin.categorypost.updateParagraphCategoryPost");
        Route::get('/delete-paragraph-category-post/{id}', "AdminCategoryPostController@destroyParagraphCategoryPost")->name("admin.categorypost.destroyParagraphCategoryPost");
    });
    Route::group(['prefix' => 'post'], function () {
        Route::get('/', "AdminPostController@index")->name("admin.post.index")->middleware('can:post-list');
        Route::get('/list-self', "AdminPostController@listSelf")->name("admin.post.listSelf")->middleware('can:post-list-self');
        Route::get('/create', "AdminPostController@create")->name("admin.post.create")->middleware('can:post-add');
        Route::post('/store', "AdminPostController@store")->name("admin.post.store")->middleware('can:post-add');
        Route::get('/edit/{id}', "AdminPostController@edit")->name("admin.post.edit")->middleware('can:post-edit,id');
        Route::post('/update/{id}', "AdminPostController@update")->name("admin.post.update")->middleware('can:post-edit,id');
        Route::get('/destroy/{id}', "AdminPostController@destroy")->name("admin.post.destroy")->middleware('can:post-delete');

        Route::get('/destroy-file/{id}/{field}', "AdminPostController@destroyFile")->name("admin.post.destroyFile")->middleware('can:post-edit');

        Route::get('/update-active/{id}', "AdminPostController@loadActive")->name("admin.post.load.active")->middleware('can:post-active');
        Route::get('/update-hot/{id}', "AdminPostController@loadHot")->name("admin.post.load.hot")->middleware('can:post-hot');
        // guwir duyet
        Route::get('/gui-duyet/{id}', "AdminPostController@guiDuyet")->name("admin.post.guiDuyet")->middleware('can:post-send-duyet');
        Route::get('/tra-bai/{id}', "AdminPostController@traBai")->name("admin.post.traBai")->middleware('can:post-trabai');
        // duyệt bài
        Route::get('/duyet/{id}', "AdminPostController@duyet")->name("admin.post.duyet")->middleware('can:post-duyet');
        Route::post('/export/excel/database', "AdminPostController@excelExportDatabase")->name("admin.post.export.excel.database");
        Route::post('/import/excel/database', "AdminPostController@excelImportDatabase")->name("admin.post.import.excel.database");

        // đoạn văn
        Route::get('load-paragraph-post', "AdminPostController@loadParagraphPost")->name("admin.post.loadParagraphPost");
        Route::get('/load-edit-paragraph-post/{id}', "AdminPostController@loadEditParagraphPost")->name("admin.post.loadEditParagraphPost");
        Route::get('/load-create-paragraph-post/{id}', "AdminPostController@loadCreateParagraphPost")->name("admin.post.loadCreateParagraphPost");
        Route::get('/load-parent-paragraph-post/{id}', "AdminPostController@loadParentParagraphPost")->name("admin.post.loadParentParagraphPost");
        Route::post('/store-paragraph-post/{id}', "AdminPostController@storeParagraphPost")->name("admin.post.storeParagraphPost");
        Route::post('/update-paragraph-post/{id}', "AdminPostController@updateParagraphPost")->name("admin.post.updateParagraphPost");
        Route::get('/delete-paragraph-post/{id}', "AdminPostController@destroyParagraphPost")->name("admin.post.destroyParagraphPost");
    });
    // galaxy
    Route::group(['prefix' => 'categorygalaxy'], function () {
        Route::get('/', "AdminCategoryGalaxyController@index")->name("admin.categorygalaxy.index")->middleware('can:category-galaxy-list');
        Route::get('/create', "AdminCategoryGalaxyController@create")->name("admin.categorygalaxy.create")->middleware('can:category-galaxy-add');
        Route::post('/store', "AdminCategoryGalaxyController@store")->name("admin.categorygalaxy.store")->middleware('can:category-galaxy-add');
        Route::get('/edit/{id}', "AdminCategoryGalaxyController@edit")->name("admin.categorygalaxy.edit")->middleware('can:category-galaxy-edit');
        Route::post('/update/{id}', "AdminCategoryGalaxyController@update")->name("admin.categorygalaxy.update")->middleware('can:category-galaxy-edit');
        Route::get('/destroy/{id}', "AdminCategoryGalaxyController@destroy")->name("admin.categorygalaxy.destroy")->middleware('can:category-galaxy-delete');
    });

    Route::group(['prefix' => 'galaxy'], function () {
        Route::get('/', "AdminGalaxyController@index")->name("admin.galaxy.index")->middleware('can:galaxy-list');
        Route::get('/create', "AdminGalaxyController@create")->name("admin.galaxy.create")->middleware('can:galaxy-add');
        Route::post('/store', "AdminGalaxyController@store")->name("admin.galaxy.store")->middleware('can:galaxy-add');
        Route::get('/edit/{id}', "AdminGalaxyController@edit")->name("admin.galaxy.edit")->middleware('can:galaxy-edit');
        Route::post('/update/{id}', "AdminGalaxyController@update")->name("admin.galaxy.update")->middleware('can:galaxy-edit');
        Route::get('/destroy/{id}', "AdminGalaxyController@destroy")->name("admin.galaxy.destroy")->middleware('can:galaxy-delete');
        Route::get('/update-active/{id}', "AdminGalaxyController@loadActive")->name("admin.galaxy.load.active")->middleware('can:galaxy-edit');
        Route::get('/update-hot/{id}', "AdminGalaxyController@loadHot")->name("admin.galaxy.load.hot")->middleware('can:galaxy-edit');
    });

    // exam
    Route::group(['prefix' => 'categoryexam'], function () {
        Route::get('/', "AdminCategoryExamController@index")->name("admin.categoryexam.index")->middleware('can:category-exam-list');
        Route::get('/create', "AdminCategoryExamController@create")->name("admin.categoryexam.create")->middleware('can:category-exam-add');
        Route::post('/store', "AdminCategoryExamController@store")->name("admin.categoryexam.store")->middleware('can:category-exam-add');
        Route::get('/edit/{id}', "AdminCategoryExamController@edit")->name("admin.categoryexam.edit")->middleware('can:category-exam-edit');
        Route::post('/update/{id}', "AdminCategoryExamController@update")->name("admin.categoryexam.update")->middleware('can:category-exam-edit');
        Route::get('/destroy/{id}', "AdminCategoryExamController@destroy")->name("admin.categoryexam.destroy")->middleware('can:category-exam-delete');
    });

    Route::group(['prefix' => 'exam'], function () {
        Route::get('/', "AdminExamController@index")->name("admin.exam.index")->middleware('can:exam-list');
        Route::get('/create', "AdminExamController@create")->name("admin.exam.create")->middleware('can:exam-add');
        Route::post('/store', "AdminExamController@store")->name("admin.exam.store")->middleware('can:exam-add');
        Route::get('/edit/{id}', "AdminExamController@edit")->name("admin.exam.edit")->middleware('can:exam-edit');
        Route::get('/show/{id}', "AdminExamController@show")->name("admin.exam.show")->middleware('can:exam-edit');
        Route::post('/update/{id}', "AdminExamController@update")->name("admin.exam.update")->middleware('can:exam-edit');
        Route::get('/destroy/{id}', "AdminExamController@destroy")->name("admin.exam.destroy")->middleware('can:exam-delete');
        Route::get('/update-active/{id}', "AdminExamController@loadActive")->name("admin.exam.load.active")->middleware('can:exam-edit');
        Route::get('/update-hot/{id}', "AdminExamController@loadHot")->name("admin.exam.load.hot")->middleware('can:exam-edit');

        // xử lý caau hoir thi
        Route::get('/load-create-question/{id}', "AdminExamController@loadCreateQuestion")->name("admin.exam.loadCreateQuestion");
        Route::get('/load-create-question-answer', "AdminExamController@loadCreateQuestionAnswer")->name("admin.exam.loadCreateQuestionAnswer");
        Route::get('/load-edit-question/{id}', "AdminExamController@loadEditQuestion")->name("admin.exam.loadEditQuestion");
        Route::post('/update-question/{id}', "AdminExamController@updateQuestion")->name("admin.exam.updateQuestion");

        Route::post('/store-question/{id}', "AdminExamController@storeQuestion")->name("admin.exam.storeQuestion");
        Route::get('/delete-question/{id}', "AdminExamController@destroyQuestion")->name("admin.exam.destroyQuestion");
        Route::get('/delete-answer/{id}', "AdminExamController@destroyAnswer")->name("admin.exam.destroyAnswer");
        Route::get('/edit-answer/{id}', "AdminExamController@loadEditAnswer")->name("admin.exam.loadEditAnswer");
        Route::post('/update-question-answer/{id}', "AdminExamController@updateQuestionAnswer")->name("admin.exam.updateQuestionAnswer");
        Route::get('/load-create-now-question-answer/{id}', "AdminExamController@loadCreateNowQuestionAnswer")->name("admin.exam.loadCreateNowQuestionAnswer");
        Route::post('/store-question-answer/{id}', "AdminExamController@storeQuestionAnswer")->name("admin.exam.storeQuestionAnswer");
    });

    Route::group(['prefix' => 'menu'], function () {
        Route::get('/', "AdminMenuController@index")->name("admin.menu.index")->middleware('can:menu-list');
        Route::get('/create', "AdminMenuController@create")->name("admin.menu.create")->middleware('can:menu-add');
        Route::post('/store', "AdminMenuController@store")->name("admin.menu.store")->middleware('can:menu-add');
        Route::get('/edit/{id}', "AdminMenuController@edit")->name("admin.menu.edit")->middleware('can:menu-edit');
        Route::post('/update/{id}', "AdminMenuController@update")->name("admin.menu.update")->middleware('can:menu-edit');
        Route::get('/destroy/{id}', "AdminMenuController@destroy")->name("admin.menu.destroy")->middleware('can:menu-delete');
    });

    Route::group(['prefix' => 'attribute'], function () {
        Route::get('/', "AdminAttributeController@index")->name("admin.attribute.index")->middleware('can:product-list');
        Route::get('/create', "AdminAttributeController@create")->name("admin.attribute.create")->middleware('can:product-add');
        Route::post('/store', "AdminAttributeController@store")->name("admin.attribute.store")->middleware('can:product-add');
        Route::get('/edit/{id}', "AdminAttributeController@edit")->name("admin.attribute.edit")->middleware('can:product-edit');
        Route::post('/update/{id}', "AdminAttributeController@update")->name("admin.attribute.update")->middleware('can:product-edit');
        Route::get('/destroy/{id}', "AdminAttributeController@destroy")->name("admin.attribute.destroy")->middleware('can:product-delete');
    });
    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', "AdminSupplierController@index")->name("admin.supplier.index")->middleware('can:product-list');
        Route::get('/create', "AdminSupplierController@create")->name("admin.supplier.create")->middleware('can:product-add');
        Route::post('/store', "AdminSupplierController@store")->name("admin.supplier.store")->middleware('can:product-add');
        Route::get('/edit/{id}', "AdminSupplierController@edit")->name("admin.supplier.edit")->middleware('can:product-edit');
        Route::post('/update/{id}', "AdminSupplierController@update")->name("admin.supplier.update")->middleware('can:product-edit');
        Route::get('/destroy/{id}', "AdminSupplierController@destroy")->name("admin.supplier.destroy")->middleware('can:product-delete');
        Route::get('/update-active/{id}', "AdminSupplierController@loadActive")->name("admin.supplier.load.active")->middleware('can:product-edit');
    });


    Route::group(['prefix' => 'slider'], function () {
        Route::get('/', "AdminSliderController@index")->name("admin.slider.index")/*->middleware('can:slider-list')*/;
        Route::get('/create', "AdminSliderController@create")->name("admin.slider.create")/*->middleware('can:slider-add')*/;
        Route::post('/store', "AdminSliderController@store")->name("admin.slider.store")/*->middleware('can:slider-add')*/;
        Route::get('/edit/{id}', "AdminSliderController@edit")->name("admin.slider.edit")/*->middleware('can:slider-edit')*/;
        Route::post('/update/{id}', "AdminSliderController@update")->name("admin.slider.update")/*->middleware('can:slider-edit')*/;
        Route::get('/destroy/{id}', "AdminSliderController@destroy")->name("admin.slider.destroy")/*->middleware('can:slider-delete')*/;
        Route::get('/update-active/{id}', "AdminSliderController@loadActive")->name("admin.slider.load.active")/*->middleware('can:slider-edit')*/;
    });
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/', "AdminSettingController@index")->name("admin.setting.index")->middleware('can:setting-list');
        Route::get('/create', "AdminSettingController@create")->name("admin.setting.create")->middleware('can:setting-add');
        Route::post('/store', "AdminSettingController@store")->name("admin.setting.store")->middleware('can:setting-add');
        Route::get('/edit/{id}', "AdminSettingController@edit")->name("admin.setting.edit")->middleware('can:setting-edit');
        Route::post('/update/{id}', "AdminSettingController@update")->name("admin.setting.update")->middleware('can:setting-edit');
        Route::get('/delete-file/{id}/{field}', "AdminSettingController@deleteFile")->name("admin.setting.deleteFile")->middleware('can:setting-edit');
        Route::get('/destroy/{id}', "AdminSettingController@destroy")->name("admin.setting.destroy")->middleware('can:setting-delete');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', "AdminUserController@index")->name("admin.user.index")->middleware('can:admin-user-list');
        Route::get('/create', "AdminUserController@create")->name("admin.user.create")->middleware('can:admin-user-add');
        Route::post('/store', "AdminUserController@store")->name("admin.user.store")->middleware('can:admin-user-add');
        Route::get('/edit/{id}', "AdminUserController@edit")->name("admin.user.edit")->middleware('can:admin-user-edit');
        Route::post('/update/{id}', "AdminUserController@update")->name("admin.user.update")->middleware('can:admin-user-edit');
        Route::get('/destroy/{id}', "AdminUserController@destroy")->name("admin.user.destroy")->middleware('can:admin-user-delete');
    });

    Route::group(['prefix' => 'user-frontend'], function () {
        Route::get('/', "AdminUserFrontendController@index")->name("admin.user_frontend.index")->middleware('can:admin-user_frontend-list');
        //  Route::get('/list-no-active', "AdminUserFrontendController@listNoActive")->name("admin.user_frontend.listNoActive")->middleware('can:admin-user_frontend-list');
        Route::get('/detail/{id}', "AdminUserFrontendController@detail")->name("admin.user_frontend.detail")->middleware('can:admin-user_frontend-list');
        Route::get('/create', "AdminUserFrontendController@create")->name("admin.user_frontend.create")->middleware('can:admin-user_frontend-add');
        Route::post('/store', "AdminUserFrontendController@store")->name("admin.user_frontend.store")->middleware('can:admin-user_frontend-add');
        Route::get('/update-active/{id}', "AdminUserFrontendController@loadActive")->name("admin.user_frontend.load.active")->middleware('can:admin-user_frontend-active');
        Route::get('/update-active-key/{id}', "AdminUserFrontendController@loadActiveKey")->name("admin.user_frontend.load.active-key")->middleware('can:admin-user_frontend-active');
        Route::get('/load-detail/{id}', "AdminUserFrontendController@loadUserDetail")->name("admin.user_frontend.loadUserDetail")->middleware('can:admin-user_frontend-list');
        Route::get('/transfer-point/{id}', "AdminUserFrontendController@transferPoint")->name("admin.user_frontend.transferPoint")->middleware('can:admin-user_frontend-transfer-point');
        Route::get('/transfer-point-between', "AdminUserFrontendController@transferPointBetweenXY")->name("admin.user_frontend.transferPointBetweenXY")->middleware('can:admin-user_frontend-transfer-point');
        Route::get('/transfer-point-random', "AdminUserFrontendController@transferPointRandom")->name("admin.user_frontend.transferPointRandom")->middleware('can:admin-user_frontend-transfer-point');
        Route::get('/edit/{id}', "AdminUserFrontendController@edit")->name("admin.user_frontend.edit")->middleware('can:admin-user_frontend-edit');
        Route::post('/update/{id}', "AdminUserFrontendController@update")->name("admin.user_frontend.update")->middleware('can:admin-user_frontend-edit');
        Route::get('/destroy/{id}', "AdminUserFrontendController@destroy")->name("admin.user_frontend.destroy")->middleware('can:admin-user_frontend-delete');

        Route::post('/nap/{id}', "AdminUserFrontendController@nap")->name("admin.user_frontend.nap")->middleware('can:admin-user_frontend-nap');
        Route::get('/history-point', "AdminUserFrontendController@historyPoint")->name("admin.user_frontend.historyPoint")->middleware('can:admin-user_frontend-nap');

        //Delete 
        Route::get('delete/{id}', "AdminUserFrontendController@destroy")->name('admin.user_frontend.destroy');
        Route::delete('delete-multiple-user', "OrderManagementController@deleteMultiple")->name('user-frontend.multiple-delete');
    });
    Route::post('/filter-ajax', 'AdminUserFrontendController@filter_ajax')->name('admin.user_frontend.filter_ajax');

    Route::group(['prefix' => 'pay'], function () {
        Route::get('/', "AdminPayController@index")->name("admin.pay.index")->middleware('can:pay-list');
        Route::get('/update-draw-point', "AdminPayController@updateDrawPoint")->name("admin.pay.updateDrawPoint")->middleware('can:pay-update-draw-point');
        Route::get('/update-draw-point-all', "AdminPayController@updateDrawPointAll")->name("admin.pay.updateDrawPointAll")->middleware('can:pay-update-draw-point');
        Route::post('/export/excel/database', "AdminPayController@excelExportDatabase")->name("admin.pay.export.excel.database")->middleware('can:pay-export-excel');
    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('/', "AdminRoleController@index")->name("admin.role.index")->middleware('can:role-list');
        Route::get('/create', "AdminRoleController@create")->name("admin.role.create")->middleware('can:role-add');
        Route::post('/store', "AdminRoleController@store")->name("admin.role.store")->middleware('can:role-add');
        Route::get('/edit/{id}', "AdminRoleController@edit")->name("admin.role.edit")->middleware('can:role-edit');
        Route::post('/update/{id}', "AdminRoleController@update")->name("admin.role.update")->middleware('can:role-edit');
        Route::get('/destroy/{id}', "AdminRoleController@destroy")->name("admin.role.destroy")->middleware('can:role-delete');
    });
    Route::group(['prefix' => 'permission'], function () {
        Route::get('/', "AdminPermissionController@index")->name("admin.permission.index")->middleware('can:permission-list');
        Route::get('/create', "AdminPermissionController@create")->name("admin.permission.create")->middleware('can:permission-add');
        Route::post('/store', "AdminPermissionController@store")->name("admin.permission.store")->middleware('can:permission-add');
        Route::get('/edit/{id}', "AdminPermissionController@edit")->name("admin.permission.edit")->middleware('can:permission-edit');
        Route::post('/update/{id}', "AdminPermissionController@update")->name("admin.permission.update")->middleware('can:permission-edit');
        Route::get('/destroy/{id}', "AdminPermissionController@destroy")->name("admin.permission.destroy")->middleware('can:permission-delete');
    });

    Route::group(['prefix' => 'categoryprogram'], function () {
        Route::get('/', "AdminCategoryProgramController@index")->name("admin.categoryprogram.index")->middleware('can:category-program-list');
        Route::get('/create', "AdminCategoryProgramController@create")->name("admin.categoryprogram.create")->middleware('can:category-program-add');
        Route::post('/store', "AdminCategoryProgramController@store")->name("admin.categoryprogram.store")->middleware('can:category-program-add');
        Route::get('/edit/{id}', "AdminCategoryProgramController@edit")->name("admin.categoryprogram.edit")->middleware('can:category-program-edit');
        Route::post('/update/{id}', "AdminCategoryProgramController@update")->name("admin.categoryprogram.update")->middleware('can:category-program-edit');
        Route::get('/update-active/{id}', "AdminCategoryProgramController@loadActive")->name("admin.categoryprogram.load.active")->middleware('can:category-program-edit');
        Route::get('/destroy/{id}', "AdminCategoryProgramController@destroy")->name("admin.categoryprogram.destroy")->middleware('can:category-program-delete');
        Route::post('/export/excel/database', "AdminCategoryProgramController@excelExportDatabase")->name("admin.categoryprogram.export.excel.database");
        Route::post('/import/excel/database', "AdminCategoryProgramController@excelImportDatabase")->name("admin.categoryprogram.import.excel.database");
    });
    Route::group(['prefix' => 'program'], function () {
        Route::get('/', "AdminProgramController@index")->name("admin.program.index")->middleware('can:program-list');
        Route::get('/create', "AdminProgramController@create")->name("admin.program.create")->middleware('can:program-add');
        Route::post('/store', "AdminProgramController@store")->name("admin.program.store")->middleware('can:program-add');
        Route::get('/edit/{id}', "AdminProgramController@edit")->name("admin.program.edit")->middleware('can:program-edit');
        Route::post('/update/{id}', "AdminProgramController@update")->name("admin.program.update")->middleware('can:program-edit');
        Route::get('/destroy/{id}', "AdminProgramController@destroy")->name("admin.program.destroy")->middleware('can:program-delete');
        Route::get('/update-active/{id}', "AdminProgramController@loadActive")->name("admin.program.load.active")->middleware('can:program-edit');
        Route::get('/update-hot/{id}', "AdminProgramController@loadHot")->name("admin.program.load.hot")->middleware('can:program-edit');
        Route::post('/export/excel/database', "AdminProgramController@excelExportDatabase")->name("admin.program.export.excel.database");
        Route::post('/import/excel/database', "AdminProgramController@excelImportDatabase")->name("admin.program.import.excel.database");

        // đoạn văn
        Route::get('load-paragraph-program', "AdminProgramController@loadParagraphProgram")->name("admin.program.loadParagraphProgram");
        Route::get('/load-edit-paragraph-program/{id}', "AdminProgramController@loadEditParagraphProgram")->name("admin.program.loadEditParagraphProgram");
        Route::get('/load-create-paragraph-program/{id}', "AdminProgramController@loadCreateParagraphProgram")->name("admin.program.loadCreateParagraphProgram");
        Route::get('/load-parent-paragraph-program/{id}', "AdminProgramController@loadParentParagraphProgram")->name("admin.program.loadParentParagraphProgram");
        Route::post('/store-paragraph-program/{id}', "AdminProgramController@storeParagraphProgram")->name("admin.program.storeParagraphProgram");
        Route::post('/update-paragraph-program/{id}', "AdminProgramController@updateParagraphProgram")->name("admin.program.updateParagraphProgram");
        Route::get('/delete-paragraph-program/{id}', "AdminProgramController@destroyParagraphProgram")->name("admin.program.destroyParagraphProgram");

        // xử lý bài tập
        Route::get('/load-create-exercise/{id}', "AdminProgramController@loadCreateExercise")->name("admin.program.loadCreateExercise");
        Route::get('/load-create-exercise-answer', "AdminProgramController@loadCreateExerciseAnswer")->name("admin.program.loadCreateExerciseAnswer");
        Route::get('/load-edit-exercise/{id}', "AdminProgramController@loadEditExercise")->name("admin.program.loadEditExercise");
        Route::post('/update-exercise/{id}', "AdminProgramController@updateExercise")->name("admin.program.updateExercise");

        Route::post('/store-exercise/{id}', "AdminProgramController@storeExercise")->name("admin.program.storeExercise");
        Route::get('/delete-exercise/{id}', "AdminProgramController@destroyExercise")->name("admin.program.destroyExercise");
        Route::get('/delete-answer/{id}', "AdminProgramController@destroyAnswer")->name("admin.program.destroyAnswer");
        Route::get('/edit-answer/{id}', "AdminProgramController@loadEditAnswer")->name("admin.program.loadEditAnswer");
        Route::post('/update-exercise-answer/{id}', "AdminProgramController@updateExerciseAnswer")->name("admin.program.updateExerciseAnswer");
        Route::get('/load-create-now-exercise-answer/{id}', "AdminProgramController@loadCreateNowExerciseAnswer")->name("admin.program.loadCreateNowExerciseAnswer");
        Route::post('/store-exercise-answer/{id}', "AdminProgramController@storeExerciseAnswer")->name("admin.program.storeExerciseAnswer");
    });

    Route::group(['prefix' => 'bank'], function () {
        Route::get('/', "AdminBankController@index")->name("admin.bank.index")->middleware('can:bank-list');
        Route::get('/create', "AdminBankController@create")->name("admin.bank.create")->middleware('can:bank-add');
        Route::post('/store', "AdminBankController@store")->name("admin.bank.store")->middleware('can:bank-add');
        Route::get('/edit/{id}', "AdminBankController@edit")->name("admin.bank.edit")->middleware('can:bank-edit');
        Route::post('/update/{id}', "AdminBankController@update")->name("admin.bank.update")->middleware('can:bank-edit');
        Route::get('/destroy/{id}', "AdminBankController@destroy")->name("admin.bank.destroy")->middleware('can:bank-delete');
    });
    Route::group(['prefix' => 'store'], function () {
        Route::get('/', "AdminStoreController@index")->name("admin.store.index")->middleware('can:store-list');
        Route::get('/create', "AdminStoreController@create")->name("admin.store.create")->middleware('can:store-input');
        Route::post('/store', "AdminStoreController@store")->name("admin.store.store")->middleware('can:store-input');
        Route::get('/edit/{id}', "AdminStoreController@edit")->name("admin.store.edit")->middleware('can:store-edit');
        Route::post('/update/{id}', "AdminStoreController@update")->name("admin.store.update")->middleware('can:store-edit');
        Route::get('/destroy/{id}', "AdminStoreController@destroy")->name("admin.store.destroy")->middleware('can:store-delete');
    });

    Route::group(['prefix' => 'transaction'], function () {
        Route::get('status-next/{id}', "AdminTransactionController@loadNextStepStatus")->name("admin.transaction.loadNextStepStatus")->middleware('can:transaction-status');
        Route::get('/', "AdminTransactionController@index")->name("admin.transaction.index")->middleware('can:transaction-list');
        Route::get('/show/{id}', "AdminTransactionController@show")->name("admin.transaction.show")->middleware('can:transaction-list');
        Route::get('/destroy/{id}', "AdminTransactionController@destroy")->name("admin.transaction.destroy")->middleware('can:transaction-delete');
        Route::get('/update-thanhtoan/{id}', "AdminTransactionController@loadThanhtoan")->name("admin.product.load.thanhtoan")->middleware('can:transaction-list');
        Route::get('/transaction-detail/{id}', "AdminTransactionController@loadTransactionDetail")->name("admin.transaction.detail")->middleware('can:transaction-list');
        Route::get('/transaction-detail/export/pdf/{id}', "AdminTransactionController@exportPdfTransactionDetail")->name("admin.transaction.detail.export.pdf");
    });


    Route::group(['prefix' => 'contact'], function () {
        Route::get('status-next/{id}', "AdminContactController@loadNextStepStatus")->name("admin.contact.loadNextStepStatus");
        Route::get('/', "AdminContactController@index")->name("admin.contact.index");
        Route::get('/show/{id}', "AdminContactController@show")->name("admin.contact.show");
        Route::get('/destroy/{id}', "AdminContactController@destroy")->name("admin.contact.destroy");
        Route::get('/contact-detail/{id}', "AdminContactController@loadContactDetail")->name("admin.contact.detail");
    });

    Route::group(['prefix' => 'about'], function () {
        Route::get('/', "AdminAboutController@index")->name("admin.about.index")->middleware('can:about-list');
        Route::get('/create', "AdminAboutController@create")->name("admin.about.create")->middleware('can:about-add');
        Route::post('/store', "AdminAboutController@store")->name("admin.about.store")->middleware('can:about-add');
        Route::get('/edit/{id}', "AdminAboutController@edit")->name("admin.about.edit")->middleware('can:about-edit');
        Route::post('/update/{id}', "AdminAboutController@update")->name("admin.about.update")->middleware('can:about-edit');
        Route::get('/destroy/{id}', "AdminAboutController@destroy")->name("admin.about.destroy")->middleware('can:about-delete');
    });

    Route::group([
        'prefix' => 'order-management',
        'as'     => 'admin.order_management.'
    ], function () {
        Route::get('/', "OrderManagement\OrderManagementController@index")->name("index");
        Route::get('/show/{id}', "OrderManagement\OrderManagementController@show")->name("show");
        Route::get('/edit/{id}', "OrderManagement\OrderManagementController@edit")->name("edit");
        Route::put('/update-order/{id}', "OrderManagement\OrderManagementController@updateOrderManagement")->name("update-order_management");
        Route::put('/update/{id}', "OrderManagement\OrderManagementController@update")->name("update");
        Route::put('/update/shipper/{id}', "OrderManagement\OrderManagementController@updateShipper")->name("update.shipper");
        Route::put('/update/total-shipper/{id}', "OrderManagement\OrderManagementController@updateTotalShipper")->name("update.total-shipper");
        Route::put('/update/total-code/{id}', "OrderManagement\OrderManagementController@updateTotalCode")->name("update.total-code");
        Route::put('/update/address-customer/{id}', "OrderManagement\OrderManagementController@updateAddressCustomer")->name("update.address-customer");
        Route::put('/update/refund/{id}', "OrderManagement\OrderManagementController@updateRefund")->name("update.refund");
        Route::put('/update/debt/{id}', "OrderManagement\OrderManagementController@updateDebt")->name("update.debt");
        Route::delete('/destroy/{id}', "OrderManagement\OrderManagementController@destroy")->name("destroy");

        Route::get('/update-status-order/{id}', "OrderManagement\OrderManagementController@loadStatusOrder")->name("load.status-order");

        Route::get('/update-status-order-ship/{id}', "OrderManagement\OrderManagementController@loadStatusOrderShip")->name("load.status-order-ship");
    });

    Route::group([
        'prefix' => 'csv-management',
        'as'     => 'admin.csv-management.'
    ], function () {
        Route::get('/', "CsvManagement\CsvManagementController@index")->name("index");
        Route::get('/show/{id}', "CsvManagement\CsvManagementController@show")->name("show");
        Route::get('/status-next/{id}', "CsvManagement\CsvManagementController@update")->name("update");
        Route::delete('/destroy/{id}', "CsvManagement\CsvManagementController@destroy")->name("destroy");
    });

    Route::post('delete-multiple', "OrderManagement\OrderManagementController@deleteMultiple")->name('multiple_order_delete');
    Route::group([
        'prefix' => 'shipper',
        'as'     => 'admin.shipper.'
    ], function () {
        Route::get('/', 'Shipper\ShipperController@index')->name('index');
        Route::get('/create', 'Shipper\ShipperController@create')->name('create');
        Route::post('/create', 'Shipper\ShipperController@store')->name('store');
        Route::get('/edit/{id}', 'Shipper\ShipperController@edit')->name('edit');
        Route::put('/update/{id}', 'Shipper\ShipperController@update')->name('update');
        Route::delete('/destroy/{id}', 'Shipper\ShipperController@destroy')->name('destroy');
    });
});
