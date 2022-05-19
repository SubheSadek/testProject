<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY...

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Information\InformationController;
// use Bugsnag\BugsnagLaravel\Facades\Bugsnag;



Route::group(['prefix'=>'information','middleware'=>'auth'],function (){

    Route::post('/editAdminUser',  [InformationController::class, 'editAdminUser']);
    Route::post('/editAdminPassword',  [InformationController::class, 'editAdminPassword']);
    Route::get('/statistics',  [InformationController::class, 'statistics']);

    Route::get('/getAllInfos',  [InformationController::class, 'getAllInfos']);
    Route::post('/deleteInfo',  [InformationController::class, 'deleteInfo']);
    Route::get('/userDetails/{id}',  [InformationController::class, 'userDetails']);
    Route::post('/deleteSingleInfo',  [InformationController::class, 'deleteSingleInfo']);

});
