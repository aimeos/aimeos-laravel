<?php

return array(

	'apc_enabled' => false,
	'apc_prefix' => 'laravel:',
	'extdir' => base_path( 'ext' ),
	'pcntl_max' => 4,
	'pcntl_priority' => 19,
	'uploaddir' => '/',

	'page' => array(
		'account-index' => array( 'account/profile', 'account/subscription', 'account/history', 'account/favorite', 'account/watch', 'basket/mini', 'catalog/session' ),
		'basket-index' => array( 'basket/bulk', 'basket/standard', 'basket/related' ),
		'catalog-count' => array( 'catalog/count' ),
		'catalog-detail' => array( 'basket/mini', 'catalog/stage', 'catalog/detail', 'catalog/session' ),
		'catalog-home' => array( 'basket/mini', 'catalog/search', 'catalog/tree', 'catalog/home' ),
		'catalog-list' => array( 'basket/mini', 'catalog/filter', 'catalog/lists' ),
		'catalog-stock' => array( 'catalog/stock' ),
		'catalog-suggest' => array( 'catalog/suggest' ),
		'catalog-tree' => array( 'basket/mini', 'catalog/filter', 'catalog/stage', 'catalog/lists' ),
		'checkout-confirm' => array( 'checkout/confirm' ),
		'checkout-index' => array( 'checkout/standard' ),
		'checkout-update' => array( 'checkout/update' ),
	),

	'resource' => array(
		'db' => array(
			'adapter' => config( 'database.connections.mysql.driver', 'mysql' ),
			'host' => config( 'database.connections.mysql.host', '127.0.0.1' ),
			'port' => config( 'database.connections.mysql.port', '3306' ),
			'socket' => config( 'database.connections.mysql.unix_socket', '' ),
			'database' => config( 'database.connections.mysql.database', 'forge' ),
			'username' => config( 'database.connections.mysql.username', 'forge' ),
			'password' => config( 'database.connections.mysql.password', '' ),
			'stmt' => ["SET SESSION sort_buffer_size=2097144; SET NAMES 'utf8mb4'; SET SESSION sql_mode='ANSI'; SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED"],
			'opt-persistent' => 0,
			'limit' => 3,
			'defaultTableOptions' => [
				'charset' => config( 'database.connections.mysql.charset' ),
				'collate' => config( 'database.connections.mysql.collation' ),
			],
			'driverOptions' => config('database.connections.mysql.options'),
		),
		'fs' => array(
			'adapter' => 'Standard',
			'basedir' => public_path(),
			'tempdir' => storage_path( 'tmp' ),
			'baseurl' => config( 'app.url' ) . '/',
		),
		'fs-admin' => array(
			'adapter' => 'Standard',
			'basedir' => storage_path( 'admin' ),
			'tempdir' => storage_path( 'tmp' ),
		),
		'fs-import' => array(
			'adapter' => 'Standard',
			'basedir' => storage_path( 'import' ),
			'tempdir' => storage_path( 'tmp' ),
		),
		'fs-secure' => array(
			'adapter' => 'Standard',
			'basedir' => storage_path( 'secure' ),
			'tempdir' => storage_path( 'tmp' ),
		),
		'mq' => array(
			'adapter' => 'Standard',
			'db' => 'db',
		),
	),

	'admin' => array(
		'jqadm' => array(
			'url' => array(
				'copy' => array(
					'target' => 'aimeos_shop_jqadm_copy'
				),
				'create' => array(
					'target' => 'aimeos_shop_jqadm_create'
				),
				'delete' => array(
					'target' => 'aimeos_shop_jqadm_delete'
				),
				'export' => array(
					'target' => 'aimeos_shop_jqadm_export'
				),
				'get' => array(
					'target' => 'aimeos_shop_jqadm_get'
				),
				'import' => array(
					'target' => 'aimeos_shop_jqadm_import'
				),
				'save' => array(
					'target' => 'aimeos_shop_jqadm_save'
				),
				'search' => array(
					'target' => 'aimeos_shop_jqadm_search'
				),
			)
		),
		'jsonadm' => array(
			'url' => array(
				'target' => 'aimeos_shop_jsonadm_get',
				'config' => array(
					'absoluteUri' => true,
				),
				'options' => array(
					'target' => 'aimeos_shop_jsonadm_options',
					'config' => array(
						'absoluteUri' => true,
					),
				),
			),
		),
	),
	'client' => array(
		'html' => array(
			'account' => array(
				'index' => array(
					'url' => array(
						'target' => 'aimeos_shop_account',
					),
				),
				'profile' => array(
					'url' => array(
						'target' => 'aimeos_shop_account',
					),
				),
				'subscription' => array(
					'url' => array(
						'target' => 'aimeos_shop_account',
					),
				),
				'history' => array(
					'url' => array(
						'target' => 'aimeos_shop_account',
					),
				),
				'favorite' => array(
					'url' => array(
						'target' => 'aimeos_shop_account_favorite',
					),
				),
				'watch' => array(
					'url' => array(
						'target' => 'aimeos_shop_account_watch',
					),
				),
				'download' => array(
					'url' => array(
						'target' => 'aimeos_shop_account_download',
					),
					'error' => array(
						'url' => array(
							'target' => 'aimeos_shop_account',
						),
					),
				),
			),
			'catalog' => array(
				'count' => array(
					'url' => array(
						'target' => 'aimeos_shop_count',
					),
				),
				'detail' => array(
					'url' => array(
						'target' => 'aimeos_shop_detail',
					),
				),
				'lists' => array(
					'url' => array(
						'target' => 'aimeos_shop_list',
					),
				),
				'session' => array(
					'pinned' => array(
						'url' => array(
							'target' => 'aimeos_shop_session_pinned',
						),
					),
				),
				'stock' => array(
					'url' => array(
						'target' => 'aimeos_shop_stock',
					),
				),
				'suggest' => array(
					'url' => array(
						'target' => 'aimeos_shop_suggest',
					),
				),
				'tree' => array(
					'url' => array(
						'target' => 'aimeos_shop_tree',
					),
				),
			),
			'common' => array(
				'template' => array(
					'baseurl' => public_path( 'packages/aimeos/shop/themes/elegance' ),
				),
			),
			'basket' => array(
				'standard' => array(
					'url' => array(
						'target' => 'aimeos_shop_basket',
					),
				),
			),
			'checkout' => array(
				'confirm' => array(
					'url' => array(
						'target' => 'aimeos_shop_confirm',
					),
				),
				'standard' => array(
					'url' => array(
						'target' => 'aimeos_shop_checkout',
					),
					'summary' => array(
						'option' => array(
							'terms' => array(
								'url' => array(
									'target' => 'aimeos_shop_terms',
								),
								'privacy' => array(
									'url' => array(
										'target' => 'aimeos_shop_privacy',
									),
								),
								'cancel' => array(
									'url' => array(
										'target' => 'aimeos_shop_terms',
									),
								),
							),
						),
					),
				),
				'update' => array(
					'url' => array(
						'target' => 'aimeos_shop_update',
					),
				),
			),
			'email' => [
				'from-email' => config( 'mail.from.address' ),
				'from-name' => config( 'mail.from.name' ),
			],
			'locale' => array(
				'select' => array(
					'currency' => array(
						'param-name' => 'currency',
					),
					'language' => array(
						'param-name' => 'locale',
					),
				),
			),
		),
		'jsonapi' => array(
			'url' => array(
				'target' => 'aimeos_shop_jsonapi_options',
				'config' => array(
					'absoluteUri' => true,
				),
			),
		),
	),

	'controller' => array(
		'common' => array(
			'media' => array(
				'standard' => array(
					'mimeicon' => array(
						# Directory where icons for the mime types stored
						'directory' => 'packages/aimeos/shop/mimeicons',
						# File extension of mime type icons
						'extension' => '.png'
					),
					'tempdir' => storage_path( 'aimeos' ),
				),
			),
		),
	),

	'mshop' => array(
		'customer' => array(
			'manager' => array(
				'name' => 'Laravel',
				'password' => array(
					'name' => 'Bcrypt',
				),
			),
		),
		'index' => array(
			'manager' => array(
				'name' => 'MySQL',
			),
		),
	),

);
