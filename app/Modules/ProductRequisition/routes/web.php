<?php

use Illuminate\Support\Facades\Route;

Route::get('product-requisition', 'ProductRequisitionController@welcome');


Route::group(['middleware' => ['auth', 'manager']], function () {
    Route::get('product-requisition', 'ProductRequisitionController@index')->name('admin.productrequisition.index');
    Route::get('product-requisition/add', 'ProductRequisitionController@add')->name('admin.productrequisition.add');
    Route::post('product-requisition/store', 'ProductRequisitionController@store')->name('admin.productrequisition.stor');
    Route::get('product-requisition-list', 'ProductRequisitionController@productRequisitionList')->name('productrequisitionlist');
    Route::get('product-requisition-list/{id}', 'ProductRequisitionController@productRequisitionEdit')->name('admin.productrequisition.edit');
    Route::post('product-requisition-list/{id}/update', 'ProductRequisitionController@update')->name('admin.productrequisition.update');

    Route::get('product-requisition-list/{id}/details', 'ProductRequisitionController@details')->name('admin.productrequisition.details');
    Route::get('product-requisition-list/{id}/status/{status}', 'ProductRequisitionController@status')->name('admin.productrequisition.status');
    Route::get('product-requisition-status-list/{status}', 'ProductRequisitionController@requisitionType')->name('admin.requisition.type');
    Route::post('product-add', 'ProductRequisitionController@productadd')->name('admin.addpriduct.productdata');


//    Route::post('customer/{id}/update-status/{status}', 'CustomerController@updateStatus')->name('admin.customer.update-status');
//    Route::get('customer/{id}/edit', 'CustomerController@edit')->name('admin.customer.edit');
//    Route::post('customer/{id}/edit', 'CustomerController@update')->name('admin.customer.edit');
//
//    Route::get('customer_delete/{id}/delete', 'CustomerController@delete')->name('customer_delete');
});
