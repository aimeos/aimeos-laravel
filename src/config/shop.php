<?php

return [

	'apc_enabled' => false, // enable for maximum performance if APCu is availalbe
	'apc_prefix' => 'laravel:', // prefix for caching config and translation in APCu
	'pcntl_max' => 4, // maximum number of parallel command line processes when starting jobs
	'num_formatter' => 'Locale', // locale based number formatter (alternative: "Standard")

	'routes' => [
		// Docs: https://aimeos.org/docs/latest/laravel/extend/#custom-routes
		// Multi-sites: https://aimeos.org/docs/latest/laravel/customize/#multiple-shops
		// 'admin' => ['prefix' => 'admin', 'middleware' => ['web']],
		// 'jqadm' => ['prefix' => 'admin/{site}/jqadm', 'middleware' => ['web', 'auth']],
		// 'jsonadm' => ['prefix' => 'admin/{site}/jsonadm', 'middleware' => ['web', 'auth']],
		// 'jsonapi' => ['prefix' => 'jsonapi', 'middleware' => ['web', 'api']],
		// 'account' => ['prefix' => 'profile', 'middleware' => ['web', 'auth']],
		// 'default' => ['prefix' => 'shop', 'middleware' => ['web']],
		// 'supplier' => ['prefix' => 's', 'middleware' => ['web']],
		// 'update' => [],
	],

	/*
	'page' => [
		// Docs: https://aimeos.org/docs/latest/laravel/extend/#adapt-pages
		'account-index' => [ 'locale/select', 'basket/mini','catalog/tree','catalog/search','account/profile','account/review','account/subscription','account/history','account/favorite','account/watch','catalog/session' ],
		'basket-index' => [ 'locale/select', 'catalog/tree','catalog/search','basket/standard','basket/bulk','basket/related' ],
		'catalog-count' => [ 'catalog/count' ],
		'catalog-detail' => [ 'locale/select', 'basket/mini','catalog/tree','catalog/search','catalog/stage','catalog/detail','catalog/session' ],
		'catalog-home' => [ 'locale/select','basket/mini','catalog/tree','catalog/search','catalog/home' ],
		'catalog-list' => [ 'locale/select','basket/mini','catalog/tree','catalog/search','catalog/price','catalog/supplier','catalog/attribute','catalog/session','catalog/stage','catalog/lists' ],
		'catalog-session' => [ 'locale/select','basket/mini','catalog/tree','catalog/search','catalog/session' ],
		'catalog-stock' => [ 'catalog/stock' ],
		'catalog-suggest' => [ 'catalog/suggest' ],
		'catalog-tree' => [ 'locale/select','basket/mini','catalog/tree','catalog/search','catalog/price','catalog/supplier','catalog/attribute','catalog/session','catalog/stage','catalog/lists' ],
		'checkout-confirm' => [ 'catalog/tree','catalog/search','checkout/confirm' ],
		'checkout-index' => [ 'locale/select', 'catalog/tree','catalog/search','checkout/standard' ],
		'checkout-update' => [ 'checkout/update' ],
		'supplier-detail' => [ 'locale/select','basket/mini','catalog/tree','catalog/search','supplier/detail','catalog/lists'],
	],
	*/

	/*
	'resource' => [
		'db' => [
			'adapter' => config('database.connections.' . config( 'database.default', 'mysql' ) . '.driver', 'mysql'),
			'host' => config('database.connections.' . config( 'database.default', 'mysql' ) . '.host', '127.0.0.1'),
			'port' => config('database.connections.' . config( 'database.default', 'mysql' ) . '.port', '3306'),
			'socket' => config('database.connections.' . config( 'database.default', 'mysql' ) . '.unix_socket', ''),
			'database' => config('database.connections.' . config( 'database.default', 'mysql' ) . '.database', 'forge'),
			'username' => config('database.connections.' . config( 'database.default', 'mysql' ) . '.username', 'forge'),
			'password' => config('database.connections.' . config( 'database.default', 'mysql' ) . '.password', ''),
			'stmt' => config( 'database.default', 'mysql' ) === 'mysql' ? ["SET SESSION sort_buffer_size=2097144; SET NAMES 'utf8mb4'; SET SESSION sql_mode='ANSI'"] : [],
			'limit' => 3, // maximum number of concurrent database connections
			'defaultTableOptions' => [
					'charset' => config('database.connections.' . config( 'database.default', 'mysql' ) . '.charset'),
					'collate' => config('database.connections.' . config( 'database.default', 'mysql' ) . '.collation'),
			],
			'driverOptions' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.options' ),
		],
	],
	*/

	'admin' => [],

	'client' => [
		'html' => [
			'basket' => [
				'cache' => [
					// 'enable' => false, // Disable basket content caching for development
				],
			],
			'common' => [
				'template' => [
					// for styling for e-mail templates
					// 'baseurl' => public_path( 'vendor/shop/themes/default' ),
				],
			],
		],
	],

	'controller' => [
	],

	'i18n' => [
	],

	'madmin' => [
		'cache' => [
			'manager' => [
				// 'name' => 'None', // Disable caching for development
			],
		],
		'log' => [
			'manager' => [
				// 'loglevel' => 7, // Enable debug logging into madmin_log table
			],
		],
	],

	'mshop' => [
	],


	'command' => [
	],

	'frontend' => [
	],

	'backend' => [
	],

];
