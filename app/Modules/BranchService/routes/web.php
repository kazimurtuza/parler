<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth', 'manager']], function () {
    Route::get('branch_service', 'BranchServiceController@index')->name('admin.branch_service.index');
    Route::post('branch_service/store', 'BranchServiceController@store')->name('admin.branch_service.store');
    Route::post('branch_service/{id}/update-status/{status?}', 'BranchServiceController@updateStatus')->name('admin.branch_service.update-status');
    Route::get('branch_service/{id}/edit', 'BranchServiceController@edit')->name('admin.branch_service.edit');
    Route::post('branch_service/{id}/edit', 'BranchServiceController@update')->name('admin.branch_service.edit');
    Route::get('branch_service_delete/{id}/delete', 'BranchServiceController@delete')->name('branch_service_delete');
    Route::get('branch_service/Bulk/delete', 'BranchServiceController@bulkDelete')->name('admin.branch-serviceBulk.delete');
    Route::get('branch_service/list', 'BranchServiceController@branchServicesList')->name('admin.branch-services.list');

});
