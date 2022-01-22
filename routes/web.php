<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PasokanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PasswordController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
})->name('relogin');

Route::get('logout', [AuthController::class, 'index'])->name('logout');

Route::get('forgot-password', [PasswordController::class, 'forgot'])->name('forgot');
Route::post('forgot-password/request', [PasswordController::class, 'newPassword'])->name('newPassword');
Route::get('forgot-password/{id}', [PasswordController::class, 'reset'])->name('reset');
Route::post('forgot-password/change/{id}', [PasswordController::class, 'change'])->name('change');
Route::get('information', [PasswordController::class, 'done'])->name('information');

Route::get('/verification', function () {
    return view('dashboard.verif');
})->name('verification');

Route::post('verification/post', [ProfileController::class, 'valided'])->name('valided_email');

    
    Route::group(['middleware' => ['auth','revalidate']], function()
    {
        Route::group(['middleware' => ['auth','verification']], function () {

            Route::get('registered_password', function () {
                return view('dashboard.password');
            })->name('registerd');

            Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
                $pegawai = DB::table('pegawais')->where('role_id', 2)->count();
                $order = DB::table('orders')->count();
                $barang = DB::table('barangs')->count();
                $online = DB::table('sessions')->get();
                $year = date('Y');
                
                return view('dashboard.index', compact('pegawai', 'order', 'barang', 'online', 'year'));
            })->name('dashboard');
            
            Route::group(['profile' => 'user'], function () {
                Route::get('profile', [ProfileController::class, 'index'])->name('profile');
                Route::post('profile/edited', [ProfileController::class, 'edited'])->name('edited_profile');
                Route::get('ganti_password', [ProfileController::class, 'ganti'])->name('ganti_password');
                Route::post('password_update', [ProfileController::class, 'update'])->name('update_password');
            });

            Route::group(['pegawai' => 'admin'], function () {
                Route::get('pegawai_kasir', [PegawaiController::class, 'index'])->name('show_pegawai');
                Route::get('pegawai_kasir/add', [PegawaiController::class, 'add'])->name('add_pegawai');
                Route::post('pegawai_kasir/add/post', [PegawaiController::class, 'post'])->name('post_pegawai');
                Route::post('pegawai_kasir/delete/{id}', [PegawaiController::class, 'delete'])->name('del_pegawai');
                Route::get('pegawai_kasir/ijazah/{name}', [PegawaiController::class, 'ijazah'])->name('read_ijazah');
                Route::post('pegawai/kasir/{id}', [PegawaiController::class, 'edited'])->name('edited_pegawai');
                Route::post('pegawai/kasir/update_status/{id}', [PegawaiController::class, 'status'])->name('update_status');
            });

            Route::group(['barang' => 'pegawai'], function () {
                Route::get('pasokan', [PasokanController::class, 'index'])->name('pasokan');
                Route::get('pasokan/add', [PasokanController::class, 'add'])->name('add_pasokan');
                Route::post('pasokan/add/post', [PasokanController::class, 'post'])->name('post_pasokan');
                Route::post('pasokan/edited/{id}', [PasokanController::class, 'edited'])->name('edited_pasokan');
                Route::post('pasokan/hapus/{id}', [PasokanController::class, 'delete'])->name('delete_pasokan');
                Route::post('pasokan/verif/{id}', [PasokanController::class, 'verif'])->name('verif_pasokan');
            });

            Route::group(['order' => 'pegawai'], function () {
                Route::get('order', [OrderController::class, 'index'])->name('order');
                Route::get('order/detail/{id}', [OrderController::class, 'detail'])->name('detail_pesanan');
                Route::get('order/new_order/q={page}', [OrderController::class, 'new_customer'])->name('new_customer');
                Route::post('order/new_order/post/{ex}', [OrderController::class, 'post'])->name('post_orderan');
                Route::get('order/new_orders/q={page}', [OrderController::class, 'old_customer'])->name('old_customer');
            });

            Route::group(['menu' => 'admin'], function () {
                Route::get('menu', [MenuController::class, 'index'])->name('menu');
                Route::post('menu/add', [MenuController::class, 'add'])->name('add_menu');
                Route::post('menu/edit/{id}', [MenuController::class, 'status'])->name('status');
                Route::post('menu/edit_menu/{id}', [MenuController::class, 'edit'])->name('edit_menu');
            });

        });
    });

    Route::group(['konfirmasi' => 'customer'], function () {
        Route::get('konfirmasi_pesanan/{id}', [OrderController::class, 'confirm'])->name('konfirmasi');
        Route::post('konfirmasi_pesanan/post/{id}', [OrderController::class, 'confirmed'])->name('confirmed');
        Route::get('notifikasi_pesanan/{id}', [OrderController::class, 'notif'])->name('notif');
        Route::get('invoice/{id}', [OrderController::class, 'invoice'])->name('invoice');
    });
    
        
