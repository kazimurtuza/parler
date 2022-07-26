<?php

use Illuminate\Support\Facades\Route;

Route::get('product', 'ProductController@welcome');

Route::group(['middleware' => ['auth', 'manager']], function () {
    Route::get('product', 'ProductController@index')->name('admin.product.index');
    Route::post('product/store', 'ProductController@store')->name('admin.product.store');
    Route::post('product/{id}/update-status/{status?}', 'ProductController@updateStatus')->name('admin.product.update-status');
    Route::get('product/{id}/edit', 'ProductController@edit')->name('admin.product.edit');
    Route::post('product/{id}/edit', 'ProductController@update')->name('admin.product.edit');
    Route::get('product_delete/{id}/delete', 'ProductController@delete')->name('product_delete');
    Route::get('product/bulk/delete', 'ProductController@bulkDelete')->name('admin.productBulk.delete');
    Route::post('product/import', 'ProductController@productImport')->name('admin.product.import');
});
