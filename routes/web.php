<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//\Artisan::call('storage:link');

// auth


Route::middleware(['language'])->group(function () {
    Auth::routes();
    Route::group(
        [
            'prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin']
        ],
        function () {
            UniSharp\LaravelFilemanager\Lfm::routes();
        }
    );
    Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
        Route::group(['prefix' => 'address'], function () {
            Route::get('district', 'AddressController@getDistricts')->name('ajax.address.districts');
            Route::get('communes', 'AddressController@getCommunes')->name('ajax.address.communes');
        });
    });
    // 'middleware' => ['auth', 'cartToggle']
    Route::group(['prefix' => 'cart'/*, 'middleware' => ['auth', 'cartToggle']*/], function () {
        Route::get('list', 'ShoppingCartController@list')->name('cart.list');
        Route::get('add/{id}', 'ShoppingCartController@add')->name('cart.add');
        Route::get('buy/{id}', 'ShoppingCartController@buy')->name('cart.buy');
        Route::get('remove/{id}', 'ShoppingCartController@remove')->name('cart.remove');
        Route::get('update/{id}', 'ShoppingCartController@update')->name('cart.update');
        Route::get('clear', 'ShoppingCartController@clear')->name('cart.clear');
        Route::post('order', 'ShoppingCartController@postOrder')->name('cart.order.submit');
        Route::get('order/sucess/{id}', 'ShoppingCartController@getOrderSuccess')->name('cart.order.sucess');
        Route::get('order/error', 'ShoppingCartController@getOrderError')->name('cart.order.error');
    });
    // compare product
    Route::group(['prefix' => 'compare'], function () {
        Route::get('/', 'CompareController@list')->name('compare.list');
        Route::get('add/{id}', 'CompareController@add')->name('compare.add');
        Route::get('add-redirect/{id}', 'CompareController@addAndRedirect')->name('compare.addAndRedirect');
        Route::get('remove/{id}', 'CompareController@remove')->name('compare.remove');
        Route::get('update/{id}', 'CompareController@update')->name('compare.update');
        Route::get('clear', 'CompareController@clear')->name('compare.clear');
    });



    Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
        Route::get('/', 'ProfileController@index')->name('profile.index');
        Route::get('/history', 'ProfileController@history')->name('profile.history');
        Route::get('/transaction-detail/{id}', "ProfileController@loadTransactionDetail")->name("profile.transaction.detail");
        Route::get('/list-rose', 'ProfileController@listRose')->name('profile.listRose');
        Route::get('/list-member', 'ProfileController@listMember')->name('profile.listMember');
        Route::get('/create-member', 'ProfileController@createMember')->name('profile.createMember');
        Route::post('/store-member', 'ProfileController@storeMember')->name('profile.storeMember');
        Route::post('/draw_point', 'ProfileController@drawPoint')->name('profile.drawPoint');

        Route::get('/edit-info', 'ProfileController@editInfo')->name('profile.editInfo');
        Route::post('/update-info/{id}', 'ProfileController@updateInfo')->name('profile.updateInfo')->middleware('profileOwnUser');

        Route::get('/manage-info', 'ProfileController@manageInfo')->name('profile.manageInfo');
        //  Route::get('{id}-{slug}', 'ProductController@detail')->name('product.detail');
        //  Route::get('/category-product/{id}-{slug}', 'ProductController@productByCategory')->name('product.productByCategory');
        Route::get('/change-password', 'ProfileController@changePassword')->name('update.password.get');
        Route::patch('/change-password', 'ProfileController@updatePassword')->name('update.password.post');
    });

    // tin tức
    Route::group(['prefix' => 'post'], function () {
        Route::get('/', 'PostController@index')->name('post.index');
        Route::get('{slug}', 'PostController@detail')->name('post.detail');
        Route::get('tag/{slug}', 'PostController@tag')->name('post.tag');

        //  Route::get('/category/{slug}', 'PostController@postByCategory')->name('post.postByCategory');
        Route::get('/view-file/{slug}', 'PostController@viewFile')->name('post.viewFile')->middleware('auth');
        Route::get('/download-file/{slug}', 'PostController@downloadFile')->name('post.downloadFile')->middleware('auth');
    });
    Route::group(['prefix' => 'post-category'], function () {
        Route::get('/{slug}', 'PostController@postByCategory')->name('post.postByCategory');
    });

    // sản phẩm
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', 'ProductController@index')->name('product.index');
        Route::get('{slug}', 'ProductController@detail')->name('product.detail');
        Route::get('download/{slug}', 'ProductController@download')->name('product.download');
    });
    Route::get('category/{slug}', 'ProductController@productByCategory')->name('product.productByCategory');

    // đề thi
    Route::group(['prefix' => 'exam'], function () {
        Route::get('/', 'ExamController@index')->name('exam.index');
        Route::get('{slug}', 'ExamController@detail')->name('exam.detail');
        Route::get('do/{slug}', 'ExamController@doExam')->name('exam.doExam')->middleware('auth');
        Route::get('result/{slug}', 'ExamController@resultExam')->name('exam.resultExam')->middleware('auth');
        Route::post('store-result/{slug}', 'ExamController@storeResultExam')->name('exam.storeResultExam')->middleware('auth');
        // Route::get('/category/{slug}', 'ExamController@postByCategory')->name('post.postByCategory');
    });
    Route::group(['prefix' => 'exam-category'], function () {
        Route::get('/{slug}', 'ExamController@examByCategory')->name('exam.examByCategory');
    });

    // chương trình
    Route::group(['prefix' => 'program'], function () {
        Route::get('/', 'ProgramController@index')->name('program.index');
        Route::get('{slug}', 'ProgramController@detail')->name('program.detail');
        Route::get('do/{slug}', 'ProgramController@doExercise')->name('program.doExercise');
        Route::get('result/{slug}', 'ProgramController@resultExercise')->name('program.resultExercise');
        Route::post('store-result/{slug}', 'ProgramController@storeResultExercise')->name('program.storeResultExercise');
        // Route::get('/category/{slug}', 'ExamController@postByCategory')->name('post.postByCategory');
    });
    Route::group(['prefix' => 'program-category'], function () {
        Route::get('/{slug}', 'ProgramController@programByCategory')->name('program.programByCategory');
    });

    // galaxy
    Route::group(['prefix' => 'video'], function () {
        Route::get('/', 'GalaxyController@index')->name('galaxy.index');
        Route::get('{slug}', 'GalaxyController@detail')->name('galaxy.detail');
    });
    Route::group(['prefix' => 'galaxy-category'], function () {
        Route::get('/{slug}', 'GalaxyController@galaxyByCategory')->name('galaxy.galaxyByCategory');
    });

    // galaxy
    Route::group(['prefix' => 'faq'], function () {
        Route::get('/', 'FaqController@index')->name('faq.index');
        Route::get('{slug}', 'FaqController@detail')->name('faq.detail');
    });
    Route::group(['prefix' => 'faq-category'], function () {
        Route::get('/{slug}', 'FaqController@faqByCategory')->name('faq.faqByCategory');
    });

    // home
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/change-language/{language}', 'LanguageController@index')->name('language.index');

    // giới thiệu
    Route::get('/gioi-thieu', 'HomeController@aboutUs')->name('about-us');
    Route::get('/about-us', 'HomeController@aboutUs')->name('about-us.en');
    Route::get('/설명하다', 'HomeController@aboutUs')->name('about-us.ko');

    // Sân Gold
    Route::get('/san-golf.html', 'HomeController@golfCourse')->name('golf-course');
    Route::get('/golf-course.html', 'HomeController@golfCourse')->name('golf-course.en');

    // Đặc điểm hố gold
    Route::get('/dac-diem-ho-golf.html', 'HomeController@featuresGolf')->name('features-golf');
    Route::get('/features-of-the-golf-hole.html', 'HomeController@featuresGolf')->name('features-golf.en');

    // Sân tập
    Route::get('/san-tap.html', 'HomeController@practicingField')->name('practicing-field');
    Route::get('/practicing-field.html', 'HomeController@practicingField')->name('practicing-field.en');

    // Học viện
    Route::get('/hoc-vien.html', 'HomeController@academy')->name('academy');
    Route::get('/academy.html', 'HomeController@academy')->name('academy.en');

    // báo giá
    Route::get('/bao-gia', 'HomeController@bao_gia')->name('bao-gia');
    Route::get('/quote', 'HomeController@bao_gia')->name('bao-gia.en');
    Route::get('/인용문', 'HomeController@bao_gia')->name('bao-gia.ko');

    // tuyển dụng
    Route::get('/tuyen-dung', 'HomeController@recruitment')->name('tuyen-dung');
    Route::get('/recruitment', 'HomeController@recruitment')->name('tuyen-dung.en');
    Route::get('/신병-모집', 'HomeController@recruitment')->name('tuyen-dung.ko');

    // chi tiết tuyển dụng
    Route::get('/tuyen-dung/{slug}', 'HomeController@tuyendungDetail')->name('tuyendung_link');
    Route::get('/recruitment/{slug}', 'HomeController@tuyendungDetail')->name('tuyendung_link.en');
    Route::get('/신병-모집/{slug}', 'HomeController@tuyendungDetail')->name('tuyendung_link.ko');



    // thông tin liên hệ
    Route::post('contact/store-ajax', 'ContactController@storeAjax')->name('contact.storeAjax');

    Route::get('/lien-he', 'ContactController@index')->name('contact.index');
    Route::get('/contact', 'ContactController@index')->name('contact.index.en');
    Route::get('/接触', 'ContactController@index')->name('contact.index.ko');

    Route::get('/phan-hoi', 'ContactController@feed_back')->name('feed_back.index');
    Route::get('/feedback', 'ContactController@feed_back')->name('feed_back.index.en');

    Route::get('/phan-anh', 'ContactController@feed_back2')->name('feed_back2.index');
    Route::get('/reflect', 'ContactController@feed_back2')->name('feed_back2.index.en');




    Route::group(['prefix' => 'comment'], function () {
        Route::post('/{type}/{id}', 'CommentController@store')->name('comment.store');
    });

    Route::group(['prefix' => 'search'], function () {
        Route::get('/', 'HomeController@search')->name('home.search');
        Route::get('/order', 'Frontend\SearchOrder\SearchOrderController@index')->name('search.index');
    });

    Route::group([
        'prefix' => 'order-management',
        'as'     => 'order_management.',
    ], function () {
        Route::get('/', 'Frontend\OrderManagement\OrderManagementController@index')->name('index');
        Route::get('/create', 'Frontend\OrderManagement\OrderManagementController@create')->name('create');
        Route::post('/create', 'Frontend\OrderManagement\OrderManagementController@store')->name('store');
        Route::get('/district/{city_id}', 'Ajax\AddressController@getDistricts');
        Route::get('/wards/{district_id}', 'Ajax\AddressController@getCommunes');
        Route::get('/shipping-fee/{val}', 'Frontend\OrderManagement\OrderManagementController@getShipping');
        Route::get('/delete-order-management/{id}', 'Frontend\OrderManagement\OrderManagementController@deleteOrderManage')->name('delete.order.manage');

        Route::get('/history', 'Frontend\OrderManagement\OrderManagementController@history')->name('history');
    });

    Route::group([
        'prefix' => 'csv-management',
        'as'     => 'csv_management.',
    ], function () {
        Route::get('/', 'Frontend\CsvManagement\CsvManagementController@index')->name('index');
        Route::get('/download-csv-order', 'Frontend\CsvManagement\CsvManagementController@downloadCsvOrder')->name('download.csv.order');
        Route::post('/import-csv-order', 'Frontend\CsvManagement\CsvManagementController@importCsvOrder')->name('import.csv.order');
        Route::get('/download-csv-product', 'Frontend\CsvManagement\CsvManagementController@downloadCsvProduct')->name('download.csv.product');
        Route::post('/import-csv-product', 'Frontend\CsvManagement\CsvManagementController@importCsvProduct')->name('import.csv.product');
        Route::get('/delete-csv-product/{id}', 'Frontend\CsvManagement\CsvManagementController@deleteCsvProduct')->name('delete.csv.product');
    });
});
