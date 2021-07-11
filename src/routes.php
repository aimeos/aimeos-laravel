<?php

if( ( $conf = config( 'shop.routes.admin', ['prefix' => 'admin', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET' ), '', array(
			'as' => 'aimeos_shop_admin',
			'uses' => 'Aimeos\Shop\Controller\AdminController@indexAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.jqadm', ['prefix' => 'admin/{site}/jqadm', 'middleware' => ['web', 'auth']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET' ), 'file/{type}', array(
			'as' => 'aimeos_shop_jqadm_file',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@fileAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET' ), 'copy/{resource}/{id}', array(
			'as' => 'aimeos_shop_jqadm_copy',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@copyAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

		Route::match( array( 'GET' ), 'create/{resource}', array(
			'as' => 'aimeos_shop_jqadm_create',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@createAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

		Route::match( array( 'POST' ), 'delete/{resource}/{id?}', array(
			'as' => 'aimeos_shop_jqadm_delete',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@deleteAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

		Route::match( array( 'GET', 'POST' ), 'export/{resource}', array(
			'as' => 'aimeos_shop_jqadm_export',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@exportAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

		Route::match( array( 'GET' ), 'get/{resource}/{id}', array(
			'as' => 'aimeos_shop_jqadm_get',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@getAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

		Route::match( array( 'POST' ), 'save/{resource}', array(
			'as' => 'aimeos_shop_jqadm_save',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@saveAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

		Route::match( array( 'GET', 'POST' ), 'search/{resource}', array(
			'as' => 'aimeos_shop_jqadm_search',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@searchAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

	});
}


if( ( $conf = config( 'shop.routes.jsonadm', ['prefix' => 'admin/{site}/jsonadm', 'middleware' => ['web', 'auth']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'DELETE' ), '{resource}/{id?}', array(
			'as' => 'aimeos_shop_jsonadm_delete',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@deleteAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

		Route::match( array( 'GET' ), '{resource}/{id?}', array(
			'as' => 'aimeos_shop_jsonadm_get',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@getAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

		Route::match( array( 'PATCH' ), '{resource}/{id?}', array(
			'as' => 'aimeos_shop_jsonadm_patch',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@patchAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

		Route::match( array( 'POST' ), '{resource}/{id?}', array(
			'as' => 'aimeos_shop_jsonadm_post',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@postAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

		Route::match( array( 'PUT' ), '{resource}/{id?}', array(
			'as' => 'aimeos_shop_jsonadm_put',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@putAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]+' ) );

		Route::match( array( 'OPTIONS' ), '{resource?}', array(
			'as' => 'aimeos_shop_jsonadm_options',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@optionsAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] )->where( array( 'resource' => '[a-z\/]*' ) );

	});
}


if( ( $conf = config( 'shop.routes.jsonapi', ['prefix' => 'jsonapi', 'middleware' => ['web', 'api']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'DELETE' ), '{resource}', array(
			'as' => 'aimeos_shop_jsonapi_delete',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@deleteAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET' ), '{resource}', array(
			'as' => 'aimeos_shop_jsonapi_get',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@getAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'PATCH' ), '{resource}', array(
			'as' => 'aimeos_shop_jsonapi_patch',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@patchAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'POST' ), '{resource}', array(
			'as' => 'aimeos_shop_jsonapi_post',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@postAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'PUT' ), '{resource}', array(
			'as' => 'aimeos_shop_jsonapi_put',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@putAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'OPTIONS' ), '{resource?}', array(
			'as' => 'aimeos_shop_jsonapi_options',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@optionsAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.update', [] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), 'update', array(
			'as' => 'aimeos_shop_update',
			'uses' => 'Aimeos\Shop\Controller\CheckoutController@updateAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.account', ['prefix' => 'profile', 'middleware' => ['web', 'auth']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), 'favorite/{fav_action?}/{fav_id?}/{d_name?}/{d_pos?}', array(
			'as' => 'aimeos_shop_account_favorite',
			'uses' => 'Aimeos\Shop\Controller\AccountController@indexAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'watch/{wat_action?}/{wat_id?}/{d_name?}/{d_pos?}', array(
			'as' => 'aimeos_shop_account_watch',
			'uses' => 'Aimeos\Shop\Controller\AccountController@indexAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'download/{dl_id}', array(
			'as' => 'aimeos_shop_account_download',
			'uses' => 'Aimeos\Shop\Controller\AccountController@downloadAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), '', array(
			'as' => 'aimeos_shop_account',
			'uses' => 'Aimeos\Shop\Controller\AccountController@indexAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.supplier', ['prefix' => 'supplier', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), '{s_name}/{f_supid}', array(
			'as' => 'aimeos_shop_supplier',
			'uses' => 'Aimeos\Shop\Controller\SupplierController@detailAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

	} );
}


if( ( $conf = config( 'shop.routes.default', ['prefix' => 'shop', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), 'count', array(
			'as' => 'aimeos_shop_count',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@countAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'suggest', array(
			'as' => 'aimeos_shop_suggest',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@suggestAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'stock', array(
			'as' => 'aimeos_shop_stock',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@stockAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'basket', array(
			'as' => 'aimeos_shop_basket',
			'uses' => 'Aimeos\Shop\Controller\BasketController@indexAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'checkout/{c_step?}', array(
			'as' => 'aimeos_shop_checkout',
			'uses' => 'Aimeos\Shop\Controller\CheckoutController@indexAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'confirm/{code?}', array(
			'as' => 'aimeos_shop_confirm',
			'uses' => 'Aimeos\Shop\Controller\CheckoutController@confirmAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'pin', array(
			'as' => 'aimeos_shop_session_pinned',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@sessionAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), '{f_name}~{f_catid}', array(
			'as' => 'aimeos_shop_tree',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@treeAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+', 'f_name' => '[^~]*'] );

		Route::match( array( 'GET', 'POST' ), '{d_name}/{d_pos?}/{d_prodid?}', array(
			'as' => 'aimeos_shop_detail',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@detailAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+', 'd_pos' => '[0-9]*'] );

		Route::match( array( 'GET', 'POST' ), '', array(
			'as' => 'aimeos_shop_list',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@listAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.legal', [] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::get( 'terms', array(
			'as' => 'aimeos_shop_terms',
			'uses' => 'Aimeos\Shop\Controller\PageController@termsAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

		Route::get( 'privacy', array(
			'as' => 'aimeos_shop_privacy',
			'uses' => 'Aimeos\Shop\Controller\PageController@privacyAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );
	});
}
