<?php

use App\Http\Controllers\{
    HomeController,
    Book\BookController,
    Book\CategoryController,
    Book\SubCategoryController,
    ProfileController,
    AdminCrudController,
    StaffController,
    MahasiswaController,
    AdminController,
    DashboardController,
    PeminjamanController
};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Book\BookShowController;
use App\Http\Controllers\mahasiswa\BukuMahasiswaController;
use Illuminate\Http\Request;




Route::get('/', function () {
    return view('dashboard.mahasiswa.myLibrary');
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Grouping related routes together
Route::resource('staff', StaffController::class);
Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/homeee', [HomeController::class, 'index'])->name('home');

// Profile routes under auth middleware
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Book-related resources
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::resource('books', BookController::class);
Route::resource('category', CategoryController::class);
Route::resource('subCategory', SubCategoryController::class);

// Admin CRUD routes
Route::prefix('admin')->group(function () {
    Route::get('/crud', [AdminCrudController::class, 'index'])->name('admin.crud');
    // Route::get('/adminStaffIndex', [AdminCrudController::class, 'admminStaffIndex'])->name('admin.adminStaffIndex');
    Route::post('/store', [AdminCrudController::class, 'store'])->name('admin.store');
    Route::get('/edit/{id}', [AdminCrudController::class, 'edit'])->name('admin.edit');
    Route::post('/update/{id}', [AdminCrudController::class, 'update'])->name('admin.update');
    Route::put('/update/{id}', [AdminCrudController::class, 'update'])->name('admin.update');
    Route::delete('/delete/{id}', [AdminCrudController::class, 'destroy'])->name('admin.destroy');
    Route::get('/mahasiswa/edit/{id}',[MahasiswaController::class,'editMahasiswa'])->name('mahasiswa.edit');
    Route::post('/mahasiswa/update',[MahasiswaController::class,'updateMahasiswa'])->name('mahasiswa.updateMahasiswa');
});



Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home');
Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
Route::get('/admin/daftarStaff', [AdminController::class, 'daftarStaff'])->name('admin.daftarStaff');
Route::get('/admin/daftarMahasiswa', [AdminController::class, 'daftarMahasiswa'])->name('admin.daftarMahasiswa');



Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);


Route::get('/api/subcategories', function (Request $request) {
    $categoryId = $request->query('category_id');
    $subCategories = \App\Models\Book\SubCategory::where('category_id', $categoryId)->get();
    return response()->json(['subCategories' => $subCategories]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/mahasiswa', [BukuMahasiswaController::class, 'index'])->name('dashboard.mahasiswa.home');
    Route::get('/Search', [BukuMahasiswaController::class, 'cariBuku'])->name('dashboard.mahasiswa.index');
    Route::get('/mahasiswa/books/{id}', [BukuMahasiswaController::class, 'show'])->name('dashboard.mahasiswa.show');

});
Route::get('/LandingPage', [BukuMahasiswaController::class, 'landingPage'])->name('dashboard.mahasiswa.myLibrary');


Route::middleware('auth')->group(function () {
    Route::get('/mahasiswa/books/{id}', [BukuMahasiswaController::class, 'show'])->name('dashboard.mahasiswa.show');
});


use App\Http\Controllers\LoanController;
Route::middleware('auth')->group(function () {
    Route::get('/peminjaman/propose/{book}', [LoanController::class, 'propose'])->name('peminjaman.propose');
});


Route::post('/loans', [LoanController::class, 'store'])->name('loan.store'); // Ajuan oleh mahasiswa
Route::put('/loans/{id}/approve-borrow', [LoanController::class, 'approveBorrow'])->name('loan.approveBorrow'); // Persetujuan peminjaman
Route::put('/loans/{id}/approve-return', [LoanController::class, 'approveReturn'])->name('loan.ApproveReturn'); // Persetujuan pengembalian

Route::get('loanReturn', [LoanController::class, 'loanReturnAll'] )->name('staff.loanReturn');
Route::get('loanRequest', [LoanController::class, 'loanRequestALL'])->name('staff.loanRequest');

Route::get('loan', [LoanController::class, 'loanMahasiswaList'])->name('loan.listLoan');


Route::put('/loan/{id}/return-book', [LoanController::class, 'returnBook'])->name('loan.returnBook');
Route::get('/staff/return', [LoanController::class, 'showReturns'])->name('staff.return');



Route::put('/loan/{loan}/update-fine', [LoanController::class, 'updateFine'])->name('loan.updateFine');

Route::put('/loan/{loan}/extend', [LoanController::class, 'extend'])->name('loan.extend');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [MahasiswaController::class, 'profile'])->name('mahasiswa.profile');
    Route::post('/profile/update', [MahasiswaController::class, 'updateProfile'])->name('mahasiswa.updateProfile');
    Route::delete('/profile/delete', [MahasiswaController::class, 'deleteAccount'])->name('mahasiswa.deleteAccount');
});












require __DIR__ . '/auth.php';
