<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppController;
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
Route::get('/login', [AppController::class,'login'])->name('login');
Route::post('/login', [AppController::class,'accountLogin']);
Route::get('/registration', [AppController::class, 'registration'])->name('register-user');
Route::post('/custom-registration', [AppController::class, 'customRegistration'])->name('register.custom');
Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [HomeController::class,'index'])->name('homepage');
    Route::get('/logout', [AppController::class,'signOut'])->name('logout');
    Route::get('/room', [HomeController::class,'room'])->name('room');
    Route::get('/room/list', [HomeController::class,'listRoom'])->name('list-room');
    Route::get('/room/info', [HomeController::class,'infoRoom'])->name('info-room');
    Route::post('/room/add', [HomeController::class,'addRoom'])->name('addRoom');
    Route::post('/room/add-student', [HomeController::class,'addStudent'])->name('addStudent');
    Route::post('/room/break-student', [HomeController::class,'breakOut'])->name('breakOut');
    Route::get('/student', [HomeController::class,'student'])->name('student');
    Route::post('/student', [HomeController::class,'saveStudent'])->name('saveStudent');
    Route::post('/student/delete', [HomeController::class,'deleteStudent'])->name('deleteStudent');
});
