<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportScheduleController;
use App\Http\Controllers\ExportScheduleController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProductController::class, 'index']);
Route::get('products/{product:name}', [ProductController::class, 'show']);

Route::get('categories/{category:name}', function(Category $category) {
    return view('products.index', [
        'products' => $category->products,
        'currentCategory' => $category,
        'categories' => Category::all()
    ]);
});

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('login', [SessionsController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');

Route::get('admin/register-manager', [AdminController::class, 'createManager'])->middleware('can:admin');
Route::post('admin/register-manager', [AdminController::class, 'storeManager'])->middleware('can:admin');

Route::get('admin/import', [ImportController::class, 'index'])->middleware('can:admin');
Route::post('admin/import', [ImportController::class, 'import'])->middleware('can:admin');
Route::get('/admin/import-progress', [ImportController::class, 'checkProgress'])->middleware('can:admin');

Route::get('/admin/schedule-import', [ImportScheduleController::class, 'index'])->middleware('can:admin');
Route::post('/admin/schedule-import', [ImportScheduleController::class, 'store'])->middleware('can:admin');
Route::delete('admin/schedule-import/{import}', [ImportScheduleController::class, 'destroy'])->middleware('can:admin');
Route::patch('admin/schedule-import/{import}', [ImportScheduleController::class, 'update'])->middleware('can:admin');
Route::get('/admin/schedule-import/history', [ImportScheduleController::class, 'past'])->middleware('can:admin');


Route::get('/admin/schedule-export', [ExportScheduleController::class, 'index'])->middleware('can:admin');
Route::post('/admin/schedule-export', [ExportScheduleController::class, 'store'])->middleware('can:admin');
Route::delete('admin/schedule-export/{export}', [ExportScheduleController::class, 'destroy'])->middleware('can:admin');
Route::patch('admin/schedule-export/{export}', [ExportScheduleController::class, 'update'])->middleware('can:admin');
Route::get('/admin/schedule-export/history', [ExportScheduleController::class, 'past'])->middleware('can:admin');


Route::get('admin/export', [ExportController::class, 'index'])->middleware('can:admin');
Route::post('admin/export', [ExportController::class, 'export'])->middleware('can:admin');
Route::get('admin/download', [ExportController::class, 'download'])->middleware('can:admin');
Route::get('/admin/export-progress', [ExportController::class, 'checkProgress'])->middleware('can:admin');

Route::post('admin/products', [AdminController::class, 'store'])->middleware('can:admin');
Route::get('admin/products/create', [AdminController::class, 'create'])->middleware('can:admin');
Route::get('admin/products', [AdminController::class, 'index'])->middleware('can:admin');
Route::get('admin/products/{product}/edit', [AdminController::class, 'edit'])->middleware('can:admin');
Route::patch('admin/products/{product}', [AdminController::class, 'update'])->middleware('can:admin');
Route::delete('admin/products/{product}', [AdminController::class, 'destroy'])->middleware('can:admin');

Route::post('manager/products', [ManagerController::class, 'store'])->middleware('can:manager');
Route::get('manager/products/create', [ManagerController::class, 'create'])->middleware('can:manager');
Route::get('manager/products', [ManagerController::class, 'index'])->middleware('can:manager');
Route::get('manager/products/{product}/edit', [ManagerController::class, 'edit'])->middleware('can:manager');
Route::patch('manager/products/{product}', [ManagerController::class, 'update'])->middleware('can:manager');

Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->middleware('auth');

Route::get('/cart', [CartController::class, 'showCart']);

Route::patch('/cart/decrease/{id}', [CartController::class, 'decreaseQuantity']);
Route::patch('/cart/increase/{id}', [CartController::class, 'increaseQuantity']);
Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem']);