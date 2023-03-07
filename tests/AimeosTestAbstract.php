<?php

abstract class AimeosTestAbstract extends Orchestra\Testbench\BrowserKit\TestCase
{
	protected function getEnvironmentSetUp( $app )
	{
		putenv( 'APP_DEBUG=1' );

		$app['config']->set( 'app.key', 'SomeRandomStringWith32Characters' );
		$app['config']->set( 'app.cipher', 'AES-256-CBC' );

		$app['config']->set( 'database.default', 'mysql' );
		$app['config']->set( 'database.connections.mysql', [
			'driver' => 'mysql',
			'host' => env( 'DB_HOST', '127.0.0.1' ),
			'port' => env( 'DB_PORT', '3306' ),
			'database' => env( 'DB_DATABASE', 'laravel' ),
			'username' => env( 'DB_USERNAME', 'aimeos' ),
			'password' => env( 'DB_PASSWORD', 'aimeos' ),
			'unix_socket' => env( 'DB_SOCKET', '' ),
			'collation' => 'utf8_unicode_ci',
		] );

		$app['config']->set( 'shop.resource.db', [
			'adapter' => 'mysql',
			'host' => env( 'DB_HOST', '127.0.0.1' ),
			'database' => env( 'DB_DATABASE', 'laravel' ),
			'username' => env( 'DB_USERNAME', 'aimeos' ),
			'password' => env( 'DB_PASSWORD', 'aimeos' ),
			'stmt' => ["SET SESSION sort_buffer_size=2097144; SET SESSION sql_mode='ANSI'; SET NAMES 'utf8'"],
			'opt-persistent' => 0,
			'limit' => 3,
			'defaultTableOptions' => [
				'collate' => 'utf8_unicode_ci',
				'charset' => 'utf8',
			],
		] );

		$app['config']->set( 'shop.resource.fs', [
			'adapter' => 'Standard',
			'tempdir' => storage_path( 'tmp' ),
			'basedir' => storage_path( 'tmp' ),
			'baseurl' => '/aimeos',
		] );

		$app['config']->set( 'shop.authorize', false );
		$app['config']->set( 'shop.disableSites', false );
		$app['config']->set( 'shop.accessControl', false );
		$app['config']->set( 'shop.admin.graphql.debug', true );
		$app['config']->set( 'shop.routes.jqadm', ['prefix' => '{site}/jqadm'] );
		$app['config']->set( 'shop.routes.graphql', ['prefix' => '{site}/graphql'] );
		$app['config']->set( 'shop.routes.jsonadm', ['prefix' => '{site}/jsonadm'] );
		$app['config']->set( 'shop.routes.jsonapi', ['prefix' => '{site}/jsonapi'] );
		$app['config']->set( 'shop.routes.account', ['prefix' => '{site}/profile'] );
		$app['config']->set( 'shop.routes.default', ['prefix' => '{site}/shop'] );
		$app['config']->set( 'shop.routes.update', ['prefix' => '{site}'] );
		$app['config']->set( 'shop.routes.page', ['prefix' => '{site}/p'] );
		$app['config']->set( 'shop.routes.login', [] );
		$app['config']->set( 'shop.mshop.locale.site', 'unittest' );
		$app['config']->set( 'shop.resource.email.from-email', 'root@localhost' );

		Route::any( 'login', ['as' => 'login'] );
		Route::any( 'logout', ['as' => 'logout'] );
	}


	protected function getPackageProviders( $app )
	{
		return ['Aimeos\Shop\ShopServiceProvider'];
	}
}