<?php

use App\Http\Controllers\Frontend\{
    CartController,
    ContactController,
    IndexController,
    WishlistController,
    LayananfixController
};

use App\Http\Controllers\{
    DashboardController,
    UserOrderController
};

use App\Http\Controllers\Admin\{
    AdminBahanController,
    AdminBrandController,
    AdminCategoryController,
    AdminCustomOrderController,
    AdminDataUserController,
    AdminLayananController,
    AdminOngkirController,
    AdminOrderController,
    AdminProductController,
    AdminSliderController,
    AdminSubCategoryController,
    AdminSubSubCategoryController,
    StatisticPenjualanController,
    AdminProfileController,
    LaporanPenjualanController
};
use App\Http\Controllers\Owner\OwnerOrderController;
use App\Http\Controllers\User\CartPageController;
use App\Http\Controllers\User\UserCheckoutController;
use App\Http\Controllers\User\UserCustomOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Role Owner
    Route::group(['middleware' => ['role:owner']], function () {
        Route::controller(OwnerOrderController::class)->prefix('owner')->as('owner.orders.')->group(function () {
            Route::get('/orders/data', 'data')->name('data');
            Route::get('/orders', 'index')->name('index');
        });
        
        Route::controller(StatisticPenjualanController::class)->prefix('owner')->as('owner.statistic.')->group(function () {
            Route::get('/', 'index')->name('index');
        });

    });

    // Role Admin
    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('admin')->as('admin.')->group(function () {
            // Route : Layanan
            Route::controller(AdminLayananController::class)->prefix('layanan')->as('layanan.')->group(function () {
                Route::get('/data', 'data')->name('data');
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::get('/detail/{id}', 'detail')->name('detail');
            });

            // Route : Brand
            Route::controller(AdminBrandController::class)->prefix('brands')->as('brands.')->group(function () {
                Route::get('/data', 'data')->name('data');
                Route::get('/search', 'brandSearch')->name('brandSearch');
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

            // Route : Bahan
            Route::controller(AdminBahanController::class)->prefix('bahan')->as('bahan.')->group(function () {
                Route::get('/data', 'data')->name('data');
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

            // Route : Ongkir
            Route::controller(AdminOngkirController::class)->prefix('ongkir')->as('ongkir.')->group(function () {
                Route::get('/data', 'data')->name('data');
                Route::get('/search/province', 'provinceSearch')->name('provinceSearch');
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

            // Route : Category
            Route::controller(AdminCategoryController::class)->prefix('category')->as('category.')->group(function () {
                Route::get('/data', 'data')->name('data');
                Route::get('/search', 'categorySearch')->name('categorySearch');
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

            // Route : SubCategory
            Route::controller(AdminSubCategoryController::class)->prefix('subcategory')->as('subcategory.')->group(function () {
                Route::get('/data', 'data')->name('data');
                Route::get('/{id}/search', 'subCategorySearch')->name('subCategorySearch');
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

            // Route : SubSubCategory
            Route::controller(AdminSubSubCategoryController::class)->prefix('subsubcategory')->as('subsubcategory.')->group(function () {
                Route::get('/data', 'data')->name('data');
                Route::get('/{id}/search', 'subSubCategorySearch')->name('subSubCategorySearch');
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

            // Route : Product
            Route::controller(AdminProductController::class)->prefix('products')->as('products.')->group(function () {
                Route::get('/data', 'data')->name('data');
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::get('/detail/{id}', 'detail')->name('detail');
            });

            // Route : Slider
            Route::controller(AdminSliderController::class)->prefix('slider')->as('slider.')->group(function () {
                Route::get('/data', 'data')->name('data');
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

            // Route : Order
            Route::post('/orders/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
            Route::controller(AdminOrderController::class)->prefix('orders')->as('orders.')->group(function () {
                Route::get('/data', 'data')->name('data');
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::get('/detail/{id}', 'detail')->name('detail');
                Route::get('/invoice/{id}/download', 'download')->name('download');
            });

            // Route : CustomOrder
            Route::put('/customorders/{id}/update-status', [AdminCustomOrderController::class, 'updateStatus'])->name('admin.customorders.updateStatus');
            Route::controller(AdminCustomOrderController::class)->prefix('customorders')->as('customorders.')->group(function () {
                Route::get('/data', 'data')->name('data');
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::get('/detail/{id}', 'detail')->name('detail');
                Route::get('/invoice/{id}/download', 'download')->name('download');
                Route::get('/download-design/{id}', 'downloadDesign')->name('download.design');
            });

            Route::controller(StatisticPenjualanController::class)->prefix('statistic')->as('statistic.')->group(function () {
                Route::get('/', 'index')->name('index');
            });

            Route::controller(LaporanPenjualanController::class)->prefix('laporanpenjualan')->as('laporanpenjualan.')->group(function () {
                Route::get('/', 'index')->name(('index'));
                Route::get('/data', 'data')->name(('data'));
                Route::get('/laporan-penjualan/export', 'export')->name('export');
            });

            Route::controller(AdminDataUserController::class)->prefix('datausers')->as('datausers.')->group(function () {
                Route::get('/', 'index')->name('index');
            });

            Route::controller(AdminProfileController::class)->prefix('profile')->as('profile.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/update', 'update')->name('update');
            });

        });
    });

    // Role User
    Route::group(['middleware' => ['role:user', 'verified']], function () {
        // Route : User Custome Order
        Route::controller(UserCustomOrderController::class)->prefix('user')->as('user.')->group(function () {
            Route::get('/custom-order', 'index')->name('customorder');
            Route::get('/custom-order/history', 'history')->name('customorder.history');
            Route::post('/custom-order', 'store')->name('customorder.store');
            Route::post('/custom-order/payment', 'customeOrderStore')->name('customorder.payment');
            Route::get('/custom-order/{id}/detail', 'detail')->name('customorder.detail');
        });
    });
});


Route::get('/', [IndexController::class, 'index'])->name('home.index');
Route::get('/user/logout', [IndexController::class, 'userLogout'])->name('user.logout');
Route::get('/user/profile/edit', [IndexController::class, 'userProfileEdit'])->name('user.profile.edit');
Route::post('/user/profile/update', [IndexController::class, 'userProfileUpdate'])->name('user.profile.update');
Route::get('/user/change/password', [IndexController::class, 'changePassword'])->name('change.password');
Route::post('/user/update/password', [IndexController::class, 'userUpdatePassword'])->name('user.update.password');
Route::get('/detail/{id}/{slug}', [IndexController::class, 'detail']);
Route::get('/product/tag/{tag}', [IndexController::class, 'tagProduct']);

Route::get('/layanan', [LayananfixController::class, 'index'])->name('layanan');

// frontend category
Route::get('/category/product/{subcat_id}/{slug}', [IndexController::class, 'subcatProduct']);

Route::get('/subsubcategory/product/{subsubcat_id}/{slug}', [IndexController::class, 'subsubcatProduct']);
// routing get data by ajax
Route::get('/product/view/modal/{id}', [IndexController::class, 'getProductModal']);


Route::group(['prefix' => 'user', 'middleware' => ['auth', 'user'], 'namespace' => 'User'], function () {
    Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'store']);
    Route::get('/wishlist', [WishlistController::class, 'viewWishlist'])->name('wishlist');
    Route::get('/get-wishlist-product', [WishlistController::class, 'getWishlist']);
    Route::get('/remove-wishlist/{id}', [WishlistController::class, 'removeWishlist']);

    // Route:: User Order detail
    Route::get('/my-order', [UserOrderController::class, 'index'])->name('user.order');
    Route::get('/my-order/{id}/detail', [UserOrderController::class, 'orderDetail'])->name('user.order.detail');
    Route::get('/invoice/{id}/download', [UserOrderController::class, 'downloadInvoice'])->name('user.order.invoice');
    Route::get('/invoice/{id}/download/custom', [UserOrderController::class, 'downloadInvoiceCustomOrder'])->name('user.order.invoice_customorder');
});

// Route Mini
Route::post('/cart/data/store/{id}', [CartController::class, 'addToCart']);
Route::get('/product/mini/cart', [CartController::class, 'addMiniCart']);
Route::get('/minicart/product-remove/{rowId}', [CartController::class, 'removeMiniCart']);

// Route : Mycart
Route::get('/mycart', [CartPageController::class, 'index'])->name('mycart.index');
Route::get('/get-mycart-product', [CartPageController::class, 'getMyCart'])->name('mycart.get_data');
Route::get('/remove-mycart/{rowId}', [CartPageController::class, 'removeMyCart']);
Route::get('/cart-increment/{rowId}', [CartPageController::class, 'incrementMyCart']);
Route::get('/cart-decrement/{rowId}', [CartPageController::class, 'decrementMyCart']);

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/kontak/kirim', [ContactController::class, 'send'])->name('kontak.kirim');

// UserCheckout
Route::get('/user/checkout', [UserCheckoutController::class, 'index'])->name('user.checkout');
Route::post('/user/checkout/detail', [UserCheckoutController::class, 'detail'])->name('user.checkout.detail');
Route::post('/user/checkout/get-ongkir', [UserCheckoutController::class, 'getOngkir'])->name('user.checkout.getOngkir');
Route::post('/user/checkout-store', [UserCheckoutController::class, 'checkoutStore'])->name('checkout.store');
Route::delete('/user/order/delete/{id}', [UserCheckoutController::class, 'destroy'])->name('user.order.delete');
Route::get('/user/checkout/province/search', [UserCheckoutController::class, 'getProvince'])->name('user.checkout.getProvince');
Route::get('/user/checkout/city/{province_id}/search', [UserCheckoutController::class, 'getCity'])->name('user.checkout.searchRegence');
Route::get('/user/checkout/district/{regency_id}/search', [UserCheckoutController::class, 'searchDistrict'])->name('user.checkout.searchDistrict');
Route::get('/user/checkout/village/{district_id}/search', [UserCheckoutController::class, 'searchVillage'])->name('user.checkout.searchVillage');
