<?php

class AimeosTestAbstract extends Orchestra\Testbench\TestCase
{
	protected function getEnvironmentSetUp($app)
	{
		$app['config']->set('database.default', 'mysql');
		$app['config']->set('database.connections.mysql', [
			'driver' => 'mysql',
			'host' => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'laravel'),
			'username' => env('DB_USERNAME', 'root'),
			'password' => env('DB_PASSWORD', ''),
		]);

		$app['config']->set('routes.account', ['prefix' => '{site}']);
		$app['config']->set('routes.default', ['prefix' => '{site}']);
	}


	protected function getPackageProviders($app)
	{
		return ['Aimeos\Shop\ShopServiceProvider'];
	}
}