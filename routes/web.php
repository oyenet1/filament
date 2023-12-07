<?php

use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/tes', function () {
//     return DB::table('schools')
//         ->where('status', 'active')
//         ->selectRaw('YEAR(created_at) as year, COUNT(*) as total')
//         ->groupByRaw('YEAR(created_at)')->orderBy('year')
//         ->pluck('total', 'year')->toArray();
// });

// Route::get('/login', function () {
//     return redirect()->route('filament.admin.auth.login');
// });