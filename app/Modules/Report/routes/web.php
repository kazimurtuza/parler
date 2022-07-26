<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'manager']], function () {
    Route::get('report/sale', 'SaleReportController@index')->name('admin.sale-report.index');
//    Route::get('report/sale/src', 'SaleReportController@saleSrc')->name('admin.sale.src');

    Route::get('report/employee', 'EmployeeReportController@index')->name('admin.employee-report.index');
//    Route::get('report/employee/src', 'EmployeeReportController@employeeSrc')->name('admin.employee.src');

    Route::get('report/membership/{id}', 'MembershipReportController@index')->name('admin.membership-report.index');

    Route::get('report/ledger/{id}', 'LedgerReportController@index')->name('admin.ledger-report.index');



});

