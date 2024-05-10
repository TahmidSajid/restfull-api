<?php

use App\Http\Controllers\EmployessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('employee/add',[EmployessController::class,'add_employee']);
Route::put('employee/update/{id}',[EmployessController::class,'update_employee']);
Route::delete('employee/delete/{id}',[EmployessController::class,'delete_employee']);
