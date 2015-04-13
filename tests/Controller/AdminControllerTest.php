<?php

class AdminControllerTest extends Orchestra\Testbench\TestCase
{
	public function setUp()
	{
		parent::setUp();
		require dirname(dirname(__DIR__)).'/src/routes_admin.php';
	}


	public function testIndexAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\AdminController@indexAction');
		$this->assertResponseOk();
	}


	public function testDoAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\AdminController@doAction');
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