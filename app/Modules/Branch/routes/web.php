<?php

use Illuminate\Support\Facades\Route;

//Route::get('branch', 'BranchController@welcome');


Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('branch', 'BranchController@index')->name('admin.branch.index');
    Route::post('branch', 'BranchController@store')->name('admin.branch.store');
    Route::post('branch/{id}/update-status/{status?}', 'BranchController@updateStatus')->name('admin.branch.update-status');
    Route::get('branch/{id}/edit', 'BranchController@edit')->name('admin.branch.edit');
    Route::post('branch/{id}/edit', 'BranchController@update')->name('admin.branch.update');
});

