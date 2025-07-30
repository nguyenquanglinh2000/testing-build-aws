<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/log-test', function (Request $request) {
    Log::info('Log test from Postman', [
        'body' => $request->all(),
    ]);
    return response()->json(['message' => 'Log saved']);
});
Route::get('/users', [UserController::class, 'index']);
