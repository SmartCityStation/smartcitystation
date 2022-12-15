<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('type_variables', App\Http\Controllers\API\Backend\Type_variableAPIController::class);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('data_variables', App\Http\Controllers\API\Backend\DataVariableAPIController::class);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('devices', App\Http\Controllers\API\Backend\DeviceAPIController::class);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('villages', App\Http\Controllers\API\Backend\VillageAPIController::class);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('areas', App\Http\Controllers\API\Backend\AreaAPIController::class);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('location_devices', App\Http\Controllers\API\Backend\LocationDeviceAPIController::class);

    Route::post('recordlocation', [App\Http\Controllers\API\Backend\LocationDeviceAPIController::class,'locationRecord']);

    Route::put('updateLocation', [App\Http\Controllers\API\Backend\LocationDeviceAPIController::class,'locationUpdate']);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('variable_devices', App\Http\Controllers\API\Backend\VariableDeviceAPIController::class);
});


Route::group(['prefix' => 'frontend'], function () {
    Route::post('recordmeasures', [App\Http\Controllers\API\Frontend\MeasureAPIController::class, 'measureRecord']);
});

Route::group(['prefix' => 'frontend'], function () {
    Route::post('recordambientaldata', [App\Http\Controllers\API\Frontend\AmbientalAPIController::class, 'ambientalRecord']);
});

Route::group(['prefix' => 'frontend'], function () {
    Route::post('recordoctaveband', [App\Http\Controllers\API\Frontend\OctaveBandAPIController::class, 'octaveBandRecord']);
});

Route::group(['prefix' => 'frontend'], function () {
    Route::post('recordmaterialparticulated', [App\Http\Controllers\API\Frontend\MaterialParticulatedAPIController::class, 'materialRecord']);
});

Route::group(['prefix' => 'backend'], function () {
    Route::resource('event_logs', App\Http\Controllers\API\Backend\EventLogAPIController::class);
});
