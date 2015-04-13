<?php

class SetupCommandTest extends Orchestra\Testbench\TestCase
{
	public function testSetupCommand()
	{
		$this->assertEquals(0, $this->artisan('aimeos:setup', array('site' => 'unittest')));
	}


	protected function getEnvironmentSetUp($app)
	{
		$app['config']->set('database.default', 'mysql');
		$app['config']->set('database.connections.mysql', [
			'driver' => 'mysql',
			'host' => 'localhost', //env('DB_HOST', 'localhost'),
			'database' => 'laravel', //env('DB_DATABASE', 'laravel'),
			'username' => 'root', //env('DB_USERNAME', 'root'),
			'password' => '', //env('DB_PASSWORD', ''),
		]);
	}


	protected function getPackageProviders()
	{
		return ['Aimeos\Shop\ShopServiceProvider'];
	}
}
