<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'manager']], function () {
    Route::get('service-invoice', 'InvoiceController@index')->name('admin.invoice.index');
    Route::get('invoice-create', 'InvoiceController@create')->name('admin.invoice.create');
    Route::post('invoice-store', 'InvoiceController@store')->name('admin.invoice.store');
    Route::get('invoice-branch-data', 'InvoiceController@invBranchData')->name('admin.branch_wise.data');
    Route::get('invoice-edit/{id}', 'InvoiceController@edit')->name('admin.inv.edit');
    Route::get('invoice-details/{id}', 'InvoiceController@details')->name('admin.invoice.details');
    Route::get('invoice/{id}/pdf', 'InvoiceController@printPDF')->name('admin.invoice.pdf');
    Route::post('invoice-update', 'InvoiceController@update')->name('admin.invoice.update');

//    pos
    Route::get('pos', 'PosController@pos')->name('admin.pos');
    Route::get('pos/branch-product', 'PosController@posBranchProduct')->name('admin.pos.product');
    Route::get('pos/branch-product-src', 'PosController@posProductSrc')->name('admin.pos.productsrc');
    Route::post('pos/store', 'PosController@store')->name('admin.store_pos');

});
