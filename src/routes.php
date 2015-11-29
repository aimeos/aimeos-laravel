<?php

Route::group(config('shop.routes.admin', ['middleware' => 'auth']), function() {

	Route::match( array( 'GET' ), 'admin/file', array(
		'as' => 'aimeos_shop_admin_file',
		'uses' => 'Aimeos\Shop\Controller\AdminController@fileAction'
	));
	Route::match( array( 'POST' ), 'admin/do', array(
		'as' => 'aimeos_shop_admin_json',
		'uses' => 'Aimeos\Shop\Controller\AdminController@doAction'
	));
	Route::match( array( 'GET' ), 'admin', array(
		'as' => 'aimeos_shop_admin',
		'uses' => 'Aimeos\Shop\Controller\AdminController@indexAction'
	));

});


Route::group(config('shop.routes.jsonadm', ['middleware' => 'auth']), function() {

	Route::match( array( 'DELETE' ), 'jsonadm/{resource}/{id?}', array(
		'as' => 'aimeos_shop_jsonadm_delete',
		'uses' => 'Aimeos\Shop\Controller\JsonadmController@deleteAction'
	))->where( array( 'resource' => '[^0-9]+', 'id' => '[0-9]*' ) );

	Route::match( array( 'GET' ), 'jsonadm/{resource}/{id?}', array(
		'as' => 'aimeos_shop_jsonadm_get',
		'uses' => 'Aimeos\Shop\Controller\JsonadmController@getAction'
	))->where( array( 'resource' => '[^0-9]+', 'id' => '[0-9]*' ) );

	Route::match( array( 'PATCH' ), 'jsonadm/{resource}/{id?}', array(
		'as' => 'aimeos_shop_jsonadm_patch',
		'uses' => 'Aimeos\Shop\Controller\JsonadmController@patchAction'
	))->where( array( 'resource' => '[^0-9]+', 'id' => '[0-9]*' ) );

	Route::match( array( 'POST' ), 'jsonadm/{resource}/{id?}', array(
		'as' => 'aimeos_shop_jsonadm_post',
		'uses' => 'Aimeos\Shop\Controller\JsonadmController@postAction'
	))->where( array( 'resource' => '[^0-9]+', 'id' => '[0-9]*' ) );

	Route::match( array( 'PUT' ), 'jsonadm/{resource}/{id?}', array(
		'as' => 'aimeos_shop_jsonadm_put',
		'uses' => 'Aimeos\Shop\Controller\JsonadmController@putAction'
	))->where( array( 'resource' => '[^0-9]+', 'id' => '[0-9]*' ) );

	Route::match( array( 'OPTIONS' ), 'jsonadm/{resource?}', array(
		'as' => 'aimeos_shop_jsonadm_options',
		'uses' => 'Aimeos\Shop\Controller\JsonadmController@optionsAction'
	))->where( array( 'resource' => '[^0-9]*' ) );

});


Route::group(config('shop.routes.account', ['middleware' => 'auth']), function() {

	Route::match( array( 'GET', 'POST' ), 'myaccount', array(
		'as' => 'aimeos_shop_account',
		'uses' => 'Aimeos\Shop\Controller\AccountController@indexAction'
	));
	Route::match( array( 'GET', 'POST' ), 'myaccount/favorite/{fav_action?}/{fav_id?}/{d_prodid?}/{d_name?}/{l_pos?}', array(
		'as' => 'aimeos_shop_account_favorite',
		'uses' => 'Aimeos\Shop\Controller\AccountController@indexAction'
	));
	Route::match( array( 'GET', 'POST' ), 'myaccount/watch/{wat_action?}/{wat_id?}/{d_prodid?}/{d_name?}/{l_pos?}', array(
		'as' => 'aimeos_shop_account_watch',
		'uses' => 'Aimeos\Shop\Controller\AccountController@indexAction'
	));

});


Route::group(config('shop.routes.default', []), function() {

	Route::match( array( 'GET', 'POST' ), 'basket', array(
		'as' => 'aimeos_shop_basket',
		'uses' => 'Aimeos\Shop\Controller\BasketController@indexAction'
	));

	Route::match( array( 'GET', 'POST' ), 'count', array(
		'as' => 'aimeos_shop_count',
		'uses' => 'Aimeos\Shop\Controller\CatalogController@countAction'
	));
	Route::match( array( 'GET', 'POST' ), 'detail/{d_prodid}/{d_name?}/{l_pos?}', array(
		'as' => 'aimeos_shop_detail',
		'uses' => 'Aimeos\Shop\Controller\CatalogController@detailAction'
	));
	Route::match( array( 'GET', 'POST' ), 'detail/pin/{pin_action?}/{pin_id?}/{d_prodid?}/{d_name?}/{l_pos?}', array(
		'as' => 'aimeos_shop_session_pinned',
		'uses' => 'Aimeos\Shop\Controller\CatalogController@detailAction'
	));
	Route::match( array( 'GET', 'POST' ), 'list', array(
		'as' => 'aimeos_shop_list',
		'uses' => 'Aimeos\Shop\Controller\CatalogController@listAction'
	));
	Route::match( array( 'GET', 'POST' ), 'suggest', array(
		'as' => 'aimeos_shop_suggest',
		'uses' => 'Aimeos\Shop\Controller\CatalogController@suggestAction'
	));
	Route::match( array( 'GET', 'POST' ), 'stock', array(
		'as' => 'aimeos_shop_stock',
		'uses' => 'Aimeos\Shop\Controller\CatalogController@stockAction'
	));

	Route::match( array( 'GET', 'POST' ), 'checkout/{c_step?}', array(
		'as' => 'aimeos_shop_checkout',
		'uses' => 'Aimeos\Shop\Controller\CheckoutController@indexAction'
	));
	Route::match( array( 'GET', 'POST' ), 'confirm', array(
		'as' => 'aimeos_shop_confirm',
		'uses' => 'Aimeos\Shop\Controller\CheckoutController@confirmAction'
	));
	Route::match( array( 'GET', 'POST' ), 'update', array(
		'as' => 'aimeos_shop_update',
		'uses' => 'Aimeos\Shop\Controller\CheckoutController@updateAction'
	));

	Route::get('terms', array(
		'as' => 'aimeos_shop_terms',
		'uses' => 'Aimeos\Shop\Controller\PageController@termsAction'
	));
	Route::get('privacy', array(
		'as' => 'aimeos_shop_privacy',
		'uses' => 'Aimeos\Shop\Controller\PageController@privacyAction'
	));

});
