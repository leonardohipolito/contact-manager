<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', [App\Http\Controllers\ContactController::class, 'index'])->name('home');
Route::get('/contact/create', [App\Http\Controllers\ContactController::class, 'create'])->name('contact.create')->can('create', App\Models\Contact::class);
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store')->can('create', App\Models\Contact::class);
Route::get('/contact/{contact}/edit', [App\Http\Controllers\ContactController::class, 'edit'])->name('contact.edit')->can('update', App\Models\Contact::class);
Route::put('/contact/{contact}', [App\Http\Controllers\ContactController::class, 'update'])->name('contact.update')->can('update', App\Models\Contact::class);
Route::get('/contact/{contact}', [App\Http\Controllers\ContactController::class, 'show'])->name('contact.show')->can('view', App\Models\Contact::class);
Route::delete('/contact/{contact}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('contact.destroy')->can('delete', App\Models\Contact::class);

Route::redirect('/dashboard', '/')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
