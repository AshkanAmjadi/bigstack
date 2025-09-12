<?php


use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\Front\UserPanelController;


Route::get('userPanel/profile',[ UserPanelController::class , 'index'])->name('user-panel.index');
Route::get('userPanel/conversations',[ UserPanelController::class , 'conversations'])->name('user-panel.conversation');
Route::get('userPanel/comments',[ UserPanelController::class , 'comments'])->name('user-panel.comments');
Route::get('userPanel/allerts',[ UserPanelController::class , 'allerts'])->name('user-panel.allerts');
Route::get('userPanel/tacts',[ UserPanelController::class , 'tacts'])->name('user-panel.tacts');
Route::get('userPanel/logins',[ UserPanelController::class , 'logins'])->name('user-panel.logins');


