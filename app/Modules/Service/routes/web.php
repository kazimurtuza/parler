<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'manager']], function () {
    Route::get('service', 'ServiceController@index')->name('admin.service.index');
    Route::post('service/store', 'ServiceController@store')->name('admin.service.store');
    Route::post('service/{id}/update-status/{status?}', 'ServiceController@updateStatus')->name('admin.service.update-status');
    Route::get('service/{id}/edit', 'ServiceController@edit')->name('admin.service.edit');
    Route::post('service/{id}/edit', 'ServiceController@update')->name('admin.service.edit');

    Route::get('service_delete/{id}/delete', 'ServiceController@delete')->name('service_delete');

    Route::get('service/bulk/delete', 'ServiceController@bulkDelete')->name('admin.bulkDelete.delete');
    Route::post('service/import', 'ServiceController@serviceImport')->name('admin.service.import');
});

