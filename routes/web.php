<?php

use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\OrderAreaController;
use App\Http\Controllers\Panel\AdvisedController;
use App\Http\Controllers\Panel\BrandController;
use App\Http\Controllers\Panel\BusinessSettingController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\ChildCategoryController;
use App\Http\Controllers\Panel\CouponController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\HomeSettingController;
use App\Http\Controllers\Panel\OrderController;
use App\Http\Controllers\Panel\PageController;
use App\Http\Controllers\Panel\ProductController;

use App\Http\Controllers\Panel\PromoController;
use App\Http\Controllers\Panel\SliderController;
use App\Http\Controllers\Panel\SubCategoryController;
use App\Http\Controllers\Panel\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

Route::controller(HomeController::class)->name('frontend.')->group(function(){
    Route::get('/', 'home')->name('home');
    Route::get('/cart-details', 'cartDetails')->name('cartDetails');
    Route::get('/fetch-top-categories', 'fetchTopCategories')->name('fetchTopCategories');
    Route::get('/fetch-featured-categories', 'fetchFeaturedCategories')->name('fetchFeaturedCategories');

    Route::get('/get-setting', 'getSettings')->name('getSettings');
    Route::get('/get-footer-setting', 'getFooterSettings')->name('getFooterSettings');
    Route::get('/get-header-menu', 'getHeaderMenu')->name('getHeaderMenu');
    Route::get('/pages/{slug?}', 'pageView');


    Route::get('/category/{slug}', 'showSubCategories')->name('showSubCategories');
    Route::get('/sub-category/{slug}', 'showChildCategories')->name('showChildCategories');
    Route::get('/child-category/{slug}', 'showChildCategoriesProducts')->name('showChildCategoriesProducts');
});

Route::controller(App\Http\Controllers\Frontend\ProductController::class)->name('product.')->group(function(){
//    Route::get('/{cat_slug?}/{sub_cat_slug?}/{child_cat_slug?}', 'products')->name('categoryProducts');
    Route::get('/products', 'products')->name('products');
    Route::get('/product/single-product/{slug}', 'singleProduct')->name('singleProduct');
    Route::post('/product/single-product/{slug}', 'singleProductWithDiscount')->name('singleProduct');
    Route::get('/products/ads-products', 'adsProducts')->name('adsProducts');


    Route::get('/latest-offers', 'latestOffers')->name('latestOffers');

});

