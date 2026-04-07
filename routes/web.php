<?php

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

// ============ RUTAS DE PRODUCTOS (CRUD original) ============
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

Route::delete('products/{id}', function ($id) {
    $product = Product::findOrFail($id);
    $product->delete();
    return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente');
})->name('products.destroy');

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

// ============ RUTAS DE AUTENTICACIÓN ============
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// ============ RUTAS DE ADMIN (protegidas) ============
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permiso para acceder');
        }
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Ruta principal (opcional)
Route::get('/', function () {
    return redirect()->route('products.index');
});