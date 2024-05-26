<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminCafeController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminTableController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\PaymentController;

Route::middleware(['guest'])->group(function () {

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Rute Umum
Route::middleware(['auth'])->group(function () {
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/cafes', [CafeController::class, 'index'])->name('cafes.index');
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');

Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/notifications/check', [NotificationController::class, 'check'])->name('notifications.check');
Route::post('/notifications/markAsRead', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::delete('/notifications/read', [NotificationController::class, 'deleteReadNotifications'])->name('notifications.deleteRead');

Route::get('/cafes/{cafeId}/check-availability', [CafeController::class, 'checkAvailability'])->name('cafes.checkAvailability');
Route::get('/reservations/{cafeId}/details', [ReservationController::class, 'showDetails'])->name('reservations.details');

Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/reservations/history', [ReservationController::class, 'history'])->name('reservations.history');
Route::get('/cafes/{cafeId}/book', [ReservationController::class, 'showBookForm'])->name('reservations.book');
Route::post('/cafes/{cafeId}/book', [ReservationController::class, 'bookCafe'])->name('reservations.store');

// Tambahkan route untuk confirmPayment
Route::post('/reservations/confirmPayment', [ReservationController::class, 'confirmPayment'])->name('reservations.confirmPayment');
Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
Route::post('/reservations/get-tables', [ReservationController::class, 'getTablesByCapacity'])->name('reservations.getTablesByCapacity');

Route::get('/payments/{reservationId}/create', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
Route::get('/payments/success/{reservation_id}', [PaymentController::class, 'success'])->name('payments.success');
Route::get('/payments/invoice/{id}', [PaymentController::class, 'invoice'])->name('payments.invoice');
Route::post('/payments/process/{reservationId}', [PaymentController::class, 'process'])->name('payments.process');

Route::get('/search', [CafeController::class, 'search'])->name('cafes.search');


Route::resource('cafes', CafeController::class)->names([
    'index'   => 'cafes.index',
    'create'  => 'cafes.create',
    'store'   => 'cafes.store',
    'show'    => 'cafes.show',
    'edit'    => 'cafes.edit',
    'update'  => 'cafes.update',
    'destroy' => 'cafes.destroy',
]);
});

// Rute Admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('cafes', AdminCafeController::class)->names('admin.cafes');
        Route::resource('reservations', AdminReservationController::class)->names('admin.reservations');
        Route::resource('categories', CategoryController::class)->names('admin.categories');
        Route::get('cafes/{cafe}/tables', [AdminTableController::class, 'index'])->name('tables.index');

      
    Route::get('/admin/cafes/{cafe}/tables', [AdminTableController::class, 'index'])->name('admin.tables.index');
    Route::post('/admin/cafes/{cafe}/tables', [AdminTableController::class, 'store'])->name('admin.tables.store');
    });
});

