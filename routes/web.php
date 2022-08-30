<?php

use App\Http\Controllers\BackEnd\AuthController;
use App\Http\Controllers\BackEnd\DashboardController;
use App\Http\Controllers\BackEnd\QuizController;
use App\Http\Controllers\BackEnd\QuizSubmissionController;
use App\Http\Controllers\BackEnd\UserController;
use App\Http\Controllers\FrontEnd\IndexController;
use App\Http\Controllers\FrontEnd\UserAuthController;
use App\Http\Controllers\FrontEnd\UserDashboardController;
use App\Http\Controllers\FrontEnd\UserQuizController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

//clear cache route
Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    return Redirect('/'); 
});


Route::get('/',[IndexController::class,'index'])->name('home');
Route::get('/login',[UserAuthController::class,'login'])->name('login');
Route::post('/login',[UserAuthController::class,'login'])->name('login');
Route::get('/register',[UserAuthController::class,'register'])->name('register');
Route::post('/register',[UserAuthController::class,'register'])->name('register');

Route::prefix('user')->middleware('is_user')->group(function(){

    Route::get('/dashboard',[UserDashboardController::class,'index'])->name('user.dashboard');
    Route::get('/quiz/{id}',[UserQuizController::class,'quiz'])->name('quiz_show');
    Route::post('/submit-quiz/{id}',[UserQuizController::class,'quizSubmition'])->name('submit_quiz');
    Route::get('/quiz-score/{id}',[UserQuizController::class,'score'])->name('score');
    Route::get('/logout',[UserAuthController::class,'logout'])->name('user.logout');
});

// admin routes start 
Route::prefix('admin')->group(function () {
    Route::get('/',[AuthController::class,'index'])->name('admin.login');
    Route::post('/',[AuthController::class,'Auth'])->name('admin.login');
    Route::get('/forget-password',[AuthController::class,'forget'])->name('admin.forget.password');
    Route::post('/forget-password',[AuthController::class,'forget'])->name('admin.forget.password');
    Route::get('/password/reset/{token}',[AuthController::class,'reset'])->name('admin.password.reset');
    Route::post('/password-reset',[AuthController::class,'ChangePassword'])->name('admin.password.reset.submit');
});
Route::prefix('admin')->middleware(['is_admin'])->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/profile',[DashboardController::class,'profile'])->name('admin.profile');
    Route::post('/profile',[DashboardController::class,'profile'])->name('admin.profile');
    Route::resource('/users', UserController::class);
    Route::post('/users/{id}', [UserController::class,'update'])->name('users.update');
    Route::get('/quizes',[QuizController::class,'index'])->name('admin.quizes.index');
    Route::get('/quizes/create',[QuizController::class,'create'])->name('admin.quizes.create');
    Route::post('/quizes/store',[QuizController::class,'store'])->name('admin.quizes.store');
    Route::get('/quizes/edit/{id}',[QuizController::class,'edit'])->name('admin.quizes.edit');
    Route::put('/quizes/update/{id}',[QuizController::class,'update'])->name('admin.quizes.update');
    Route::delete('/quizes/destroy/{id}',[QuizController::class,'destroy'])->name('admin.quizes.destroy');
    Route::get('/submissions',[QuizSubmissionController::class,'index'])->name('admin.submissions.index');
    Route::get('/submissions/show/{id}',[QuizSubmissionController::class,'show'])->name('admin.submissions.show');
    Route::get('/logout',[AuthController::class,'logout'])->name('admin.logout');
});
