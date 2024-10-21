<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Group untuk profile yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route khusus untuk role "siswa"
Route::group(['middleware' => ['auth', 'role:siswa']], function () {
    // Route::get('/siswa/index', [SiswaController::class, 'index'])->name('siswa.index');
    // Tambahkan route lain khusus siswa di sini
    Route::resource('siswa', SiswaController::class);
});


// Route khusus untuk role "guru"
Route::group(['middleware' => ['auth', 'role:guru']], function () {
    Route::get('/guru/index', [GuruController::class, 'index'])->name('guru.index');
    // Route::get('/guru/edit', [GuruController::class, 'edit'])->name('guru.edit');
    Route::resource('guru', GuruController::class);
    // Tambahkan route lain khusus guru di sini
});

// Route::get('/create', function () {
//     return view('siswas.create');
// });


// Auth routes
require __DIR__.'/auth.php';
