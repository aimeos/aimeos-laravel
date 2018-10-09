<?php

return [

	'routes' => [
		// 'login' => ['middleware' => ['web']],
		// 'admin' => ['prefix' => 'admin', 'middleware' => ['web']],
		// 'jqadm' => ['prefix' => 'admin/{site}/jqadm', 'middleware' => ['web', 'auth']],
		// 'extadm' => ['prefix' => 'admin/{site}/extadm', 'middleware' => ['web', 'auth']],
		// 'jsonadm' => ['prefix' => 'admin/{site}/jsonadm', 'middleware' => ['web', 'auth']],
		// 'jsonapi' => ['prefix' => 'jsonapi', 'middleware' => ['web', 'api']],
		// 'account' => ['middleware' => ['web', 'auth']],
		// 'default' => ['middleware' => ['web']],
		// 'update' => [],
	],

	'page' => [
		// 'account-index' => [ 'account/profile','account/subscription','account/history','account/favorite','account/watch','basket/mini','catalog/session' ],
		// 'basket-index' => [ 'basket/standard','basket/related' ],
		// 'catalog-count' => [ 'catalog/count' ],
		// 'catalog-detail' => [ 'basket/mini','catalog/stage','catalog/detail','catalog/session' ],
		// Hint: catalog/filter is also available as single 'catalog/tree', 'catalog/search', 'catalog/attribute' (https://aimeos.org/docs/Laravel/Adapt_pages)
		// 'catalog-list' => [ 'basket/mini','catalog/filter','catalog/stage','catalog/lists' ],
		// 'catalog-stock' => [ 'catalog/stock' ],
		// 'catalog-suggest' => [ 'catalog/suggest' ],
		// 'checkout-confirm' => [ 'checkout/confirm' ],
		// 'checkout-index' => [ 'checkout/standard' ],
		// 'checkout-update' => [ 'checkout/update' ],
	],

	/*
	'resource' => [
		'db' => [
			'adapter' => config('database.connections.mysql.driver', 'mysql'),
			'host' => config('database.connections.mysql.host', '127.0.0.1'),
			'port' => config('database.connections.mysql.port', '3306'),
			'socket' => config('database.connections.mysql.unix_socket', ''),,
			'database' => config('database.connections.mysql.database', 'forge'),
			'username' => config('database.connections.mysql.username', 'forge'),
			'password' => config('database.connections.mysql.password', ''),
			'stmt' => ["SET SESSION sort_buffer_size=2097144; SET SESSION sql_mode='ANSI'; SET NAMES 'utf8mb4_bin'"],
			'limit' => 3, // maximum number of concurrent database connections
			'defaultTableOptions' => [
					'charset' => config('database.connections.mysql.charset'),
					'collate' => config('database.connections.mysql.collation'),
			],
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
				'content' => [
					// 'baseurl' => config( 'app.url' ) . '/',
				],
				'template' => [
					// 'baseurl' => public_path( 'packages/aimeos/shop/themes/elegance' ),
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
				'standard' => [
					// 'loglevel' => 7, // Enable debug logging into madmin_log table
				],
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
