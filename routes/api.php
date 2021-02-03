<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\Auth\LoginController')->name('login');

Route::middleware(['auth:api-student,api-employee'])->group(function () {
    Route::post('logout', 'Api\Auth\LogoutController')->name('logout');
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    // Admin routes
    Route::middleware(['api-admin'])->group(function () {
        // Acquisition routes

        // Batch routes
        Route::group(['prefix' => 'batch'], static function () {
            Route::get('index', 'Api\Acquisition\Batch\ShowController@index');
            Route::get('show/{id}', 'Api\Acquisition\Batch\ShowController@show');
            Route::get('last-created', 'Api\Acquisition\Batch\ShowController@lastCreated');
            Route::get('sort-fields', 'Api\Acquisition\Batch\ShowController@sortFields');
            Route::get('search-fields', 'Api\Acquisition\Batch\ShowController@searchFields');

            Route::post('create', 'Api\Acquisition\Batch\ManageController@create');
            Route::put('update', 'Api\Acquisition\Batch\ManageController@update');
            Route::delete('delete/{id}', 'Api\Acquisition\Batch\ManageController@delete');

            Route::post('search', 'Api\Acquisition\Batch\SearchController@search');

            Route::get('numbers', 'Api\Acquisition\Batch\AdditionalController@numbers');
            Route::get('status/{id}', 'Api\Acquisition\Batch\AdditionalController@status');
            Route::get('statuses', 'Api\Acquisition\Batch\AdditionalController@statuses');
        });

        // Supplier routes
        Route::group(['prefix' => 'supplier'], static function () {
            Route::get('index', 'Api\Acquisition\Supplier\ShowController@index');
            Route::get('show/{id}', 'Api\Acquisition\Supplier\ShowController@show');
            Route::get('last-created', 'Api\Acquisition\Supplier\ShowController@lastCreated');
            Route::get('sort-fields', 'Api\Acquisition\Supplier\ShowController@sortFields');
            Route::get('search-fields', 'Api\Acquisition\Supplier\ShowController@searchFields');

            Route::post('create', 'Api\Acquisition\Supplier\ManageController@create');
            Route::put('update', 'Api\Acquisition\Supplier\ManageController@update');
            Route::delete('delete/{id}', 'Api\Acquisition\Supplier\ManageController@delete');

            Route::post('search', 'Api\Acquisition\Supplier\SearchController@search');
            Route::post('autocomplete', 'Api\Acquisition\Supplier\SearchController@autocomplete');

            Route::get('names', 'Api\Acquisition\Supplier\AdditionalController@names');
            Route::get('types', 'Api\Acquisition\Supplier\AdditionalController@types');
        });

        // Publisher routes
        Route::group(['prefix' => 'publisher'], static function () {
            Route::get('index', 'Api\Acquisition\Publisher\ShowController@index');
            Route::get('show/{id}', 'Api\Acquisition\Publisher\ShowController@show');
            Route::get('last', 'Api\Acquisition\Publisher\ShowController@last');
            Route::get('last-created', 'Api\Acquisition\Publisher\ShowController@lastCreated');
            Route::get('sort-fields', 'Api\Acquisition\Publisher\ShowController@sortFields');
            Route::get('search-fields', 'Api\Acquisition\Publisher\ShowController@searchFields');

            Route::post('create', 'Api\Acquisition\Publisher\ManageController@create');
            Route::put('update', 'Api\Acquisition\Publisher\ManageController@update');
            Route::delete('delete/{id}', 'Api\Acquisition\Publisher\ManageController@delete');

            Route::post('search', 'Api\Acquisition\Publisher\SearchController@search');
            Route::post('autocomplete', 'Api\Acquisition\Publisher\SearchController@autocomplete');

            Route::get('names', 'Api\Acquisition\Publisher\AdditionalController@names');
        });

        // Item routes
        Route::group(['prefix' => 'item'], static function () {
            Route::get('index', 'Api\Acquisition\Item\ShowController@index');
            Route::get('show/{id}', 'Api\Acquisition\Item\ShowController@show');
            Route::get('last', 'Api\Acquisition\Item\ShowController@last');
            Route::get('last-created', 'Api\Acquisition\Item\ShowController@lastCreated');
            Route::get('sort-fields', 'Api\Acquisition\Item\ShowController@sortFields');
            Route::get('search-fields', 'Api\Acquisition\Item\ShowController@searchFields');

            Route::post('create', 'Api\Acquisition\Item\ManageController@create');
            Route::put('update', 'Api\Acquisition\Item\ManageController@update');
            Route::delete('delete/{id}', 'Api\Acquisition\Item\ManageController@delete');

            Route::post('search', 'Api\Acquisition\Item\SearchController@search');

            Route::get('create-data', 'Api\Acquisition\Item\AdditionalController@createData');
        });
    });
});

Route::get('locale/{locale}', 'Api\LocaleController');

// Media routes
Route::group(['prefix' => 'media'], function () {
    Route::get('search/autocomplete', 'Api\Media\AutocompleteController@autocomplete');
    Route::post('search/{searchType}', 'Api\Media\SearchController@search')->where('searchType', 'simple|advanced');

    Route::get('show', 'Api\Media\ShowController@show');
    Route::post('save-excel', 'Api\Media\ExportController@export');
    Route::get('search-fields', 'Api\Media\ShowController@searchFields');
    Route::get('sort-fields', 'Api\Media\ShowController@sortFields');
});
