<?php
// use App\Http\Controllers\Backend\AttendanceController;
// use App\Http\Controllers\Backend\CompanyController;
// use App\Http\Controllers\Backend\PermissionController;
// use App\Http\Controllers\Backend\UserController;
// use App\Http\Controllers\Backend\CatatanController;
// use App\Http\Controllers\Backend\AuthController;
// use App\Http\Controllers\Backend\ProfileController;
// use App\Http\Controllers\backend\DashboardController;
// use Illuminate\Support\Facades\Route;
// use App\Exports\CatatanExport;
// use App\Http\Controllers\Backend\PublicController;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Http\Controllers\AdminAuthController;
// /*
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register web routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "web" middleware group. Make something great!
// |
// */


// Route::get('/', function () {
//     return view('pages.auth.auth-login');
// });



// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('home', function () {
//         return view('pages.dashboard', ['type_menu' => 'home']);
//     })->name('home');



//     // users
//     Route::resource('users', UserController::class);

//     Route::resource('companies', CompanyController::class);
//     Route::resource('attendances', AttendanceController::class);
//     Route::resource('catatan', CatatanController::class);
//     Route::resource('permissions', PermissionController::class);
// });






// Route::middleware('auth')->group(function(){
//    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
//    Route::put('profile',[ProfileController::class, 'update'])->name('profile.update'); 
// });
// //  catatan 
// Route::middleware(['auth', 'CheckRole:admin'])->prefix('pages')->name('pages.')->group(function(){
//     Route::get('catatans', [CatatanController::class, 'index'])->name('catatans.index');
//     Route::get('catatans/create', [CatatanController::class, 'create'])->name('catatans.create');
//     Route::post('catatans', [CatatanController::class, 'store'])->name('catatans.store');
//     Route::get('catatans/{catatan}/edit', [CatatanController::class, 'edit'])->name('catatans.edit');
//     Route::put('catatans/{catatan}', [CatatanController::class, 'update'])->name('catatans.update');
//     Route::delete('catatans/{catatan}', [CatatanController::class, 'destroy'])->name('catatans.destroy');
// });

// //role user
// Route::middleware(['auth', 'CheckRole:user'])->prefix('user')->name('user.')->group(function(){
//     Route::get('public', [PublicController::class, 'index'])->name('public.index');
//     Route::get('public/create', [PublicController::class, 'create'])->name('public.create');
//     Route::post('public', [PublicController::class, 'store'])->name('public.store');
// });
  

// // // company
// // Route::middleware(['auth'])->group(function () {
// //     Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
// //     Route::get('/companies/show', [CompanyController::class, 'show'])->name('companies.show');
// //     Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
// //     Route::post('/companies/store', [CompanyController::class, 'store'])->name('companies.store');    
// //     Route::get('/companies/edit', [CompanyController::class, 'edit'])->name('companies.edit');
// //     Route::put('/companies/update', [CompanyController::class, 'update'])->name('companies.update');

// //     // Jika ada fitur delete
// //     Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');
// // });
// //register
// Route::view('/register', 'pages.auth.auth-register')->name('register');

// //forgot-password
// Route::view('/forgot-password', 'pages.auth.auth-forgot-password')->name('forgot-password');

// //export data 


// Route::get('/export-catatan', function () {
//     return Excel::download(new CatatanExport, 'catatans.xlsx');
// });




use App\Http\Controllers\ActivityLogController;
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
    ActifityLogController
  
};
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\AdminAuthController;
use App\Exports\CatatanExport;
use App\Http\Middleware\RoleMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\CatatanExportController;

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


    Route::middleware(['auth', 'RoleMiddleware:admin'])->group(function(){
        Route::get('/home');
    });
    Route::middleware(['auth', 'RoleMiddleware:user'])->group(function(){
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





// Role User: diarahkan ke halaman 'public'
Route::middleware(['auth', 'CheckRole:user'])->prefix('user')->name('user.')->group(function () {
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