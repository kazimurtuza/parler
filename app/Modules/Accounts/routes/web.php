<?php

use Illuminate\Support\Facades\Route;

Route::get('accounts', 'AccountsController@welcome');


Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'admin'], function () {
        //   category
        Route::get('expense/category', 'ExpenseCategoryController@index')->name('admin.expenseCategory.index');
        Route::post('expense/category', 'ExpenseCategoryController@store')->name('admin.expenseCategory.store');
        Route::post('expense/category/{id}/update-status/{status}', 'ExpenseCategoryController@updateStatus')->name('admin.expenseCategory.update-status');
        Route::get('expense/category/{id}/edit', 'ExpenseCategoryController@edit')->name('admin.expenseCategory.edit');
        Route::post('expense/category/{id}/edit', 'ExpenseCategoryController@update')->name('admin.expenseCategory.update');

        //    sub category
        Route::get('expense/subcategory', 'ExpenseSubCategoryController@index')->name('admin.expenseSubcategory.index');
        Route::post('expense/subcategory', 'ExpenseSubCategoryController@store')->name('admin.expenseSubcategory.store');
        Route::post('expense/subcategory/{id}/update-status/{status}', 'ExpenseSubCategoryController@updateStatus')->name('admin.expenseSubcategory.update-status');
        Route::get('expense/subcategory/{id}/edit', 'ExpenseSubCategoryController@edit')->name('admin.expenseSubcategory.edit');
        Route::post('expense/subcategory/{id}/edit', 'ExpenseSubCategoryController@update')->name('admin.expenseSubcategory.update');

    });

    Route::group(['middleware' => 'manager'], function () {
        //    Expense
        Route::get('expense', 'ExpenseController@index')->name('admin.expense.index');
        Route::post('expense', 'ExpenseController@store')->name('admin.expense.store');
        Route::post('expense/{id}/update-status/{status}', 'ExpenseController@updateStatus')->name('admin.expense.update-status');
        Route::get('expense/{id}/edit', 'ExpenseController@edit')->name('admin.expense.edit');
        Route::post('expense/{id}/edit', 'ExpenseController@update')->name('admin.expense.update');

        Route::get('expense-employee', 'ExpenseController@getEmployee')->name('Admin.EmployeeByBranch.get');
        Route::get('expense-subcategory', 'ExpenseController@getSubcategory')->name('Admin.subcategory.get');
    });
});
