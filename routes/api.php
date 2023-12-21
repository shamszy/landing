<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\LicenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\VerifyAccountController;
use App\Http\Controllers\Api\ForgotPasswordController;

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

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function ($router) {

    Route::controller(VerifyAccountController::class)->group(function () { //otp verification and resent routes
        Route::post('verify-otp', 'verifyMethod');
        Route::post('resend-otp', 'reSendOtpMethod');
    });

    Route::controller(ForgotPasswordController::class)->group(function () { // forgot password routes
        Route::post('password-email',  'send');
        Route::post('password-reset',  'reset');
    });

    Route::group(['middleware' => ['jwt.verify']], function () { //only authenticated users have access to this routes

        Route::controller(AuthController::class)->group(function () { // auth routes
            Route::post('logout',  'logout');
            Route::get('profiles', 'userProfile');
            Route::post('login','login')->withoutMiddleware(['jwt.verify']);
            Route::post('refresh', 'refreshAuthToken');
        });

        Route::controller(CompanyController::class)->group(function () { // companies routes
            Route::post('companies',  'store')->withoutMiddleware(['jwt.verify']);
            Route::get('companies', 'index')->middleware(['is.admin']);
            Route::get('companies/{slug}', 'show');
            Route::patch('companies/{slug}', 'update');
            Route::delete('companies/{slug}', 'destroy')->middleware(['is.admin']);
        });

        Route::controller(DocumentController::class)->group(function () { // documents routes
            Route::post('documents',  'store');
            Route::get('documents', 'index');
            Route::get('documents/{slug}', 'show');
            Route::patch('documents/{slug}', 'update');
            Route::delete('documents/{slug}', 'destroy')->middleware(['is.admin']);
        });

        Route::controller(LicenseController::class)->group(function () { // licenses routes
            Route::post('licenses',  'store');
            Route::get('licenses', 'index');
            Route::get('licenses/{slug}', 'show');
            Route::patch('licenses/{slug}', 'update');
            Route::delete('licenses/{slug}', 'destroy')->middleware(['is.admin']);
        });

        Route::controller(CategoryController::class)->group(function () { // categories routes
            Route::post('categories',  'store')->middleware(['admin']);
            Route::get('categories', 'index');
            Route::get('categories/{slug}', 'show')->middleware(['is.admin']);
            Route::patch('categories/{slug}', 'update')->middleware(['is.admin']);
            Route::delete('categories/{slug}', 'destroy')->middleware(['is.admin']);
        });

        Route::controller(SettingsController::class)->group(function () { // settings routes
            Route::put('change-password', 'changePasswordMethod');
            Route::post('suspend-and-activate-account', 'suspendAndActivateUserAccountMethod')->middleware(['is.admin']);
            Route::post('upload-image', 'uploadImageMethod');
        });

    }); //end of authenticated routes


}); //end of v1 routes
