<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'manager']], function () {

    Route::get('employee','EmployeeController@index')->name('admin.employee.index');
    Route::post('store','EmployeeController@store')->name('admin.employee.store');
    Route::post('employee/{id}/update-status/{status?}', 'EmployeeController@updateStatus')->name('admin.employee.update-status');
    Route::get('employee/{id}/edit', 'EmployeeController@edit')->name('admin.employee.edit');
    Route::post('employee/{id}/edit', 'EmployeeController@update')->name('admin.employee.update');
    Route::get('Employee_Delete/{id}', 'EmployeeController@delete');

    Route::get('employee/{id}/details', 'EmployeeController@details')->name('admin.employee.details');

    Route::get('employee/Bulk/delete', 'EmployeeController@bulkDelete')->name('admin.employeeBulk.delete');
});
