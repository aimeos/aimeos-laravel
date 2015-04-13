<?php

class CatalogControllerTest extends Orchestra\Testbench\TestCase
{
	public function setUp()
	{
		parent::setUp();
		View::addLocation(dirname(__DIR__) . '/fixtures/views');
	}


	public function testCountAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CatalogController@countAction');
		$this->assertResponseOk();
	}


	public function testDetailAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CatalogController@detailAction', array('d_prodid' => 1));
		$this->assertResponseOk();
	}


	public function testListAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CatalogController@listAction');
		$this->assertResponseOk();
	}


	public function testStockAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CatalogController@stockAction');
		$this->assertResponseOk();
	}


	public function testSuggestAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CatalogController@suggestAction');
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