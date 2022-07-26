<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('login', 'Auth\LoginController@showLogin')->name('auth.login');
    Route::post('login', 'Auth\LoginController@submitLogin')->name('auth.login');
    Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');

//    Route::group(['middleware' => 'auth'], function () {
//        Route::get('/', function () {
//            return view('admin.index');
//        })->name('admin.index');
//    });

    Route::group(['middleware' => 'auth'], function () {
        Route::post('read-notice', 'Admin\NoticeController@readNotice')->name('admin.read-notice');
        Route::get('/', 'Admin\DashboardController@home')->name('admin.index');
    });
});
/*Route::get('/', function () {
    return view('admin.index');
})->name('admin.index');

Route::get('responsive-datatable', function () {
    return view('admin.responsive-datatable');
})->name('admin.responsive-datatable');

Route::get('button', function () {
    return view('admin.button');
})->name('admin.button');

Route::get('card', function () {
    return view('admin.card');
})->name('admin.card');

Route::get('modals', function () {
    return view('admin.modals');
})->name('admin.modals');

Route::get('cropper', function () {
    return view('admin.cropper');
})->name('admin.cropper');
Route::get('sweetalert', function () {
    return view('admin.sweetalert');
})->name('admin.sweetalert');
Route::get('toastr', function () {
    return view('admin.toastr');
})->name('admin.toastr');
Route::get('light-gallery', function () {
    return view('admin.light-gallery');
})->name('admin.light-gallery');


Route::get('form/ckeditor/classic', function () {
    return view('admin.form.classic-ckeditor');
})->name('admin.form.ckeditor.classic');
Route::get('form/ckeditor/inline', function () {
    return view('admin.form.inline-ckeditor');
})->name('admin.form.ckeditor.inline');
Route::get('form/ckeditor/balloon', function () {
    return view('admin.form.balloon-ckeditor');
})->name('admin.form.ckeditor.balloon');
Route::get('form/ckeditor/balloon-block', function () {
    return view('admin.form.balloon-block-ckeditor');
})->name('admin.form.ckeditor.balloon-block');
Route::get('form/ckeditor/document', function () {
    return view('admin.form.document-ckeditor');
})->name('admin.form.ckeditor.document');

Route::get('form/picker', function () {
    return view('admin.form.picker');
})->name('admin.form.picker');
Route::get('form/form-element', function () {
    return view('admin.form.form-element');
})->name('admin.form.form-element');
Route::get('form/wizard', function () {
    return view('admin.form.wizard');
})->name('admin.form.wizard');
Route::get('form/select2', function () {
    return view('admin.form.select2');
})->name('admin.form.select2');
Route::get('form/noui-slider', function () {
    return view('admin.form.noui-slider');
})->name('admin.form.noui-slider');
Route::get('form/nestable', function () {
    return view('admin.form.nestable');
})->name('admin.form.nestable');
Route::get('form/dropify', function () {
    return view('admin.form.dropify');
})->name('admin.form.dropify');


Route::get('blank', function () {
    return view('admin.blank');
})->name('admin.blank');

Route::get('login', function () {
    return view('admin.auth.login');
})->name('admin.auth.login');
Route::get('lock', function () {
    return view('admin.auth.lock');
})->name('admin.auth.lock');

Route::get('error/400', function () {
    return view('admin.error.400');
});
Route::get('error/403', function () {
    return view('admin.error.403');
});
Route::get('error/404', function () {
    return view('admin.error.404');
});
Route::get('error/500', function () {
    return view('admin.error.500');
});
Route::get('error/503', function () {
    return view('admin.error.503');
});*/
