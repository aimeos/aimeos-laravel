<?php

class AccountControllerTest extends Orchestra\Testbench\TestCase
{
	public function setUp()
	{
		parent::setUp();
		View::addLocation(dirname(__DIR__) . '/fixtures/views');
	}


	public function testActions()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\AccountController@indexAction');
		$this->assertResponseOk();
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