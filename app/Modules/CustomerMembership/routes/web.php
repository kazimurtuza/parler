<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('customer-membership', 'CustomerMembershipController@index')->name('admin.customermember.index');
    Route::post('customer-membership/store', 'CustomerMembershipController@store')->name('admin.customermember.store');
    Route::post('customer-membership/{id}/update-status/{status?}', 'CustomerMembershipController@updateStatus')->name('admin.membership.update-status');
    Route::get('customer-membership/{id}/edit', 'CustomerMembershipController@edit')->name('admin.membership.edit');
    Route::post('customer-membership/{id}/edit', 'CustomerMembershipController@update')->name('admin.membership.edit');

    Route::get('Membership_Delete/{id}', 'CustomerMembershipController@delete');
});
