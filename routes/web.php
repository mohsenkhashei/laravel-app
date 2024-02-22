<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\FilmController;

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
Route::controller(TestController::class)->group(function () {
    Route::get('/test', [TestController::class, 'index'])->name('test.index');
    Route::get('/test/demo', [TestController::class, 'demo'])->name('test.demo');
    Route::get('/test/clubs', [TestController::class, 'clubs'])->name('test.clubs');
    Route::get('/test/fetch', [TestController::class, 'fetchData'])->name('fetch');
});

Route::controller(FilmController::class)->group(function () {
    Route::get('/film', [FilmController::class, 'index'])->name('film.index');
});


// Route::middleware(['auth:web'])->group(function () {
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');

    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::get('/products/{product}', [ProductsController::class, 'show'])->name('products.show');

    Route::get('/products/edit/{product}', [ProductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{product}', [ProductsController::class, 'update'])->name('products.update');

    Route::delete('/products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
// });


Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});
