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
		'account-index' => ['locale/select', 'basket/mini', 'catalog/tree', 'catalog/search', 'account/profile', 'account/review', 'account/subscription', 'account/basket', 'account/history', 'account/favorite', 'account/watch', 'catalog/session'],
		'basket-index' => ['locale/select', 'catalog/tree', 'catalog/search', 'basket/standard', 'basket/bulk', 'basket/related'],
		'catalog-count' => ['catalog/count'],
		'catalog-detail' => ['locale/select', 'basket/mini', 'catalog/tree', 'catalog/search', 'catalog/stage', 'catalog/detail', 'catalog/session'],
		'catalog-home' => ['locale/select', 'basket/mini', 'catalog/tree', 'catalog/search', 'catalog/home'],
		'catalog-list' => ['locale/select', 'basket/mini', 'catalog/filter', 'catalog/tree', 'catalog/search', 'catalog/price', 'catalog/supplier', 'catalog/attribute', 'catalog/session', 'catalog/stage', 'catalog/lists'],
		'catalog-session' => ['locale/select', 'basket/mini', 'catalog/tree', 'catalog/search', 'catalog/session'],
		'catalog-stock' => ['catalog/stock'],
		'catalog-suggest' => ['catalog/suggest'],
		'catalog-tree' => ['locale/select', 'basket/mini', 'catalog/filter', 'catalog/tree', 'catalog/search', 'catalog/price', 'catalog/supplier', 'catalog/attribute', 'catalog/session', 'catalog/stage', 'catalog/lists'],
		'checkout-confirm' => ['catalog/tree', 'catalog/search', 'checkout/confirm'],
		'checkout-index' => ['locale/select', 'catalog/tree', 'catalog/search', 'checkout/standard'],
		'checkout-update' => ['checkout/update'],
		'supplier-detail' => ['locale/select', 'basket/mini', 'catalog/tree', 'catalog/search', 'supplier/detail', 'catalog/lists'],
	],

	'admin' => [
		'graphql' => [
			'url' => [
				'target' => 'aimeos_shop_graphql_post',
				'config' => [
					'absoluteUri' => true,
				],
			],
		],
		'jqadm' => [
			'url' => [
				'batch' => [
					'target' => 'aimeos_shop_jqadm_batch'
				],
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
				'basket' => [
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
					'baseurl' => public_path( 'vendor/shop/themes/default' ),
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
									'target' => 'aimeos_page',
								],
								'privacy' => [
									'url' => [
										'target' => 'aimeos_page',
									],
								],
								'cancel' => [
									'url' => [
										'target' => 'aimeos_page',
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
		'jobs' => [
			'to-email' => config( 'mail.from.address' ),
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
