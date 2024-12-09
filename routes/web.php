<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\FakeDataPostController;
use App\Http\Controllers\HttpClientController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TestMiddleWare;
use App\Jobs\SendMailJob;
use App\Mail\SendEmail;
use App\Mail\TestEmail;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(UserController::class)->prefix('users')->group(function(){
    Route::get('/','index');
    Route::post('/store',  'store')->name('user.store');
    Route::get('/search',  'search')->name('users.index'); 
    Route::get('/trash',  'user_in_trash')->name('users.trash');
    Route::put('/restore/{id}',  'restore')->name('users.restore');
    Route::get('/trash/search',  'trash_search')->name('users.restore');
    Route::delete('/destroy/{id}', 'delete')->name('user.destroy');
});
Route::put('/user/update/{id}', [UserController::class, 'user_update'])->name('users.update');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');

Route::get('/admin/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
// Route để cập nhật người dùng (POST hoặc PUT)
Route::put('/admin/update/{id}', [UserController::class, 'update'])->name('admin.update');

Route::get('/users/details/{id}', [UserController::class, 'show'])->name('users.details');

Route::get('/send-mail', function () {
    $details = [
        'title' => 'Mail từ Laravel',
        'body' => 'Đây là email demo từ Laravel.'
    ];

    $users = User::all();
    foreach ($users as $user) {
        SendMailJob::dispatch($user);
    }

    return  $users->count()."Email đã được gửi!";
});
Route::get('/http-client-rest', [HttpClientController::class,'rest']);

Route::get('/http-client-graph', [HttpClientController::class,'graph']);

Route::get('/export-users', [ExportController::class, 'exportUser'])->name('export.users');
Route::get('/export-posts', [ExportController::class, 'exportPost'])->name('export.users');
Route::get('/export-users-from-view', [ExportController::class, 'exportUserfromView'])->name('export.usersview');
Route::get('/fake-data-post', [FakeDataPostController::class, 'fakeDataPost'])->name('export.fakeDataPost');
Route::get('/testexp', [ExportController::class, 'exportExcel'])->name('export.fakeDataPost');
