<?php

switch( config( 'database.default', 'mysql' ) ) {
	case 'pgsql': $aimeosIndexManagerName = 'PgSQL'; break;
	case 'sqlsrv': $aimeosIndexManagerName = 'SQLSrv'; break;
	default: $aimeosIndexManagerName = 'MySQL';
}


return [

	'apc_enabled' => false,
	'apc_prefix' => 'laravel:',
	'extdir' => base_path( 'ext' ),
	'pcntl_max' => 4,
	'pcntl_priority' => 19,
	'uploaddir' => '/',

	'page' => [
		'account-index' => ['account/profile', 'account/review', 'account/subscription', 'account/history', 'account/favorite', 'account/watch', 'basket/mini', 'catalog/session'],
		'basket-index' => ['basket/bulk', 'basket/standard', 'basket/related'],
		'catalog-count' => ['catalog/count'],
		'catalog-detail' => ['basket/mini', 'catalog/stage', 'catalog/detail', 'catalog/session'],
		'catalog-home' => ['basket/mini', 'catalog/home'],
		'catalog-list' => ['basket/mini', 'catalog/filter', 'catalog/lists'],
		'catalog-stock' => ['catalog/stock'],
		'catalog-suggest' => ['catalog/suggest'],
		'catalog-tree' => ['basket/mini', 'catalog/filter', 'catalog/stage', 'catalog/lists'],
		'checkout-confirm' => ['checkout/confirm'],
		'checkout-index' => ['checkout/standard'],
		'checkout-update' => ['checkout/update'],
		'supplier-detail' => ['basket/mini', 'supplier/detail', 'catalog/lists'],
	],

	'resource' => [
		'db' => [
			'adapter' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.driver', 'mysql' ),
			'host' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.host', '127.0.0.1' ),
			'port' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.port', '3306' ),
			'socket' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.unix_socket', '' ),
			'database' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.database', 'forge' ),
			'username' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.username', 'forge' ),
			'password' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.password', '' ),
			'stmt' => config( 'database.default', 'mysql' ) === 'mysql' ? ["SET SESSION sort_buffer_size=2097144; SET NAMES 'utf8mb4'; SET SESSION sql_mode='ANSI'"] : [],
			'limit' => 3, // maximum number of concurrent database connections
			'defaultTableOptions' => [
					'charset' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.charset' ),
					'collate' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.collation' ),
			],
			'driverOptions' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.options' ),
		],
		'fs' => [
			'adapter' => 'Standard',
			'basedir' => public_path(),
			'tempdir' => storage_path( 'tmp' ),
			'baseurl' => config( 'app.url' ),
		],
		'fs-admin' => [
			'adapter' => 'Standard',
			'basedir' => storage_path( 'admin' ),
			'tempdir' => storage_path( 'tmp' ),
		],
		'fs-import' => [
			'adapter' => 'Standard',
			'basedir' => storage_path( 'import' ),
			'tempdir' => storage_path( 'tmp' ),
		],
		'fs-secure' => [
			'adapter' => 'Standard',
			'basedir' => storage_path( 'secure' ),
			'tempdir' => storage_path( 'tmp' ),
		],
		'mq' => [
			'adapter' => 'Standard',
			'db' => 'db',
		],
		'email' => [
			'from-email' => config( 'mail.from.address' ),
			'from-name' => config( 'mail.from.name' ),
		],

	],

	'admin' => [
		'jqadm' => [
			'url' => [
				'copy' => [
					'target' => 'aimeos_shop_jqadm_copy'
				],
				'create' => [
					'target' => 'aimeos_shop_jqadm_create'
				],
				'delete' => [
					'target' => 'aimeos_shop_jqadm_delete'
				],
				'export' => [
					'target' => 'aimeos_shop_jqadm_export'
				],
				'get' => [
					'target' => 'aimeos_shop_jqadm_get'
				],
				'import' => [
					'target' => 'aimeos_shop_jqadm_import'
				],
				'save' => [
					'target' => 'aimeos_shop_jqadm_save'
				],
				'search' => [
					'target' => 'aimeos_shop_jqadm_search'
				],
			],
		],
		'jsonadm' => [
			'url' => [
				'target' => 'aimeos_shop_jsonadm_get',
				'config' => [
					'absoluteUri' => true,
				],
				'options' => [
					'target' => 'aimeos_shop_jsonadm_options',
					'config' => [
						'absoluteUri' => true,
					],
				],
			],
		],
	],
	'client' => [
		'html' => [
			'account' => [
				'index' => [
					'url' => [
						'target' => 'aimeos_shop_account',
					],
				],
				'review' => [
					'url' => [
						'target' => 'aimeos_shop_account',
					],
				],
				'profile' => [
					'url' => [
						'target' => 'aimeos_shop_account',
					],
				],
				'subscription' => [
					'url' => [
						'target' => 'aimeos_shop_account',
					],
				],
				'history' => [
					'url' => [
						'target' => 'aimeos_shop_account',
					],
				],
				'favorite' => [
					'url' => [
						'target' => 'aimeos_shop_account_favorite',
					],
				],
				'watch' => [
					'url' => [
						'target' => 'aimeos_shop_account_watch',
					],
				],
				'download' => [
					'url' => [
						'target' => 'aimeos_shop_account_download',
					],
					'error' => [
						'url' => [
							'target' => 'aimeos_shop_account',
						],
					],
				],
			],
			'cms' => [
				'page' => [
					'url' => [
						'target' => 'aimeos_page',
					],
				],
			],
			'catalog' => [
				'count' => [
					'url' => [
						'target' => 'aimeos_shop_count',
					],
				],
				'detail' => [
					'url' => [
						'target' => 'aimeos_shop_detail',
					],
				],
				'home' => [
					'url' => [
						'target' => 'aimeos_home',
					],
				],
				'lists' => [
					'url' => [
						'target' => 'aimeos_shop_list',
					],
				],
				'session' => [
					'pinned' => [
						'url' => [
							'target' => 'aimeos_shop_session_pinned',
						],
					],
				],
				'stock' => [
					'url' => [
						'target' => 'aimeos_shop_stock',
					],
				],
				'suggest' => [
					'url' => [
						'target' => 'aimeos_shop_suggest',
					],
				],
				'tree' => [
					'url' => [
						'target' => 'aimeos_shop_tree',
					],
				],
			],
			'common' => [
				'template' => [
					'baseurl' => public_path( 'packages/aimeos/shop/themes/elegance' ),
				],
			],
			'basket' => [
				'standard' => [
					'url' => [
						'target' => 'aimeos_shop_basket',
					],
				],
			],
			'checkout' => [
				'confirm' => [
					'url' => [
						'target' => 'aimeos_shop_confirm',
					],
				],
				'standard' => [
					'url' => [
						'target' => 'aimeos_shop_checkout',
					],
					'summary' => [
						'option' => [
							'terms' => [
								'url' => [
									'target' => 'aimeos_shop_terms',
								],
								'privacy' => [
									'url' => [
										'target' => 'aimeos_shop_privacy',
									],
								],
								'cancel' => [
									'url' => [
										'target' => 'aimeos_shop_terms',
									],
								],
							],
						],
					],
				],
				'update' => [
					'url' => [
						'target' => 'aimeos_shop_update',
					],
				],
			],
			'locale' => [
				'select' => [
					'currency' => [
						'param-name' => 'currency',
					],
					'language' => [
						'param-name' => 'locale',
					],
				],
			],
			'supplier' => [
				'detail' => [
					'url' => [
						'target' => 'aimeos_shop_supplier',
					],
				],
			]
		],
		'jsonapi' => [
			'url' => [
				'target' => 'aimeos_shop_jsonapi_options',
				'config' => [
					'absoluteUri' => true,
				],
			],
		],
	],

	'controller' => [
		'common' => [
			'media' => [
				'mimeicon' => [
					# Directory where icons for the mime types stored
					'directory' => 'packages/aimeos/shop/mimeicons',
					# File extension of mime type icons
					'extension' => '.png'
				],
				'tempdir' => storage_path( 'aimeos' ),
			],
		],
		'jobs' => [
			'catalog' => [
				'export' => [
					'sitemap' => [
						'location' => public_path()
					]
				]
			],
			'from-email' => config( 'mail.from.address' ),
			'product' => [
				'export' => [
					'sitemap' => [
						'location' => public_path()
					]
				]
			]
		]
	],

	'mshop' => [
		'customer' => [
			'manager' => [
				'name' => 'Laravel',
				'password' => [
					'name' => 'Bcrypt',
				],
			],
		],
		'index' => [
			'manager' => [
				'name' => $aimeosIndexManagerName,
			],
		],
	],
];
