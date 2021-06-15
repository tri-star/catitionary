<?php

use App\Http\Controllers\Api\Cat\CatCharactericsAction;
use App\Http\Controllers\Api\Cat\CatTypesAction;
use App\Http\Controllers\Api\Name\SubmitNameAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/cat')->group(function () {
    Route::get('/types', [CatTypesAction::class, 'invoke']);
    Route::get('/characterics', [CatCharactericsAction::class, 'invoke']);
});

Route::post('/names', [SubmitNameAction::class, 'invoke']);

Route::prefix('/internal')->group(function () {
    Route::post('/auth/register', [\App\Http\Controllers\Api\Internal\Auth\RegisterAction::class, 'invoke']);
    Route::get('/auth/verify-email', [\App\Http\Controllers\Api\Internal\Auth\VerifyEmailAction::class, 'invoke']);
    Route::get('/user/exists', [\App\Http\Controllers\Api\Internal\User\ExistAction::class, 'invoke']);
});
