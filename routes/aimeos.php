<?php

if( ( $conf = config( 'shop.routes.admin', ['prefix' => 'admin', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET' ), '', array(
			'as' => 'aimeos_shop_admin',
			'uses' => 'Aimeos\Shop\Controller\AdminController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.jqadm', ['prefix' => 'admin/{site}/jqadm', 'middleware' => ['web', 'auth']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET' ), 'file/{type}', array(
			'as' => 'aimeos_shop_jqadm_file',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@fileAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'POST' ), 'batch/{resource}', array(
			'as' => 'aimeos_shop_jqadm_batch',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@batchAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET', 'POST' ), 'copy/{resource}/{id}', array(
			'as' => 'aimeos_shop_jqadm_copy',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@copyAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET', 'POST' ), 'create/{resource}', array(
			'as' => 'aimeos_shop_jqadm_create',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@createAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'POST' ), 'delete/{resource}/{id?}', array(
			'as' => 'aimeos_shop_jqadm_delete',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@deleteAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET', 'POST' ), 'export/{resource}', array(
			'as' => 'aimeos_shop_jqadm_export',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@exportAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET' ), 'get/{resource}/{id}', array(
			'as' => 'aimeos_shop_jqadm_get',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@getAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'POST' ), 'import/{resource}', array(
			'as' => 'aimeos_shop_jqadm_import',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@importAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'POST' ), 'save/{resource}', array(
			'as' => 'aimeos_shop_jqadm_save',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@saveAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET', 'POST' ), 'search/{resource}', array(
			'as' => 'aimeos_shop_jqadm_search',
			'uses' => 'Aimeos\Shop\Controller\JqadmController@searchAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

	});
}


if( ( $conf = config( 'shop.routes.graphql', ['prefix' => 'admin/{site}/graphql', 'middleware' => ['web', 'auth']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'POST' ), '', array(
			'as' => 'aimeos_shop_graphql_post',
			'uses' => 'Aimeos\Shop\Controller\GraphqlController@indexAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.jsonadm', ['prefix' => 'admin/{site}/jsonadm', 'middleware' => ['web', 'auth']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'DELETE' ), '{resource}/{id?}', array(
			'as' => 'aimeos_shop_jsonadm_delete',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@deleteAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET' ), '{resource}/{id?}', array(
			'as' => 'aimeos_shop_jsonadm_get',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@getAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'PATCH' ), '{resource}/{id?}', array(
			'as' => 'aimeos_shop_jsonadm_patch',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@patchAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'POST' ), '{resource}/{id?}', array(
			'as' => 'aimeos_shop_jsonadm_post',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@postAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'PUT' ), '{resource}/{id?}', array(
			'as' => 'aimeos_shop_jsonadm_put',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@putAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'OPTIONS' ), '{resource?}', array(
			'as' => 'aimeos_shop_jsonadm_options',
			'uses' => 'Aimeos\Shop\Controller\JsonadmController@optionsAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

	});
}


if( ( $conf = config( 'shop.routes.jsonapi', ['prefix' => 'jsonapi', 'middleware' => ['web', 'api']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'DELETE' ), '{resource}', array(
			'as' => 'aimeos_shop_jsonapi_delete',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@deleteAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET' ), '{resource}', array(
			'as' => 'aimeos_shop_jsonapi_get',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@getAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'PATCH' ), '{resource}', array(
			'as' => 'aimeos_shop_jsonapi_patch',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@patchAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'POST' ), '{resource}', array(
			'as' => 'aimeos_shop_jsonapi_post',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@postAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'PUT' ), '{resource}', array(
			'as' => 'aimeos_shop_jsonapi_put',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@putAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'OPTIONS' ), '{resource?}', array(
			'as' => 'aimeos_shop_jsonapi_options',
			'uses' => 'Aimeos\Shop\Controller\JsonapiController@optionsAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.account', ['prefix' => 'profile', 'middleware' => ['web', 'auth']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), 'favorite/{fav_action?}/{fav_id?}/{d_name?}/{d_pos?}', array(
			'as' => 'aimeos_shop_account_favorite',
			'uses' => 'Aimeos\Shop\Controller\AccountController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'watch/{wat_action?}/{wat_id?}/{d_name?}/{d_pos?}', array(
			'as' => 'aimeos_shop_account_watch',
			'uses' => 'Aimeos\Shop\Controller\AccountController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'download/{dl_id}', array(
			'as' => 'aimeos_shop_account_download',
			'uses' => 'Aimeos\Shop\Controller\AccountController@downloadAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), '', array(
			'as' => 'aimeos_shop_account',
			'uses' => 'Aimeos\Shop\Controller\AccountController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.supplier', ['prefix' => 'supplier', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), '{s_name}/{f_supid}', array(
			'as' => 'aimeos_shop_supplier',
			'uses' => 'Aimeos\Shop\Controller\SupplierController@detailAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	} );
}


if( ( $conf = config( 'shop.routes.update', [] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), 'update', array(
			'as' => 'aimeos_shop_update',
			'uses' => 'Aimeos\Shop\Controller\CheckoutController@updateAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.confirm', ['prefix' => 'shop', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), 'confirm/{code?}', array(
			'as' => 'aimeos_shop_confirm',
			'uses' => 'Aimeos\Shop\Controller\CheckoutController@confirmAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.default', ['prefix' => 'shop', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), 'count', array(
			'as' => 'aimeos_shop_count',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@countAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'suggest', array(
			'as' => 'aimeos_shop_suggest',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@suggestAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'stock', array(
			'as' => 'aimeos_shop_stock',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@stockAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'basket', array(
			'as' => 'aimeos_shop_basket',
			'uses' => 'Aimeos\Shop\Controller\BasketController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'checkout/{c_step?}', array(
			'as' => 'aimeos_shop_checkout',
			'uses' => 'Aimeos\Shop\Controller\CheckoutController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'pin', array(
			'as' => 'aimeos_shop_session_pinned',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@sessionAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), '{f_name}~{f_catid}/{l_page?}', array(
			'as' => 'aimeos_shop_tree',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@treeAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'f_name' => '[^~]*', 'l_page' => '[0-9]+'] );

		Route::match( array( 'GET', 'POST' ), '{d_name}/{d_pos?}/{d_prodid?}', array(
			'as' => 'aimeos_shop_detail',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@detailAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'd_pos' => '[0-9]*'] );

		Route::match( array( 'GET', 'POST' ), '', array(
			'as' => 'aimeos_shop_list',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@listAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.page', ['prefix' => 'p', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match(['GET', 'POST'], '{path?}', [
			'as' => 'aimeos_page',
			'uses' => '\Aimeos\Shop\Controller\PageController@indexAction'
		] )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );
	});
}


if( ( $conf = config( 'shop.routes.home', ['middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), '/', array(
			'as' => 'aimeos_home',
			'uses' => 'Aimeos\Shop\Controller\CatalogController@homeAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}
