<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'manager']], function () {
    Route::get('customer', 'CustomerController@index')->name('admin.customer.index');
    Route::post('customer/store', 'CustomerController@store')->name('admin.customer.store');
    Route::post('customer/add', 'CustomerController@customerAjaxStore')->name('admin.customer.ajaxadd');
    Route::post('customer/{id}/update-status/{status?}', 'CustomerController@updateStatus')->name('admin.customer.update-status');
    Route::get('customer/{id}/edit', 'CustomerController@edit')->name('admin.customer.edit');
    Route::post('customer/{id}/edit', 'CustomerController@update')->name('admin.customer.edit');

    Route::get('customer_delete/{id}/delete', 'CustomerController@delete')->name('customer_delete');
    Route::get('customer/bulk/delete', 'CustomerController@bulkDelete')->name('admin.customerBulk.delete');
});
