<?php

class CatalogControllerTest extends AimeosTestAbstract
{
	public function setUp()
	{
		parent::setUp();
		View::addLocation(dirname(__DIR__).'/fixtures/views');

		require dirname(dirname(__DIR__)).'/src/routes.php';
		require dirname(dirname(__DIR__)).'/src/routes_account.php';
	}


	public function testCountAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CatalogController@countAction');
		$this->assertResponseOk();
	}


	public function testDetailAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CatalogController@detailAction');
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
}