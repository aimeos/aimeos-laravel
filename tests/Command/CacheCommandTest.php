<?php

class CacheCommandTest extends Orchestra\Testbench\TestCase
{
	public function testSetupCommand()
	{
		$this->assertEquals(0, $this->artisan('aimeos:cache', array('site' => 'unittest')));
	}


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
	}


	protected function getPackageProviders()
	{
		return ['Aimeos\Shop\ShopServiceProvider'];
	}
}
