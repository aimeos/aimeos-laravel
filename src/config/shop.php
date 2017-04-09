<?php

return array(

	'routes' => array(
		// 'login' => array('middleware' => ['web']),
		// 'admin' => array('middleware' => ['web', 'auth']),
		// 'account' => array('middleware' => ['web', 'auth']),
		// 'jsonadm' => array('middleware' => ['api', 'auth']),
		// 'jsonapi' => array('middleware' => ['api']),
		// 'default' => array('middleware' => ['web']),
		// 'confirm' => array('middleware' => ['web']),
		// 'update' => array(),
	),

	'page' => array(
		// 'account-index' => array( 'account/profile','account/history','account/favorite','account/watch','basket/mini','catalog/session' ),
		// 'basket-index' => array( 'basket/standard','basket/related' ),
		// 'catalog-count' => array( 'catalog/count' ),
		// 'catalog-detail' => array( 'basket/mini','catalog/stage','catalog/detail','catalog/session' ),
		// 'catalog-list' => array( 'basket/mini','catalog/filter','catalog/stage','catalog/lists' ),
		// 'catalog-stock' => array( 'catalog/stock' ),
		// 'catalog-suggest' => array( 'catalog/suggest' ),
		// 'checkout-confirm' => array( 'checkout/confirm' ),
		// 'checkout-index' => array( 'checkout/standard' ),
		// 'checkout-update' => array( 'checkout/update'),
	),

	/*
	'resource' => array(
		'db' => array(
			'adapter' => env('DB_CONNECTION', 'mysql'),
			'host' => env('DB_HOST', 'localhost'),
			'port' => env('DB_PORT', ''),
			'socket' => '',
			'database' => env('DB_DATABASE', 'laravel'),
			'username' => env('DB_USERNAME', 'root'),
			'password' => env('DB_PASSWORD', ''),
			'stmt' => array( "SET NAMES 'utf8'", "SET SESSION sql_mode='ANSI'" ),
		),
	),
	*/

	'admin' => array(),

	'client' => array(
		'html' => array(
			'common' => array(
				'content' => array(
					// 'baseurl' => '/',
				),
				'template' => array(
					// 'baseurl' => 'packages/aimeos/shop/themes/elegance',
				),
			),
		),
	),

	'controller' => array(
	),

	'i18n' => array(
	),

	'madmin' => array(
	),

	'mshop' => array(
	),


	'command' => array(
	),

	'frontend' => array(
	),

	'backend' => array(
	),
);
