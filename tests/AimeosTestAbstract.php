<?php

class AimeosTestAbstract extends Orchestra\Testbench\BrowserKit\TestCase
{
	protected function getEnvironmentSetUp($app)
	{
		putenv( 'APP_DEBUG=1' );

		$app['config']->set('database.default', 'mysql');
		$app['config']->set('database.connections.mysql', [
			'driver' => 'mysql',
			'host' => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'laravel'),
			'username' => env('DB_USERNAME', 'root'),
			'password' => env('DB_PASSWORD', ''),
		]);

		$app['config']->set('app.key', 'SomeRandomStringWith32Characters');
		$app['config']->set('app.cipher', MCRYPT_RIJNDAEL_128);

		$app['config']->set('shop.authorize', false);
		$app['config']->set('shop.disableSites', false);
		$app['config']->set('shop.accessControl', false);
		$app['config']->set('shop.routes.jqadm', ['prefix' => '{site}/jqadm']);
		$app['config']->set('shop.routes.extadm', ['prefix' => '{site}/extadm']);
		$app['config']->set('shop.routes.jsonadm', ['prefix' => '{site}/jsonadm']);
		$app['config']->set('shop.routes.jsonapi', ['prefix' => '{site}/jsonapi']);
		$app['config']->set('shop.routes.account', ['prefix' => '{site}']);
		$app['config']->set('shop.routes.default', ['prefix' => '{site}']);
		$app['config']->set('shop.routes.confirm', ['prefix' => '{site}']);
		$app['config']->set('shop.routes.update', ['prefix' => '{site}']);
		$app['config']->set('shop.routes.login', []);
		$app['config']->set('shop.extdir', dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'ext' );
	}


	protected function getPackageProviders($app)
	{
		return ['Aimeos\Shop\ShopServiceProvider'];
	}
}