<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'store_keeper']], function () {
    Route::post('product-store-inventory/purchase', 'ProductInventoryController@storeInventory')->name('admin.inventory.store');
    Route::get('product-use', 'ProductInventoryController@productUse')->name('admin.product.use');

    Route::get('staff', 'ProductInventoryController@staffGet')->name('admin.staff.get');
    Route::post('use-product-store', 'ProductInventoryController@sotreUseproduct')->name('admin.use_product.store');
    Route::get('product-quantity', 'ProductInventoryController@getAvailableQty')->name('admin.product.quantity');

    Route::get('product-available-product','ProductInventoryController@availableProductList')->name('admin.availableProduct');
    Route::get('product-available_list','ProductInventoryController@getAvailableProductList')->name('admin.getAvailableProduct');
});
