<?php

return array(
	'apc_enabled' => false,
	'apc_prefix' => 'laravel:',
	'extdir' => ( is_dir(base_path('ext')) ? base_path('ext') : dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'ext' ),
	'uploaddir' => '/',

	'routes' => array(
		'admin' => array(),
		'account' => array('middleware' => 'auth'),
		'default' => array(),
	),

	'page' => array(
		'account-index' => array( 'account/history','account/favorite','account/watch','basket/mini','catalog/session' ),
		'basket-index' => array( 'basket/standard','basket/related' ),
		'catalog-count' => array( 'catalog/count' ),
		'catalog-detail' => array( 'basket/mini','catalog/stage','catalog/detail','catalog/session' ),
		'catalog-list' => array( 'basket/mini','catalog/filter','catalog/stage','catalog/lists' ),
		'catalog-stock' => array( 'catalog/stock' ),
		'catalog-suggest' => array( 'catalog/suggest' ),
		'checkout-confirm' => array( 'checkout/confirm' ),
		'checkout-index' => array( 'checkout/standard' ),
		'checkout-update' => array( 'checkout/update'),
	),

	'resource' => array(
		'db' => array(
			'adapter' => 'mysql',
			'host' => env('DB_HOST', 'localhost'),
			'port' => env('DB_PORT', ''),
			'database' => env('DB_DATABASE', 'laravel'),
			'username' => env('DB_USERNAME', 'root'),
			'password' => env('DB_PASSWORD', ''),
			'stmt' => array( "SET NAMES 'utf8'", "SET SESSION sql_mode='ANSI'" ),
			'opt-persistent' => 0,
			'limit' => 2,
		),
	),

	'client' => array(
		'html' => array(
			'account' => array(
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
				'list' => array(
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
			),
			'common' => array(
				'content' => array(
					'baseurl' => '/',
				),
				'template' => array(
					'baseurl' => 'packages/aimeos/shop/elegance',
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
	),

	'controller' => array(
		'extjs' => array(
			'attribute' => array(
				'import' => array(
					'text' => array(
						'default' => array(
							'uploaddir' => public_path( 'uploads' ),
							'fileperms' => '0660',
						),
					),
				),
				'export' => array(
					'text' => array(
						'default' => array(
							'exportdir' => public_path( 'uploads' ),
							'downloaddir' => 'uploads',
						),
					),
				),
			),
			'catalog' => array(
				'import' => array(
					'text' => array(
						'default' => array(
							'uploaddir' => public_path( 'uploads' ),
							'fileperms' => '0660',
						),
					),
				),
				'export' => array(
					'text' => array(
						'default' => array(
							'exportdir' => public_path( 'uploads' ),
							'downloaddir' => 'uploads',
						),
					),
				),
			),
			'media' => array(
				'default' => array(
					# Base directory to the document root of the website
					'basedir' => public_path(),
					# Upload related settings
					'upload' => array(
						# Media directory where the uploaded files will be stored, must be relative to the path in "basedir"
						'directory' => 'uploads',
						# Directory permissions (in octal notation) which are applied to newly created directories
						# dirperms: 0775
						# File permissions (in octal notation) which are applied to newly created files
						#fileperms: 0664
						# Mime icon related settings
					),
					'mimeicon' => array(
						# Directory where icons for the mime types stored. Must be relative to the path in "basedir"
						'directory' => '/packages/aimeos/shop/mimeicons',
						# File extension of mime type icons
						'extension' => '.png'
						# Parameter for images
					),
					'files' => array(
						# Allowed image mime types, other image types will be converted
						# allowedtypes: [image/jpeg, image/png, image/gif ]
						# Image type to which all other image types will be converted to
						# defaulttype: jpeg
						# Maximum width of an image
						# Image will be scaled up or down to this size without changing the
						# width/height ratio. A value of "null" doesn't scale the image or
						# doesn't restrict the size of the image if it's scaled due to a value
						# in the "maxheight" parameter
						# maxwidth:
						# Maximum height of an image
						# Image will be scaled up or down to this size without changing the
						# width/height ratio. A value of "null" doesn't scale the image or
						# doesn't restrict the size of the image if it's scaled due to a value
						# in the "maxwidth" parameter
						# maxheight:
						# Parameter for preview images
					),
					'preview' => array(
						# Allowed image mime types, other image types will be converted
						# allowedtypes: [image/jpeg, image/png, image/gif ]
						# Image type to which all other image types will be converted to
						# defaulttype: jpeg
						# Maximum width of a preview image
						# Image will be scaled up or down to this size without changing the
						# width/height ratio. A value of "null" doesn't scale the image or
						# doesn't restrict the size of the image if it's scaled due to a value
						# in the "maxheight" parameter
						# maxwidth: 360
						# Maximum height of a preview image
						# Image will be scaled up or down to this size without changing the
						# width/height ratio. A value of "null" doesn't scale the image or
						# doesn't restrict the size of the image if it's scaled due to a value
						# in the "maxwidth" parameter
						# maxheight: 280
					),
				),
			),
			'product' => array(
				'import' => array(
					'text' => array(
						'default' => array(
							'uploaddir' => public_path( 'uploads' ),
							'fileperms' => '0660',
						),
					),
				),
				'export' => array(
					'text' => array(
						'default' => array(
							'exportdir' => public_path( 'uploads' ),
							'downloaddir' => 'uploads',
						),
					),
				),
			),
		),
		'jsonadm' => array(
			'url' => array(
				'target' => 'aimeos_shop_jsonadm_get',
				'config' => array(
					'absoluteUri' => true,
				),
			),
		),
	),

	'i18n' => array(
	),

	'madmin' => array(
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
				'attribute' => array(
					'name' => 'MySQL',
				),
				'catalog' => array(
					'name' => 'MySQL',
				),
				'price' => array(
					'name' => 'MySQL',
				),
				'text' => array(
					'name' => 'MySQL',
				),
			),
		),
	),

);
