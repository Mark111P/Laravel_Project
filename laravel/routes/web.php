<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserApiController;

use App\Http\Controllers\VotingController;
use App\Http\Controllers\VotingApiController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminApiController;

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

Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/user/login', [UserController::class, 'login'])->name('login');
Route::get('/userApi/checkLogin', [UserApiController::class, 'checkLogin'])->name('checkLogin');
Route::get('/user/register', [UserController::class, 'register'])->name('register');
Route::get('/userApi/checkRegister', [UserApiController::class, 'checkRegister'])->name('checkRegister');
Route::get('/user/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/voting/home', [VotingController::class, 'home'])->name('home');
Route::post('/voting/vote', [VotingController::class, 'vote'])->name('vote');
Route::get('/votingApi/checkVote', [VotingApiController::class, 'checkVote'])->name('checkVote');

Route::get('/admin/home', [AdminController::class, 'home'])->name('admin');
Route::get('/admin/createVoting', [AdminController::class, 'createVoting'])->name('createVoting');
Route::get('/adminApi/checkVoting', [AdminApiController::class, 'checkVoting'])->name('checkVoting');
Route::post('/admin/deleteVoting', [AdminController::class, 'deleteVoting'])->name('deleteVoting');
Route::post('/admin/updateVoting', [AdminController::class, 'updateVoting'])->name('updateVoting');
Route::get('/adminApi/changeVoting', [AdminApiController::class, 'changeVoting'])->name('changeVoting');
Route::post('/admin/showVoting', [AdminController::class, 'showVoting'])->name('showVoting');
