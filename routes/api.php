<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerpusController;
use App\Models\Perpus;




Route::get('/perpus',[PerpusController::class,'index']);
Route::post('/perpus/store',[PerpusController::class,'store']);
Route::get('/generate-token',[PerpusController::class,'generateToken']);
Route::get('/perpus/{id}', [PerpusController::class, 'show']);
Route::patch('/perpus/update/{id}',[PepusController::class, 'update']);
Route::delete('/perpus/delete/{id}',[PerpusController::class, 'destroy']);
Route::get('/perpus/show/trash', [PerpusController::class, 'trash']);
Route::get('/perpus/trash/restore/{id}', [PerpusController::class, 'restore']);
Route::get('/perpus/trash/delete/permanen/{id}', [PerpusController::class, 'permanenDelete']);