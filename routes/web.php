<?php

use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/', function () {
    return view('index');
})->middleware('auth');

Route::get('/report', function () {
    return view('report');
})->middleware('auth');

Route::get('/test', function () {
    return view('test');
})->middleware('auth');


Route::resource('/project', ProjectController::class)->middleware('auth');
Route::resource('/package', PackageController::class)->middleware('auth');
Route::post('/checkout', [PackageController::class, 'checkout'])->middleware('auth')->name('checkout.index');
Route::resource('/user', UserController::class)->middleware('auth');
route::post('package/delete/{id}', 'App\Http\Controllers\PackageController@destroy');

route::get('report_pdf', [ProjectController::class, 'pdf_generator'])->name('pdf_generator');
route::get('report_word', [ProjectController::class, 'word_generator'])->name('word_generator');

require __DIR__ . '/auth.php';
