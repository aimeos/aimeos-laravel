<?php

return [

	'apc_enabled' => false, // enable for maximum performance if APCu is availalbe
	'apc_prefix' => 'laravel:', // prefix for caching config and translation in APCu
	'pcntl_max' => 4, // maximum number of parallel command line processes when starting jobs
	'num_formatter' => 'Locale', // locale based number formatter (alternative: "Standard")

	'routes' => [
		// Docs: https://aimeos.org/docs/Laravel/Custom_routes
		// Multi-sites: https://aimeos.org/docs/Laravel/Configure_multiple_shops
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
		// Docs: https://aimeos.org/docs/Laravel/Adapt_pages
		// Hint: catalog/filter is also available as single 'catalog/search', 'catalog/tree', 'catalog/price', 'catalog/supplier' and 'catalog/attribute'
		'account-index' => [ 'account/profile','account/review','account/subscription','account/history','account/favorite','account/watch','basket/mini','catalog/session' ],
		'basket-index' => [ 'basket/bulk', 'basket/standard','basket/related' ],
		'catalog-count' => [ 'catalog/count' ],
		'catalog-detail' => [ 'basket/mini','catalog/stage','catalog/detail','catalog/session' ],
		'catalog-home' => [ 'basket/mini','catalog/search','catalog/tree','catalog/home' ],
		'catalog-list' => [ 'basket/mini','catalog/filter','catalog/lists' ],
		'catalog-stock' => [ 'catalog/stock' ],
		'catalog-suggest' => [ 'catalog/suggest' ],
		'catalog-tree' => [ 'basket/mini','catalog/filter','catalog/stage','catalog/lists' ],
		'checkout-confirm' => [ 'checkout/confirm' ],
		'checkout-index' => [ 'checkout/standard' ],
		'checkout-update' => [ 'checkout/update' ],
		'supplier-detail' => [ 'basket/mini','supplier/detail','catalog/lists' ],
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
					// 'baseurl' => public_path( 'vendor/shop/themes/elegance' ),
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
