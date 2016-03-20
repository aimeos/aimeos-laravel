<?php

return array(
	'apc_enabled' => false,
	'apc_prefix' => 'laravel:',
	'extdir' => ( is_dir(base_path('ext')) ? base_path('ext') : dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'ext' ),
	'uploaddir' => '/',

	'routes' => array(
		# 'login' => array('middleware' => ['web']),
		# 'admin' => array('middleware' => ['web', 'auth']),
		# 'account' => array('middleware' => ['web', 'auth']),
		# 'default' => array('middleware' => ['web']),
		# 'confirm' => array('middleware' => ['web']),
		# 'update' => array(),
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
		'fs' => array(
			'adapter' => 'Standard',
			'basedir' => public_path(),
			'tempdir' => storage_path( 'tmp' ),
		),
		'fs-admin' => array(
			'adapter' => 'Standard',
			'basedir' => public_path( 'uploads' ),
			'tempdir' => storage_path( 'tmp' ),
		),
		'fs-secure' => array(
			'adapter' => 'Standard',
			'basedir' => storage_path( 'secure' ),
			'tempdir' => storage_path( 'tmp' ),
		),
	),

	'client' => array(
		'html' => array(
			'common' => array(
				'content' => array(
					'baseurl' => '/',
				),
				'template' => array(
					'baseurl' => 'packages/aimeos/shop/elegance',
				),
			),
		),
	),

	'controller' => array(
		'extjs' => array(
			'attribute' => array(
				'export' => array(
					'text' => array(
						'default' => array(
							'downloaddir' => 'uploads',
						),
					),
				),
			),
			'catalog' => array(
				'export' => array(
					'text' => array(
						'default' => array(
							'downloaddir' => 'uploads',
						),
					),
				),
			),
			'media' => array(
				'default' => array(
					'mimeicon' => array(
						# Directory where icons for the mime types stored
						'directory' => public_path( '/packages/aimeos/shop/mimeicons' ),
						# File extension of mime type icons
						'extension' => '.png'
					),
					# Parameters for uploaded images
					'files' => array(
						# Allowed image mime types, other image types will be converted
						# 'allowedtypes' => ['image/jpeg', 'image/png', 'image/gif'],
						#
						# Image type to which all other image types will be converted to
						# 'defaulttype' => 'jpeg',
						#
						# Maximum width of an image
						# Image will be scaled up or down to this size without changing the
						# width/height ratio. A value of "null" doesn't scale the image or
						# doesn't restrict the size of the image if it's scaled due to a value
						# in the "maxheight" parameter
						# 'maxwidth' => null,
						#
						# Maximum height of an image
						# Image will be scaled up or down to this size without changing the
						# width/height ratio. A value of "null" doesn't scale the image or
						# doesn't restrict the size of the image if it's scaled due to a value
						# in the "maxwidth" parameter
						# 'maxheight' => null,
					),
					# Parameters for preview images
					'preview' => array(
						# Allowed image mime types, other image types will be converted
						# 'allowedtypes' => ['image/jpeg', 'image/png', 'image/gif'],
						#
						# Image type to which all other image types will be converted to
						# 'defaulttype' => 'jpeg',
						#
						# Maximum width of an image
						# Image will be scaled up or down to this size without changing the
						# width/height ratio. A value of "null" doesn't scale the image or
						# doesn't restrict the size of the image if it's scaled due to a value
						# in the "maxheight" parameter
						# 'maxwidth' => 360,
						#
						# Maximum height of an image
						# Image will be scaled up or down to this size without changing the
						# width/height ratio. A value of "null" doesn't scale the image or
						# doesn't restrict the size of the image if it's scaled due to a value
						# in the "maxwidth" parameter
						# 'maxheight' => 280,
					),
					'tempdir' => storage_path( 'aimeos' ),
				),
			),
			'product' => array(
				'export' => array(
					'text' => array(
						'default' => array(
							'downloaddir' => 'uploads',
						),
					),
				),
			),
		),
	),

	'i18n' => array(
	),

	'madmin' => array(
	),

	'mshop' => array(
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
