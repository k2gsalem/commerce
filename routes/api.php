<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['middleware' => ['throttle:60,1', 'bindings'], 'namespace' => 'App\Http\Controllers'], function ($api) {

        $api->get('ping', 'Api\PingController@index');
        $api->post('member/register', 'Api\Users\UsersController@store');
        $api->get('assets/{uuid}/render', 'Api\Assets\RenderFileController@show');

        $api->group(['middleware' => ['auth:api'], ['role:Administrator']], function ($api) {

            $api->group(['prefix' => 'users'], function ($api) {
                $api->get('/', 'Api\Users\UsersController@index');
                $api->post('/', 'Api\Users\UsersController@store');
                $api->get('/{uuid}', 'Api\Users\UsersController@show');
                $api->put('/{uuid}', 'Api\Users\UsersController@update');
                $api->patch('/{uuid}', 'Api\Users\UsersController@update');
                $api->delete('/{uuid}', 'Api\Users\UsersController@destroy');
            });

            $api->group(['prefix' => 'roles'], function ($api) {
                $api->get('/', 'Api\Users\RolesController@index');
                $api->post('/', 'Api\Users\RolesController@store');
                $api->get('/{uuid}', 'Api\Users\RolesController@show');
                $api->put('/{uuid}', 'Api\Users\RolesController@update');
                $api->patch('/{uuid}', 'Api\Users\RolesController@update');
                $api->delete('/{uuid}', 'Api\Users\RolesController@destroy');
            });

            $api->get('permissions', 'Api\Users\PermissionsController@index');

            $api->group(['prefix' => 'me'], function ($api) {
                $api->get('/', 'Api\Users\ProfileController@index');
                $api->put('/', 'Api\Users\ProfileController@update');
                $api->patch('/', 'Api\Users\ProfileController@update');
                $api->put('/password', 'Api\Users\ProfileController@updatePassword');
            });

            $api->group(['prefix' => 'assets'], function ($api) {
                $api->post('/', 'Api\Assets\UploadFileController@store');
                $api->delete('/{uuid}', 'Api\Assets\UploadFileController@destroy');
            });
            $api->resource('confStatus', 'Api\Config\ConfStatusController');
            $api->resource('confSupplierCat', 'Api\Config\ConfSupplierCatController');
            $api->resource('confVendorCat', 'Api\Config\ConfVendorCatController');
            $api->resource('prodCat', 'Api\Config\ProdCatController');
            $api->resource('prodSubCat', 'Api\Config\ProdSubCatController');
            $api->resource('vendors', 'Api\Vendor\VendorController');
            $api->resource('vendorStores', 'Api\Vendor\VendorStoreController');
            $api->resource('suppliers', 'Api\Vendor\SupplierController');

            $api->resource('item', 'Api\Catalogue\ItemController');
            $api->resource('itemVariant', 'Api\Catalogue\ItemVariantController');
            $api->resource('itemVariantGroup', 'Api\Catalogue\ItemVariantGroupController');                                                             
            $api->resource('stockMaster', 'Api\Stock\StockMasterController');
            $api->resource('stockTracker', 'Api\Stock\StockTrackerController');

            $api->group(['prefix' => 'member'], function ($api) {
                $api->group(['prefix' => 'me'], function ($api) {
                    $api->get('/', 'Api\Users\ProfileController@index');
                    $api->put('/', 'Api\Users\ProfileController@update');
                    $api->patch('/', 'Api\Users\ProfileController@update');
                    $api->put('/password', 'Api\Users\ProfileController@updatePassword');
                });
            });
        });

        $api->group(['prefix' => 'member'], function ($api) {

            $api->get('/confStatus/{confStatus}', 'Api\Config\ConfStatusController@show');
            $api->get('/prodCat', 'Api\Config\ProdCatController@index');
            $api->get('/prodCat/{prodCat}', 'Api\Config\ProdCatController@show');

            $api->get('/prodSubCat', 'Api\Config\ProdSubCatController@index');
            $api->get('/prodSubCat/{prodSubCat}', 'Api\Config\ProdSubCatController@show');

            $api->get('/item', 'Api\Catalogue\ItemController@index');
            $api->get('/item/{item}', 'Api\Catalogue\ItemController@show');

            $api->get('/itemVariant', 'Api\Catalogue\ItemVariantController@index');
            $api->get('/itemVariant/{itemVariant}', 'Api\Catalogue\ItemVariantController@show');

            // $api->get('/stock/{stock}', 'Api\Stock\StockMasterController@show');
            $api->get('/vendor/{vendor}', 'Api\Vendor\VendorController@show');
        });
    });
});
