<?php
/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::group(['middleware' => ['auth', 'password.expires', config('boilerplate.access.middleware.verified')]], function () {

    Route::get('measures/measureindex', [App\Http\Controllers\Frontend\MeasureController::class, 'measureIndex'])->name('measures.measureIndex');
    Route::get('variabletype/getvariabletype', [App\Http\Controllers\Backend\Type_variableController::class, 'getVariableType'])->name('variabletype.getvariabletype');
    Route::get('variabletype/getvariabletypeforproj', [App\Http\Controllers\Backend\Type_variableController::class, 'getVariableTypeForProj'])->name('variabletype.getvariabletypeforproj');
    Route::get('variabledata/getvariabledata', [App\Http\Controllers\Backend\DataVariableController::class, 'getVariableData'])->name('variabledata.getvariabledata');
    Route::get('measure/showmeasures', [App\Http\Controllers\Frontend\MeasureController::class, 'showMeasures'])->name('measure.showmeasures');
    Route::get('project/getproject', [App\Http\Controllers\Frontend\MeasureCustomerController::class, 'getProject'])->name('getProject');

    //Route for view with map a graphics to visitor.
    Route::get('index/measure', [App\Http\Controllers\Frontend\MeasureVisitorController::class, 'index'])->name('index.measure');

    //Routes for view customer with Projects.
    Route::get('index/customer-project', [App\Http\Controllers\Frontend\MeasureCustomerController::class, 'index'])->name('customer.measure');
    Route::get('projects/getProjects', [App\Http\Controllers\Backend\ProjectController::class, 'getProject'])->name('project.getprojectsuser');
    Route::get('projects/getProjectid', [App\Http\Controllers\Backend\ProjectController::class, 'getProject'])->name('project.getprojectid');

    Route::get('exportMeasure', [App\Http\Controllers\Frontend\MeasureController::class, 'exportMeasures'])->name('exportMeasure');
});
