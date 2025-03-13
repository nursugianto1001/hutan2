<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\company\CompanyController;
use App\Http\Controllers\alumni\AlumniController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\admin\AdminUserController;

Route::get('/', function () {
    if(!Auth::check()){
        return view('welcome');
    }
    if(Auth::user()->role_id == 1){
        return App(AdminController::class)->index();
    }
    if(Auth::user()->role_id == 2){
        return App(CompanyController::class)->index();
    }
    if(Auth::user()->role_id == 3){
        return App(AlumniController::class)->index();
    }
    return view('welcome');
})->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin')->middleware('auth')->group(function(){
    Route::resource('user', AdminUserController::class)->names([
        'index' => 'user.index',
        'create' => 'user.create',
        'store' => 'user.store',
        'edit' => 'user.edit',
        'update' => 'user.update',
        'destroy' => 'user.destroy',
    ]);
});

require __DIR__.'/auth.php';