Route::middleware('customer')->group(function(){
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/save-to-checkout', [CheckoutController::class, 'addCheckout'])->name('addCheckout');

    Route::post('/apply-coupon-code', [CheckoutController::class, 'applyCoupon'])->name('applyCoupon');


    Route::get('/select-payment', [PaymentController::class, 'payment'])->name('payment');

    Route::post('/make-payment', [PaymentController::class, 'makePayment'])->name('makePayment');
    Route::get('/make-payment', [PaymentController::class, 'orderComplete'])->name('orderComplete');

    Route::post('/update-user-profile', [CustomerController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-user-credentials', [CustomerController::class, 'updatePassword'])->name('updatePassword');

    ROute::get('/customer/orders', [CustomerController::class, 'customerOrders'])->name('customerOrders');
    Route::get('/single-order/{id}', [CustomerController::class,'singleOrder'])->name('singleOrder');
    Route::get('print-invoice/{id}', [CustomerController::class, 'printInvoice'])->name('printInvoice');

    ROute::get('/customer/profile', [CustomerController::class, 'customerProfile'])->name('customerProfile');
    Route::post('/update-profile-image', [CustomerController::class, 'updateProfileImage'])->name('updateProfileImage');

    Route::get("/given-password", [CustomerController::class, 'gotoGivenPassword'])->name('gotoGivenPassword');
    Route::post('/set-password', [CustomerController::class, 'setPassword'])->name('setPassword');

    Route::get('/customer/change-password', [CustomerController::class, 'changePassword'])->name('changePassword');


    Route::get("/get-user-date", [CustomerController::class, 'getCustomerInfo'])->name('getCustomerInfo');

    Route::get('/customer/address', [CustomerController::class, 'customerAddress'])->name('createAddress');
    Route::post('/customer/add-address', [CustomerController::class, 'addAddress'])->name('addAddress');
    Route::delete('/customer/add-address/{id}', [CustomerController::class, 'deleteAddress'])->name('deleteAddress');
    Route::put('/customer/add-address/{id}', [CustomerController::class, 'updateAddress'])->name('updateAddress');


    Route::get('/customer/wishlist', [CustomerController::class, 'wishlist'])->name('wishlist');


});

Route::prefix('customer')->name('customer.')->middleware( 'guest')->group(function (){
    Route::get('login', [CustomerController::class, 'login'])->name('login');
    Route::post('login', [CustomerController::class, 'checkLogin'])->name('checkLogin');
    Route::get('/verify', [CustomerController::class, 'verifyOtp'])->name('verifyOtp');
    Route::post('/check-verify', [CustomerController::class, 'checkVerifyOtp'])->name('checkVerifyOtp');

    Route::get('/register-verification', [CustomerController::class, 'regVerificationOtp'])->name('regVerificationOtp');
    Route::post('registration', [CustomerController::class, 'checkRegistration'])->name('checkRegistration');
    Route::get('/resend-verify-code', [CustomerController::class , 'resendVerifyCode'])->name('resendVerifyCode');
});


Route::middleware('guest')->group(function (){
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
});

Route::any('logout', [LoginController::class, 'destroy'])->middleware('auth');

// admin routes
Route::prefix('panel')->name('admin.')->middleware(['auth','web', 'admin'])->group(function(){
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    // categories
    Route::resource('category', CategoryController::class);
    Route::post('/category/update-with-files/{id}', [CategoryController::class, 'update']);
    Route::get('/category/make-featured/{id}', [CategoryController::class, 'makeFeatured'])->name('makeFeatured');

    Route::resource('sub-category', SubCategoryController::class);
    Route::resource('child-category', ChildCategoryController::class);
    Route::post('/child-category/update-with-files/{id}', [ChildCategoryController::class, 'update']);



    Route::post('/sub-category/update/{id}', [SubCategoryController::class, 'update'])->name('update');

    //brands
    Route::resource('brand',BrandController::class);
    Route::post('/brand/update-with-files/{id}', [BrandController::class, 'update']);

    // test products
    Route::controller(ProductController::class)->name('product.')->group(function (){
        Route::get('products', 'index')->name('index');
        Route::get('product/create', 'create')->name('create');
        Route::get('products/{slug}', 'edit')->name('edit');
        Route::post('products/{slug}', 'update')->name('update');
        Route::post('product/store', 'store')->name('store');
        Route::delete('products/{id}', 'destroy')->name('destroy');
    });

    // customer orders
    Route::controller(OrderController::class)->name('order.')->group(function(){
        Route::get('/orders', 'index')->name('index');
        Route::get('/change-order-status/{id}', 'changeOrderStatus')->name('changeOrderStatus');
        Route::get('/change-payment-status/{id}', 'changePaymentStatus')->name('changePaymentStatus');
        Route::get('/single-order/{id}', 'singleOrder')->name('singleOrder');
        Route::get('print-invoice/{id}', 'printInvoice')->name('printInvoice');
    });

    // order area
    Route::resource('order-area', OrderAreaController::class);


    // coupon discount
    Route::resource('coupon', CouponController::class);
    Route::post('coupon/activation/{id}', [CouponController::class, 'activation'])->name('published_mocktest');


    // manage users
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // manage banners
    Route::get('/promo', [PromoController::class, 'promos'])->name('promos');
    Route::post('/save-promo', [PromoController::class, 'savePromo'])->name('savePromo');

    // sliders controller
    Route::resource('slider', SliderController::class);
    Route::post('/delete-slider/{id}', [SliderController::class, 'deleteSlider']);


    // manage ads
    Route::get('all-advised', [AdvisedController::class, 'allAdvisedIndex'])->name('allAdvisedIndex');
    Route::get('advised', [AdvisedController::class, 'advisedIndex'])->name('advisedIndex');
    Route::get('advised/{id}', [AdvisedController::class, 'advisedEdit'])->name('advisedEdit');
    Route::post('advised-post', [AdvisedController::class, 'uploadAds'])->name('uploadAds');
    Route::post('advised-post/{id}', [AdvisedController::class, 'updateAds'])->name('uploadAds');
    Route::delete('advised/{id}', [AdvisedController::class, 'deleteAdvised'])->name('advisedDelete');

    Route::resource('pages', PageController::class);
    Route::post('/pages/update/{id}', [PageController::class, 'updatePage'])->name('pages.updatePage');


    // manage settings
    Route::get('/settings', [BusinessSettingController::class, 'index'])->name('businessIndex');
    Route::post('/settings', [BusinessSettingController::class, 'updateSetting'])->name('businessSave');

    // home page settings
    Route::get('home-page-settings', [HomeSettingController::class, 'homePageSettings'])->name('homePageSettings');
    Route::get('footer-settings', [HomeSettingController::class, 'footerSettings'])->name('footerSettings');

    // smtp settings
    Route::post('mail-setup', [BusinessSettingController::class, 'updateSmtp'])->name('updateSmtp');

    // admin profile
    Route::get('/my-profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/update-admin-profile', [CustomerController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-admin-credentials', [CustomerController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/update-profile-image', [CustomerController::class, 'updateProfileImage'])->name('updateProfileImage');
});


Route::fallback(function (){
    return inertia('Error');
});



Route::get('/clear', function (){
   Artisan::call('optimize:clear');
   return dd("clear");
});
Route::get('/storage', function (){
    Artisan::call('storage:link');
    return dd("linked");
});
