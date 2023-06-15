<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\User\Index as UserIndex;
use App\Http\Livewire\User\Edit as UserEdit;
use App\Http\Livewire\User\Create as UserCreate;
use App\Http\Livewire\Setting\Edit as SettingEdit;

use App\Http\Controllers\Web\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Web\Auth\PasswordController;

use App\Constants\Roles;

/*'
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::group(['middleware' => ['role:' . Roles::ROOT]], function () {
    Route::get('/users', UserIndex::class)->name('users.index');
    Route::get('/users/{user}/edit', UserEdit::class)->name('users.edit');
    Route::get('/users/create', UserCreate::class)->name('users.create');
    Route::get('/settings', SettingEdit::class)->name('settings.edit');
});

Route::group([
    'middleware' => ['role:' . implode('|', [Roles::ROOT, Roles::ADMIN_QUOTE]),]
], function () {
    Route::get('/settings', SettingEdit::class)->name('settings.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
