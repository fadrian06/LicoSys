<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
  Route::view('/', 'dashboard')->name('dashboard');
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::resource('/products', ProductController::class);
});

Route::get('/preferences/theme/{theme}', function (string $theme): void {
  $_SESSION['theme'] = $theme;
});

Route::get('/preferences/taxes/bcv/{tax}', function (float $tax): void {
  $user = Auth::user();

  if ($user instanceof User) {
    $user->update(['bcv_tax' => $tax]);
  }
});

require_once __DIR__ . '/auth.php';
