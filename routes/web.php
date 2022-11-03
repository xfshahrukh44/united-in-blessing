<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttributeGroupController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\Categories;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\CollectionProductController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\EmailSettingController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ManufacturerController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Admin\OptionsController;
use App\Http\Controllers\Admin\OptionValuesController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductLabelController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SellWatchController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShippingRateController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RemoveUserRequestController;
use App\Http\Controllers\UserBoardsController;
use App\Http\Controllers\UsernameController;
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

Route::get('/', function () {
    return view('index');
});

// username
Route::prefix('username')->group(function(){
    Route::get('forgot', [UsernameController::class, 'index'])->name('forgot.username');
    Route::post('request-change', [UsernameController::class, 'requestChange'])->name('request.username.change');
});

Auth::routes();

// Dashboard
Route::prefix('/')->middleware('auth')->group(function (){
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('update-profile', [ProfileController::class, 'update'])->name('profile.update');

    // Board Tree
    Route::get('board-tree/{board_id}', [BoardController::class, 'index'])->name('board.index');

    // Gifts
    Route::get('update-gift-status/{id}/{status}', [GiftController::class, 'update'])->name('update-gift-status');

    //Menu Pages
    Route::get('/how-it-works', [FrontController::class, 'howItWorks'])->name('front.work');

    Route::get('/guidelines', [FrontController::class, 'guidelines'])->name('front.guidelines');

    Route::get('/faq', [FrontController::class, 'faq'])->name('front.faq');

    Route::get('/privacy-statement', [FrontController::class, 'privacy_statement'])->name('front.privacy-statement');

    Route::get('/contact-us', [FrontController::class, 'contact'])->name('front.contact-us');

    Route::get('/gifting-forms', [FrontController::class, 'gifting_forms'])->name('front.gifting-forms');

});

// Admin Routes
Route::get('admin/login', function () {
    return view('admin.auth.login');
})->name('admin.login');

