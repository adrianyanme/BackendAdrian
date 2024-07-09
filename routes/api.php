<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\LayananPengaduan\layananPengaduanController;
use App\Http\Controllers\PosBantuanHukum\PosBantuanHukumController;
use App\Http\Controllers\Streaming\CommentController as StreamingCommentController;
use App\Http\Controllers\Streaming\StreamingController;
use App\Models\LayananPengaduan\LayananPengaduan;

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/logout',[AuthenticationController::class, 'logout']);
    Route::get('/me',[AuthenticationController::class, 'me']);
    Route::post('/posts',[PostController::class, 'store']);
    Route::patch('/posts/{id}',[PostController::class, 'update'])->middleware('pemilik-postingan');
    Route::delete('/posts/{id}',[PostController::class, 'destroy'])->middleware('pemilik-postingan');


    Route::post('/comment',[CommentController::class, 'store']);
    Route::patch('/comment/{id}',[CommentController::class, 'update'])->middleware('pemilik-comentar');
    Route::delete('/comment/{id}',[CommentController::class, 'destroy'])->middleware('pemilik-comentar');

 
    Route::patch('/streaming/{id}',[StreamingController::class, 'update'])->middleware('owner:Streaming,Streaming');
    Route::delete('/streaming/{id}',[StreamingController::class, 'destroy']);
    Route::post('streaming/comment',[StreamingCommentController::class, 'store']);

    Route::post('/posbakum',[PosBantuanHukumController::class,'store']);

});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function(){
    Route::post('/streaming',[StreamingController::class, 'store']);
});

Route::get('/posts',[PostController::class,'index']);
Route::get('/posts/{id}',[PostController::class,'show']);

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('register', [AuthenticationController::class, 'register']);
Route::get('verify/{id}', [AuthenticationController::class, 'verifyEmail']);

Route::post('password/email', [ResetPasswordController::class, 'sendResetLinkEmail']);

Route::get('schedules', [ScheduleController::class, 'index']);
Route::post('schedules', [ScheduleController::class, 'store']);
Route::get('schedules/{id}', [ScheduleController::class, 'show']);
Route::put('schedules/{id}', [ScheduleController::class, 'update']);
Route::delete('schedules/{id}', [ScheduleController::class, 'destroy']);

Route::get('/streaming',[StreamingController::class,'index']);
Route::get('/streaming/{id}',[StreamingController::class,'show']);

Route::post('/layanan-pengaduan',[layananPengaduanController::class,'store']);




