<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\VoucherCodeController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    return ['token' => $user->createToken('api-token')->plainTextToken];
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/voucher-codes', [VoucherCodeController::class, 'index']);
    Route::post('/voucher-codes', [VoucherCodeController::class, 'generate']);
    Route::delete('/voucher-codes/{id}', [VoucherCodeController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
