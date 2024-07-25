<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;
use App\Http\Controllers\PostController;
use App\Http\Controllers\jdh\JdhController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Forum\ForumController;
use App\Http\Controllers\Forum\CommentController;
use App\Models\LayananPengaduan\LayananPengaduan;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Streaming\StreamingController;
use App\Http\Controllers\Persalinan\PersalinanController;
use App\Http\Controllers\PosBantuanHukum\PosBantuanHukumController;
use App\Http\Controllers\GugatanSederhana\GugatanSederhanaController;
use App\Http\Controllers\LayananPengaduan\layananPengaduanController;
use App\Http\Controllers\Forum\ForumController as ForumForumController;
use App\Http\Controllers\Streaming\CommentController as StreamingCommentController;
use App\Http\Controllers\Streaming\LivechatController;

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    
    // Route::post('/posts',[PostController::class, 'store']);
    // Route::patch('/posts/{id}',[PostController::class, 'update'])->middleware('pemilik-postingan');
    // Route::delete('/posts/{id}',[PostController::class, 'destroy'])->middleware('pemilik-postingan');


 
    Route::patch('/streaming/{id}',[StreamingController::class, 'update'])->middleware('owner:Streaming,Streaming');
    Route::delete('/streaming/{id}',[StreamingController::class, 'destroy']);
    Route::post('streaming/comment',[StreamingCommentController::class, 'store']);
    Route::post('livechat', [LivechatController::class,'store']);

    Route::post('/posbakum',[PosBantuanHukumController::class,'store']);

    Route::post('persalinan',[PersalinanController::class,'store']);

    Route::get('schedules/{id}', [ScheduleController::class, 'show']);

    Route::post('gugatansederhana',[GugatanSederhanaController::class, 'store']);
    Route::get('gugatansederhana',[GugatanSederhanaController::class, 'index']);
    Route::get('gugatansederhana/{id}',[GugatanSederhanaController::class, 'show']);
    Route::post('/forums', [ForumForumController::class, 'store']);
    Route::post('/forums/comment',[CommentController::class,'store']);
    Route::post('/forums/{id}/like', [ForumController::class, 'like']);
    Route::post('/forums/{id}/dislike', [ForumController::class, 'dislike']);
    Route::delete('/forums/{id}', [ForumController::class, 'destroy']);
    
    

    // Route::post('/posts/{id}/like', [PostController::class, 'like']);
    // Route::post('/posts/{id}/dislike', [PostController::class, 'dislike']);

});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/logout',[AuthenticationController::class, 'logout']);
    Route::get('/me',[AuthenticationController::class, 'me']);
});

Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function(){
    Route::post('/streaming',[StreamingController::class, 'store']);
    Route::post('/jdh',[JdhController::class,'store']);
});
Route::get('/forums', [ForumController::class, 'index']);

Route::get('/forums', [ForumController::class, 'index']);
Route::get('/forums/{id}', [ForumController::class, 'show']);


// Route::get('/posts',[PostController::class,'index']);
// Route::get('/posts/{id}',[PostController::class,'show']);

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('register', [AuthenticationController::class, 'register']);
Route::get('verify/{id}', [AuthenticationController::class, 'verifyEmail']);
Route::get('users',[AuthenticationController::class,'index']);

Route::post('password/email', [ResetPasswordController::class, 'sendResetLinkEmail']);

Route::get('schedules', [ScheduleController::class, 'index']);
Route::post('schedules', [ScheduleController::class, 'store']);
Route::get('schedules/{id}', [ScheduleController::class, 'show']);
Route::put('schedules/{id}', [ScheduleController::class, 'update']);
Route::delete('schedules/{id}', [ScheduleController::class, 'destroy']);

Route::get('/streaming',[StreamingController::class,'index']);
Route::get('/streaming/{id}',[StreamingController::class,'show']);

Route::post('/layanan-pengaduan',[layananPengaduanController::class,'store']);
Route::get('/layanan-pengaduan',[layananPengaduanController::class,'index']);

Route::get('/jdh',[JdhController::class,'index']);
Route::get('/jdh/{id}', [JdhController::class, 'show']);
Route::patch('jdh/{id}',[JdhController::class,'update']);

