<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;

// Rutas de admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Login (público)
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard y productos (protegidas)
    Route::middleware('auth')->group(function () {
        Route::get('dashboard', function () {
            if (!auth()->user()->isAdmin()) abort(403);
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('products', AdminProductController::class);
    });
});

// Rutas de autenticación (globales)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============ RUTAS DE PRODUCTOS (CRUD) ============
Route::get('products', function () {
    $products = Product::orderBy('created_at', 'desc')->get();
    return view('products.index', compact('products'));
})->name('products.index');

Route::get('products/create', function () {
    return view('products.create');
})->name('products.create');

Route::post('products', function (Request $request) {
    $newProduct = new Product;
    $newProduct->description = $request->input('description');
    $newProduct->price = $request->input('price');
    $newProduct->save();

    return redirect()->route('products.index')->with('success', 'Producto creado exitosamente');
})->name('products.store');

Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('products/{id}/edit', function ($id) {
    $product = Product::findOrFail($id);
    return view('products.edit', compact('product'));
})->name('products.edit');

Route::put('products/{id}', function (Request $request, $id) {
    $product = Product::findOrFail($id);
    $product->description = $request->input('description');
    $product->price = $request->input('price');
    $product->save();

    return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente');
})->name('products.update');

Route::delete('products/{id}', function ($id) {
    $product = Product::findOrFail($id);
    $product->delete();
    return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente');
})->name('products.destroy');

// Ruta principal
Route::get('/', function () {
    return redirect()->route('products.index');
});

