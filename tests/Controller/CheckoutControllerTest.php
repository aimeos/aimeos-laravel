<?php

class CheckoutControllerTest extends Orchestra\Testbench\TestCase
{
	public function setUp()
	{
		parent::setUp();
		View::addLocation(dirname(__DIR__) . '/fixtures/views');

		require dirname(dirname(__DIR__)).'/src/routes.php';
		require dirname(dirname(__DIR__)).'/src/routes_account.php';
	}


	public function testConfirmAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CheckoutController@confirmAction');
		$this->assertResponseOk();
	}


	public function testIndexAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CheckoutController@indexAction');
		$this->assertResponseOk();
	}


	public function testUpdateAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CheckoutController@updateAction');
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