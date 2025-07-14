<?php
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\{
    AttendanceController,
    CompanyController,
    PermissionController,
    UserController,
    CatatanController,
    AuthController,
    ProfileController,
    DashboardController,
    PublicController,
    UserCatatanController,
    ActifityLogController,
    EventController,
    UserCatatanControlller
    
  
};
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\AdminAuthController;
use App\Exports\CatatanExport;
use App\Http\Middleware\CheckRole;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\CatatanExportController;
use App\Http\Controllers\PermissionExportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman login
Route::get('/', function () {
    return view('pages.auth.auth-login');
});

// Proses login custom (gunakan controller yang kamu override dari Fortify)
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');

// Register & Forgot Password
Route::view('/register', 'pages.auth.auth-register')->name('register');
Route::view('/forgot-password', 'pages.auth.auth-forgot-password')->name('forgot-password');

// Export data catatan
Route::get('/export-catatan', function () {
    return Excel::download(new CatatanExport, 'catatans.xlsx');
});

// Route setelah login
Route::middleware(['auth:admin,user'])->group(function () {
    // Dashboard umum (bisa dipakai sebagai index)
    Route::get('index', function () {
        return view('welcome');
    })->name('index');


    Route::middleware(['auth', 'CheckRole:admin'])->group(function(){
        Route::get('/home');
    });
    Route::middleware(['auth', 'CheckRole:user'])->group(function(){
        Route::get('/public');
    });

    // Profile
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Role Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard admin
    Route::get('home', function () {
        return view('pages.dashboard', ['type_menu' => 'home']);
    })->name('home');

    // Resource routes admin
    Route::resources([
        'users'       => UserController::class,
        'companies'   => CompanyController::class,
        'attendances' => AttendanceController::class,
        'catatan'     => CatatanController::class,
        'permissions' => PermissionController::class,
    ]);
});

// Catatan admin khusus dengan prefix 'pages'
Route::middleware(['auth', 'CheckRole:admin'])->prefix('pages')->name('pages.')->group(function () {
    Route::get('catatans', [CatatanController::class, 'index'])->name('catatans.index');
    Route::get('catatans/create', [CatatanController::class, 'create'])->name('catatans.create');
    Route::post('catatans', [CatatanController::class, 'store'])->name('catatans.store');
    Route::get('catatans/{catatan}/edit', [CatatanController::class, 'edit'])->name('catatans.edit');
    Route::put('catatans/{catatan}', [CatatanController::class, 'update'])->name('catatans.update');
    Route::delete('catatans/{catatan}', [CatatanController::class, 'destroy'])->name('catatans.destroy');
});


// Catatan khusus user
Route::middleware(['auth', 'CheckRole:user'])
    ->prefix('public')
    ->name('public.')
    ->group(function () {
        Route::get('catatans', [UserCatatanController::class, 'index'])->name('catatans.index');
        Route::get('catatans/create', [UserCatatanController::class, 'create'])->name('catatans.create');
        Route::post('catatans', [UserCatatanController::class, 'store'])->name('catatans.store');
        Route::get('catatans/{catatan}/edit', [UserCatatanController::class, 'edit'])->name('catatans.edit');
        Route::put('catatans/{catatan}', [UserCatatanController::class, 'update'])->name('catatans.update');
        Route::delete('catatans/{catatan}', [UserCatatanController::class, 'destroy'])->name('catatans.destroy');
    });








// Role User: diarahkan ke halaman 'public'
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('public', [PublicController::class, 'index'])->name('public.index');
    Route::get('public/create', [PublicController::class, 'create'])->name('public.create');
    Route::post('public', [PublicController::class, 'store'])->name('public.store');
});




//routing export document
Route::get('/catatans/export/excel', [CatatanExportController::class, 'exportExcel'])->name('catatans.export.excel');
Route::get('/catatans/export/pdf', [CatatanExportController::class, 'exportPDF'])->name('catatans.export.pdf');

///log aktivity
Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');

//rekap keterlambatan
Route::get('/rekap/keterlambatan', [AttendanceController::class, 'rekapketerlambatan'])->name('rekap.keterlambatan');

//rekap izin user
Route::get('/rekap/izin', [PermissionController::class, 'rekapizin'])->name('rekapizin');

//routing export pdf
///rekap per hari
Route::get('/rekap-absensi-pdf', [AttendanceController::class, 'exportPDF']);

//rekapp user
Route::get('/laporan/user/{id}', [AttendanceController::class,'cetakPerUser' ]);
///rekap per minggu

Route::get('/laporan/mingguan/{id}/{start}/{end}', [AttendanceController::class, 'cetakMingguan']);
///rekap per bulan
Route::get('/laporan/bulanan/{id}/{bulan}/{tahun}', [AttendanceController::class, 'cetakBulanan']);

///rekap izin per bulan
Route::get('/laporan/permission/bulanan/{id}/{bulan}/{tahun}', [PermissionController::class, 'cetakLaporanIzin']);

//permission export 

Route::get('/permission/export/excel', [PermissionController::class, 'exportExcel'])->name('tasks.export.excel');
Route::get('/permission/export/pdf', [PermissionController::class, 'exportPDF'])->name('permission.export.pdf');
Route::post('/export-permission', [PermissionController::class, 'exportPerbulan'])->name('export.perbulan');
Route::post('export-permission-peruser]', [PermissionController::class, 'exportPerUser'])->name('export.peruser');

////calendar
// Route::get('/calendar', [EventController::class, 'index']);
// Route::get('/events', [EventController::class, 'fetchEvents']);use App\Http\Controllers\EventController;

Route::get('/calendar', [EventController::class, 'index']);
Route::get('/events', [EventController::class, 'fetchEvents']);
Route::post('/events', [EventController::class, 'store']);




////work schedules
Route::resource('work_schedules',App\Http\Controllers\WorkSchedulesController::class);



// // // company
Route::middleware(['auth'])->group(function () {
    Route::get('/companies', [CompanyController::class, 'index'])->name('pages.companies.index');
    Route::get('/companies/show', [CompanyController::class, 'show'])->name('pages.companies.show');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('pages.companies.create');
    Route::post('/companies/store', [CompanyController::class, 'store'])->name('companies.store');    
    Route::get('/companies/edit', [CompanyController::class, 'edit'])->name('pages.companies.edit');
    Route::put('/companies/update', [CompanyController::class, 'update'])->name('companies.update');

    // Jika ada fitur delete
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');
});

///notification
    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');

///message
Route::middleware('auth')->group(function(){
    Route::get('/messages/{receiverId}', [MessageController::class, 'index'])->name('messages.index');
    Route::post('messages', [MessageController::class, 'store'])->name('messages.store');
});

///message bagian admin
// Route::get('/message/{receiverId}', [MessageController::class, 'index'])->name('pages.message.index');