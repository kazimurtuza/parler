<?php

use Illuminate\Support\Facades\Route;

Route::get('vat-tax-setting', 'VatTaxSettingController@welcome');

Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('admin/vat/setting', 'VatTaxSettingController@index')->name('admin.vat.index');
    Route::post('admin/vat/setting', 'VatTaxSettingController@store')->name('admin.vat.store');
    Route::post('admin/vat/setting/{id}/update-status/{status?}', 'VatTaxSettingController@updateStatus')->name('admin.vat.update-status');
    Route::get('admin/vat/setting/{id}/edit', 'VatTaxSettingController@edit')->name('admin.vat.edit');
    Route::post('admin/vat/setting/{id}/edit', 'VatTaxSettingController@update')->name('admin.vat.update');
});
