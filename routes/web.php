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
use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\User;
use App\Models\UserBoards;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Faker\Factory as Faker;

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
})->name('index')->middleware('guest');

// username
Route::prefix('username')->group(function(){
    Route::get('forgot', [UsernameController::class, 'index'])->name('forgot.username');
    Route::post('request-change', [UsernameController::class, 'requestChange'])->name('request.username.change');
});

Auth::routes();

// User Dashboard
Route::prefix('/')->middleware('auth')->group(function (){
    // Board Tree
    Route::get('board-tree/{board_id}', [BoardController::class, 'index'])->name('board.index');

    Route::get('auto-fill-board/{board_id}', [BoardController::class, 'autoFillBoard'])->name('board.autoFillBoard');
});

// User Dashboard while restricting admin to visit these pages
Route::prefix('/')->middleware(['auth', 'user'])->group(function (){
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('update-profile', [ProfileController::class, 'update'])->name('profile.update');

    // Gifts
    Route::get('update-gift-status/{id}/{status}', [GiftController::class, 'update'])->name('update-gift-status');
    Route::get('accept-all-gifts', [GiftController::class, 'acceptAllGifts'])->name('acceptAllGifts');

    // Gifting Form
    Route::get('/gifting-forms', [FrontController::class, 'gifting_forms'])->name('front.gifting-forms');
    Route::post('/send-gifting-form', [FrontController::class, 'sendGiftingForm'])->name('send-gifting-form');

    //Menu Pages
    Route::get('/how-it-works', [FrontController::class, 'howItWorks'])->name('front.work');
    Route::get('/guidelines', [FrontController::class, 'guidelines'])->name('front.guidelines');
    Route::get('/faq', [FrontController::class, 'faq'])->name('front.faq');
    Route::get('/privacy-statement', [FrontController::class, 'privacy_statement'])->name('front.privacy-statement');
    Route::get('/contact-us', [FrontController::class, 'contact'])->name('front.contact-us');

});

// Admin Routes
Route::get('admin/login', [AdminController::class, 'login'])->middleware('guest')->name('admin.login');

