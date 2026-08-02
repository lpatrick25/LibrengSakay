<?php

use App\Models\SmsRequest;
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

Route::get('/sms-requests', function () {
    return SmsRequest::where('status', 'pending')->get();
});

Route::put('/sms-requests/{id}', function ($id) {
    $sms = SmsRequest::find($id);
    if ($sms) {
        $sms->status = 'sent';
        $sms->save();
        return response()->json(['message' => 'SMS status updated']);
    }
    return response()->json(['message' => 'SMS not found'], 404);
});
