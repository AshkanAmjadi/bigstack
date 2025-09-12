<?php

use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\Auth\googleAuthController;
use Modules\User\App\Http\Controllers\Auth\loginControlle;
use Modules\User\App\Http\Controllers\Front\UserPanelController;

Route::get('/auth/google',[googleAuthController::class,'redirect'])->name('auth.google');
Route::get('/auth/google/callback',[googleAuthController::class,'callback']);




Route::post('/logout',[loginControlle::class,'logout'])->name('logout');

Route::prefix('auth')->middleware('guest')->group(function () {

    Route::get('login', [loginControlle::class, 'loginShow'])->name('auth.login');
    Route::post('login', [loginControlle::class, 'login']);
    Route::get('verifyCode', [loginControlle::class, 'verifyCodeShow'])->name('auth.verifyCode');
    Route::post('verifyCode', [loginControlle::class, 'verifyCode']);


});
Route::get('profile@{username}',[UserPanelController::class,'userInfo'])->name('profile');