Route::namespace('Admin')->prefix('/admin')->middleware('admin')->group(function () {
    //Dashboard
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    //Boards
    Route::get('boards', [BoardController::class, 'boards'])->name('admin.boards.index');
    Route::get('board/create/form', [BoardController::class, 'createForm'])->name('admin.board.create.view');
    Route::get('board/previous-board-grad', [BoardController::class, 'previousBoardGrad'])->name('admin.board.previous-board-grad');
    Route::post('board/store/{amount?}/{previous_board_number?}', [BoardController::class, 'create'])->name('admin.board.store');
    Route::get('board/edit/{id}', [BoardController::class, 'edit'])->name('admin.board.edit');
    Route::post('board/update/{id}', [BoardController::class, 'update'])->name('admin.board.update');
    Route::delete('board/destroy/{id}', [BoardController::class, 'destroy'])->name('admin.board.destroy');

    // Board Members
    Route::get('board/members/{id}', [BoardController::class, 'boardMembers'])->name('admin.board.members');
    Route::post('board/members/update/{id}', [UserBoardsController::class, 'update'])->name('admin.update.board.members');
    Route::get('board/members/destroy/{board_id}/{user_id}', [UserBoardsController::class, 'destroy'])->name('admin.destroy.board.member');

    // Gifts
    Route::get('gifts', [GiftController::class, 'index'])->name('admin.gift.index');
    Route::get('gift/create', [GiftController::class, 'create'])->name('admin.gift.create');
    Route::get('gift/store', [GiftController::class, 'store'])->name('admin.gift.store');
    Route::get('gift/edit/{id}', [GiftController::class, 'edit'])->name('admin.gift.edit');
    Route::post('gift/update/{id}', [GiftController::class, 'update'])->name('admin.gift.update');
    Route::delete('gift/destroy/{id}', [GiftController::class, 'destroy'])->name('admin.gift.destroy');

    // Remove User Request
    Route::get('remove-user-request', [RemoveUserRequestController::class, 'index'])->name('admin.remove-user-request.index');
    Route::post('remove-user-request/update/{id}', [RemoveUserRequestController::class, 'update'])->name('admin.remove-user-request.update');

    // Reports
    Route::match(['get', 'post'],'generate-new-report', [ReportController::class, 'index'])->name('admin.report.index');
    Route::post('generatepdf', [ReportController::class, 'generatePDF'])->name('admin.generate-pdf-report');

    //category
    Route::get('category', [Categories::class, 'index'])->name('category');
    Route::match(['get', 'post'], '/add-category', [Categories::class, 'addCategory'])->name('admin.add-category');
    Route::match(['get', 'post'], '/category-edit/{id}', [Categories::class, 'edit'])->name('admin.edit-category');
    Route::get('/category-view/{id}', [Categories::class, 'show'])->name('category-view');
    Route::delete('category/destroy/{id}', [Categories::class, 'destroy']);

    //setting
    Route::match(['get', 'post'], '/settings', [SettingController::class, 'index'])->name('settings');

    //paymentGatway
    Route::match(['get', 'post'], '/paymentgatway', [PaymentGatewayController::class, 'index'])->name('paymentgatway');
    Route::match(['get', 'post'], '/emailsetting', [EmailSettingController::class, 'index'])->name('emailsetting');

    //PRODUCT
    Route::get('/getSubCategories', [ProductController::class, 'getSubCategories'])->name('getSubCategories');
    Route::get('/getOptionValues', [ProductController::class, 'getOptionValues'])->name('getOptionValues');
    Route::get('/checkProductSku', [ProductController::class, 'checkProductSku'])->name('checkProductSku');
    Route::get('/checkProductSlug', [ProductController::class, 'checkProductSlug'])->name('checkProductSlug');
    Route::get('product/changeProductStatus/{id}', [ProductController::class, 'changeProductStatus'])->name('changeProductStatus');
    Route::resource('product', '\App\Http\Controllers\Admin\ProductController');

    //LABELS
    Route::get('product/{id}/labels', [ProductLabelController::class, 'showLabels'])->name('show_labels');
    Route::post('product/{id}/labels', [ProductLabelController::class, 'store'])->name('store_label');
    Route::get('product/{id}/labels/{label_id}/edit', [ProductLabelController::class, 'edit'])->name('edit_label');
    Route::put('product/{id}/labels/{label_id}/edit', [ProductLabelController::class, 'update'])->name('update_label');
    Route::delete('product/{id}/labels/{label_id}/delete', [ProductLabelController::class, 'destroy'])->name('delete_label');

    //ORDER
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::get('order/changeOrderStatus/{id}', [OrderController::class, 'changeOrderStatus'])->name('order.changeOrderStatus');
    Route::get('order/orderdelete/{id}', [OrderController::class, 'orderdelete'])->name('order.orderdelete');
    Route::get('order-file-download/{file_name}', [OrderController::class, 'pdfDownload'])->name('order.file-download');


    //REVIEW
    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
    Route::get('/review/{id}', [ReviewController::class, 'show'])->name('review.show');
    Route::match(['get', 'post'], '/review/edit/{id}', [ReviewController::class, 'edit'])->name('review.edit');
    Route::delete('review/destroy/{id}', [ReviewController::class, 'destroy']);

    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
    Route::post('/faq/store', [FaqController::class, 'store'])->name('faq.store');
    Route::get('/faq/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
    Route::post('/faq/update/{id}', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('/faq/destroy/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');

    //SellWatch
    Route::get('/sellwatch', [SellWatchController::class, 'index'])->name('sellwatch.index');
    Route::get('/sellwatch/show/{id}', [SellWatchController::class, 'show'])->name('sellwatch.show');

    // testimonial
    Route::get('testimonial/changeBlogStatus/{id}', [TestimonialController::class, 'changeBlogStatus'])->name('changeBlogStatus');
    Route::get('/testimonial', [TestimonialController::class, 'index'])->name('testimonial.index');
    Route::get('/testimonial/create', [TestimonialController::class, 'create'])->name('testimonial.create');
    Route::post('/testimonial/store', [TestimonialController::class, 'store'])->name('testimonial.store');
    Route::get('/testimonial/edit/{id}', [TestimonialController::class, 'edit'])->name('testimonial.edit');
    Route::post('/testimonial/update/{id}', [TestimonialController::class, 'update'])->name('testimonial.update');
    Route::delete('/testimonial/destroy/{id}', [TestimonialController::class, 'destroy'])->name('testimonial.destroy');

    //Manufacturer
    Route::get('/manufacturer', [ManufacturerController::class, 'index'])->name('manufacturer.index');
    Route::match(['get', 'post'], '/manufacturer/create', [ManufacturerController::class, 'create'])->name('manufacturer.create');
    Route::get('/manufacturer/{id}', [ManufacturerController::class, 'show'])->name('manufacturer.show');
    Route::match(['get', 'post'], '/manufacturer/edit/{id}', [ManufacturerController::class, 'edit'])->name('manufacturer.edit');
    Route::post('/manufacturer/changeStatus/{id}', [ManufacturerController::class, 'changeStatus'])->name('manufacturer.changeStatus');
    Route::delete('/manufacturer/destroy/{id}', [ManufacturerController::class, 'destroy']);


    Route::resource('customers', '\App\Http\Controllers\Admin\CustomersController');
    Route::delete('/customers/destroy/{id}', [CustomersController::class, 'destroy'])->name('customers.destroy');

    Route::get('/catalog/attribute-groups', [AttributeGroupController::class, 'show'])->name('catalog.attributeGroups');
    Route::match(['get', 'post'], '/catalog/add-attribute-group', [AttributeGroupController::class, 'add'])->name('catalog.addAttributeGroup');
    Route::match(['get', 'post'], '/catalog/edit-attribute-group/{id}', [AttributeGroupController::class, 'edit'])->name('catalog.editAttributeGroup');
    Route::delete('/catalog/destroy-attribute-group/{id}', [AttributeGroupController::class, 'destroy'])->name('catalog.destroyAttributeGroup');

    Route::get('/catalog/attributes', [AttributeGroupController::class, 'show'])->name('catalog.attributes');
    Route::match(['get', 'post'], '/catalog/add-attribute', [AttributeGroupController::class, 'add'])->name('catalog.addAttributes');
    Route::match(['get', 'post'], '/catalog/edit-attribute/{id}', [AttributeGroupController::class, 'edit'])->name('catalog.editAttribute');
    Route::delete('/catalog/destroy-attribute/{id}', [AttributeGroupController::class, 'destroy'])->name('catalog.destroyAttribute');

    Route::get('/catalog/options', [OptionsController::class, 'show'])->name('catalog.options');
    Route::match(['get', 'post'], '/catalog/add-option', [OptionsController::class, 'add'])->name('catalog.addOption');
    Route::match(['get', 'post'], '/catalog/edit-option/{id}', [OptionsController::class, 'edit'])->name('catalog.editOption');
    Route::delete('/catalog/destroy-option/{id}', [OptionsController::class, 'destroy'])->name('catalog.destroyOption');

    Route::get('/catalog/option-values', [OptionValuesController::class, 'show'])->name('catalog.optionValues');
    Route::match(['get', 'post'], '/catalog/add-option-value', [OptionValuesController::class, 'add'])->name('catalog.addOptionValue');
    Route::match(['get', 'post'], '/catalog/edit-option-value/{id}', [OptionValuesController::class, 'edit'])->name('catalog.editOptionValue');
    Route::delete('/catalog/destroy-option-value/{id}', [OptionValuesController::class, 'destroy'])->name('catalog.destroyOptionValue');


    //NewsLetter
    Route::get('/newsletter', [NewsLetterController::class, 'index'])->name('newsletter.index');
    Route::post('/newsletter/edit/{id}', [NewsLetterController::class, 'edit'])->name('newsletter.edit');
    Route::delete('/newsletter/destroy/{id}', [NewsLetterController::class, 'destroy']);
    Route::get('/sendnewsletter', [NewsLetterController::class, 'sendNewsLetter'])->name('sendnewsletter');
    Route::post('/sendnewsletteremail', [NewsLetterController::class, 'sendNewsLetterEmail'])->name('sendnewsletteremail');
    //Route::delete('customers/delete/{id}','CustomersController@destroy');

    //Shipping Rate
    Route::get('/shipping', [ShippingRateController::class, 'index'])->name('shipping.index');
    Route::match(['get', 'post'], '/shipping/create', [ShippingRateController::class, 'create'])->name('shipping.create');
    Route::get('/shipping/{id}', [ShippingRateController::class, 'show'])->name('shipping.show');
    Route::match(['get', 'post'], '/shipping/edit/{id}', [ShippingRateController::class, 'edit'])->name('shipping.edit');
    Route::post('/shipping/changeStatus/{id}', [ShippingRateController::class, 'changeStatus'])->name('shipping.changeStatus');
    Route::delete('/shipping/destroy/{id}', [ShippingRateController::class, 'destroy']);

    //Blogs
    Route::get('blog/changeBlogStatus/{id}', [BlogController::class, 'changeBlogStatus'])->name('changeBlogStatus');
    Route::resource('blog', '\App\Http\Controllers\Admin\BlogController');

    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::match(['get', 'post'], '/coupon/create', [CouponController::class, 'create'])->name('coupons.create');
    Route::get('/coupon/{id}', [CouponController::class, 'show'])->name('coupons.show');
    Route::match(['get', 'post'], '/coupon/edit/{id}', [CouponController::class, 'edit'])->name('coupons.edit');
    Route::post('/coupons/changeStatus/{id}', [CouponController::class, 'changeStatus'])->name('coupons.changeStatus');
    Route::delete('/coupons/destroy/{id}', [CouponController::class, 'destroy'])->name('coupon.destroy');

    //    Collection
    Route::delete('/collection/destroy/{id}', [CollectionController::class, 'destroy']);
    Route::resource('collection', '\App\Http\Controllers\Admin\CollectionController');

    //Collection Products
    Route::get('/collectionProducts', [CollectionProductController::class, 'index'])->name('collectionProducts.index');
    Route::get('/collectionProducts/create', [CollectionProductController::class, 'create'])->name('collectionProducts.create');
    Route::post('/collectionProducts/store', [CollectionProductController::class, 'store'])->name('collectionProducts.store');
    Route::get('/collectionProducts/edit/{id}', [CollectionProductController::class, 'edit'])->name('collectionProducts.edit');
    Route::post('/collectionProducts/update/{id}', [CollectionProductController::class, 'update'])->name('collectionProducts.update');
    Route::get('/collectionProducts/show/{id}', [CollectionProductController::class, 'show'])->name('collectionProducts.show');
    Route::delete('/collectionProducts/destroy/{id}', [CollectionProductController::class, 'destroy']);
    //
    route::get('/changePassword', [SettingController::class, 'changePassword']);
    route::post('/updateAdminPassword', [SettingController::class, 'updateAdminPassword']);

    /*  Shipping Services   */
    Route::match(['get', 'post'], 'shipping-services', [\App\Http\Controllers\Admin\ShippingServiceController::class, 'index'])->name('shippingServices');
});