Route::namespace('Admin')->prefix('/admin')->middleware('admin')->group(function () {
    //Dashboard
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('user/create/{id?}', [UserController::class, 'create'])->name('user.create');
    Route::get('user/show/{user}', [UserController::class, 'show'])->name('user.show');
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
    Route::match(['get', 'post'], 'gift-range-report', [ReportController::class, 'giftRangeReport'])->name('admin.gift.range.report');
    Route::post('generatepdf', [ReportController::class, 'generatePDF'])->name('admin.generate-pdf-report');
    Route::post('generate-range-pdf', [ReportController::class, 'generateRangePDF'])->name('admin.generate-range-pdf-report');
    Route::get('all-reports', [ReportController::class, 'allReports'])->name('admin.all-reports');

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

Route::get('temp', function () {
//    $board_21_id = '5e423c7b-0674-4244-88c6-345d09f65686';
//    $board_11_id = '57396d97-8d81-4900-98ce-69bde72579e9';
//    $u8_id = '51290ac7-8939-4b42-8c45-40c2b80ef32c';
//    $u61_id = 'fa2e09bd-b712-4da1-b2d0-d5135fc1b84c';
//    $u63_id = '00e59752-e250-4cf9-8f95-d766cb851be5';
//    $u31_id = 'd551adfc-7425-4951-a661-0eae7c283507';
//
//    //Board Number: 21 - Undergrad U8 will get replace by U61
//    UserBoards::where([ 'board_id' => $board_21_id, 'user_id' => $u8_id ])->firstOrFail()->update([
//        'user_id' => $u61_id
//    ]);
//    GiftLogs::where([ 'board_id' => $board_21_id, 'sent_by' => $u61_id ])->firstOrFail()->update([
//        'status' => 'accepted'
//    ]);
//
//    //Board Number: 21 - Newbies:  will create two newbies U69 and U70 and it will take the place of U61
//    $faker = Faker::create();
//    $u69_id = User::create([ 'invited_by' => $u63_id, 'username' => 'U69', 'first_name' => 'User', 'last_name' => '69', 'email' => $faker->unique()->email, 'phone' => $faker->phoneNumber, 'role' => 'user', 'password' => Hash::make('Pa$$w0rd!') ])->id;
//    $u70_id = User::create([ 'invited_by' => $u63_id, 'username' => 'U70', 'first_name' => 'User', 'last_name' => '70', 'email' => $faker->unique()->email, 'phone' => $faker->phoneNumber, 'role' => 'user', 'password' => Hash::make('Pa$$w0rd!') ])->id;
//    generateUserProfileLogs($u69_id, 'username', 'U69', 0, 'New Account Created', 'accepted');
//    generateUserProfileLogs($u70_id, 'username', 'U70', 0, 'New Account Created', 'accepted');
//    generateUserProfileLogs($u69_id, 'password', 'Pa$$w0rd!', 0, 'New Account Created', 'accepted');
//    generateUserProfileLogs($u70_id, 'password', 'Pa$$w0rd!', 0, 'New Account Created', 'accepted');
//
//    UserBoards::where([ 'board_id' => $board_21_id, 'user_id' => $u61_id, 'position' => 'left' ])->firstOrFail()->update([
//        'user_id' => $u69_id
//    ]);
//    UserBoards::where([ 'board_id' => $board_21_id, 'user_id' => $u61_id, 'position' => 'right' ])->firstOrFail()->update([
//        'user_id' => $u70_id
//    ]);
//    GiftLogs::where([ 'board_id' => $board_21_id, 'sent_by' => $u61_id ])->firstOrFail()->update([
//        'sent_by' => $u69_id,
//        'status' => 'pending'
//    ]);
//    GiftLogs::where([ 'board_id' => $board_21_id, 'sent_by' => $u61_id ])->firstOrFail()->update([
//        'sent_by' => $u70_id,
//        'status' => 'pending'
//    ]);
//
//    //Board Number: 11 - Newbies: U8 will replace with U61
//    UserBoards::where([ 'board_id' => $board_11_id, 'user_id' => $u8_id, 'parent_id' => $u31_id ])->firstOrFail()->update([
//        'user_id' => $u61_id
//    ]);
//    GiftLogs::where([ 'board_id' => $board_11_id, 'sent_by' => $u8_id ])->firstOrFail()->update([
//        'sent_by' => $u61_id,
//        'status' => 'pending',
//    ]);

//    -----------------------------------------------------------------------------------------------------------------------------
//    21-09-23 task: delete user U65-U80
//    $users_to_purge = [
//        'fe92dfc0-97eb-4ad7-be99-f300f5d27cf1', //U65
//        '9d69e563-b503-4e67-8dac-9ae15d4862ef', //U66
//        '017e2cfa-5b22-4182-888f-8a858c5f8767', //U67
//        '08cc097f-4de9-446b-b7e0-d23f467f5034', //U68
//        'f98f8a7f-1861-4439-8168-8f8e59821416', //U69
//        '9628b484-2cef-4887-b0e6-ef1637826d26', //U70
//        '5926da42-3fd0-4e02-aa67-325470d69180', //U71
//        'cf9514cb-14c3-48d4-a44e-8871a7528841', //U72
//        '6960fc30-a57c-496d-a116-ecc117b5c2b7', //U73
//        'ec993ecb-927c-46d4-9951-2bbfceae04cd', //U74
//        '06a86888-3fc1-487c-9c1b-24a304ab4879', //U75
//        '5f38645b-5eb9-46f7-9df0-809ba07d805d', //U76
//        '59efabc9-d4ec-4018-b685-c83a34d83ed6', //U77
//        'a3d3b49c-b4e7-4617-ab12-f3ee590c46e0', //U78
//        '9b21c31c-ce30-46a0-a550-694aa749862f', //U79
//        'e685d8e7-7300-46b2-a427-09660118851d', //U80
//    ];
//    foreach ($users_to_purge as $user_to_purge) {
//        purge_user($user_to_purge);
//    }
//
//    $boards_to_purge = [
//        '24d917ad-f889-4d6e-bdad-252bd7762d0a', //board 23
//        'fb510846-375a-4d74-a944-d178e1f6fca6', //board 24
//        '501fbfd9-755d-4667-b4b7-968592039606', //board 25
//        '65fcb1f4-c15b-402c-b9b0-38a4a4f8e360', //board 26
//    ];
//    foreach ($boards_to_purge as $board_to_purge) {
//        purge_board($board_to_purge);
//    }
//    //update board 21 status
//    Boards::where('id', '5e423c7b-0674-4244-88c6-345d09f65686')->update([ 'status' => 'active' ]);
    //    -----------------------------------------------------------------------------------------------------------------------------
})->name('temp');
