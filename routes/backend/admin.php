<?php

use App\Http\Controllers\Backend\DashboardController;
use Tabuna\Breadcrumbs\Trail;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));   
    });

 //Vista usuarios 
 Route::get('users', [App\Http\Controllers\Backend\UserController::class, 'index'])->name('users.index');

Route::resource('typeVariables', App\Http\Controllers\Backend\Type_variableController::class);
Route::resource('dataVariables', App\Http\Controllers\Backend\DataVariableController::class);
Route::resource('devices', App\Http\Controllers\Backend\DeviceController::class);
Route::resource('villages', App\Http\Controllers\Backend\VillageController::class);
Route::resource('areas', App\Http\Controllers\Backend\AreaController::class);
Route::resource('locationDevices', App\Http\Controllers\Backend\LocationDeviceController::class);
Route::resource('variableDevices', App\Http\Controllers\Backend\VariableDeviceController::class);
Route::resource('eventLogs', App\Http\Controllers\Backend\EventLogController::class);

Route::get('customers', [App\Http\Controllers\Backend\CustomerController::class, 'index'])->name('customers.index');
Route::get('customers/{id}', [App\Http\Controllers\Backend\CustomerController::class, 'show'])->name('customers.show');

Route::resource('projects', App\Http\Controllers\Backend\ProjectController::class);

Route::get('project/getTypeVariables', [App\Http\Controllers\Backend\ProjectController::class, 'getTypeVariables'])->name('getTypeVariables');
Route::get('project/getDataVariables', [App\Http\Controllers\Backend\ProjectController::class, 'getDataVariables'])->name('getDataVariables');
Route::get('project/getDataVariableForTv', [App\Http\Controllers\Backend\ProjectController::class, 'getDataVariableForTv'])->name('getDataVariableForTv');

Route::get('project/variableForTypeVariable', [App\Http\Controllers\Backend\ProjectController::class, 'variableForTypeVariable'])->name('variableForTypeVariable');






