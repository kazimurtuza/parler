<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'manager'], function () {
    Route::get('bank-account', 'BankAccountController@index')->name('admin.bank-account.index');
    Route::post('bank-account/store', 'BankAccountController@store')->name('admin.bank-account.store');
    Route::get('bank-account/{id}/edit', 'BankAccountController@edit')->name('admin.account-balance.edit');
    Route::post('bank-account/{id}/edit', 'BankAccountController@update')->name('admin.account-balance.edit');
});