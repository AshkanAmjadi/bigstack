<?php

//users
use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\Admin\UserController;

Route::resource('users', UserController::class)->except('show');

Route::post('userAllert/{userAllert:id}/delete', [UserController::class,'deleteUserAllert'])->name('delete.userAllert');
Route::prefix('users/{user:id}')->group(function () {
    //permission
    Route::get('permission', [UserController::class, 'permission'])->name('users.permission.show');
    Route::post('permission', [UserController::class, 'setPermission'])->name('users.permission.store');
    //user_coupopns
    Route::get('coupon', [UserController::class, 'coupon'])->name('users.coupon.show');
    Route::post('coupon', [UserController::class, 'setCoupon'])->name('users.coupon.store');
    Route::delete('coupon/{coupon}', [UserController::class, 'unsetUserCoupon'])->name('users.coupon.destroy');

    //allerts
    Route::post('allerts', [UserController::class, 'allerts'])->name('users.allerts');
    Route::post('allert/{userAllert:id}/delete', [UserController::class,'deleteUserAllert'])->name('delete.userAllert');


});


//users permission
//Route::resource('permissions', PermissionController::class)->except('show');
//Route::resource('roles', RoleController::class)->except('show');
//category



//Route::prefix('category/{category:id}')->group(function () {

//    Route::get('attr', [CategoryController::class, 'showAttr'])->name('category.attr.show');
//    Route::post('attr', [CategoryController::class, 'setAttr'])->name('category.attr.set');
//    //desc
//    Route::get('descript', [CategoryController::class, 'showDesc'])->name( 'category.desc.show');
//    Route::post('descript', [CategoryController::class, 'setDesc'])->name( 'category.desc.store');
//    Route::get('descript/gallery', [CategoryController::class, 'showDescGallery'])->name( 'category.descGallery.show');
//    Route::post('descript/gallery', [CategoryController::class, 'setDescGallery'])->name( 'category.descGallery.store');
//    Route::delete('descript/gallery', [CategoryController::class, 'deleteDescGallery'])->name( 'category.descGallery.delete');
//
//});
