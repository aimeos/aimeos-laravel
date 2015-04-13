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
		$response = $this->action('GET', '\Aimeos\Shop\Controller\CatalogController@countAction');

		$this->assertResponseOk();
		$this->assertContains('.catalog-filter-count', $response->getContent());
		$this->assertContains('.catalog-filter-attribute', $response->getContent());
	}


	public function testDetailAction()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\CatalogController@detailAction');

		$this->assertResponseOk();
		$this->assertContains('<section class="aimeos catalog-stage">', $response->getContent());
		$this->assertContains('<section class="aimeos catalog-detail">', $response->getContent());
		$this->assertContains('<section class="aimeos catalog-session">', $response->getContent());
	}


	public function testListAction()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\CatalogController@listAction');

		$this->assertResponseOk();
		$this->assertContains('<section class="aimeos catalog-filter">', $response->getContent());
		$this->assertContains('<section class="aimeos catalog-stage">', $response->getContent());
		$this->assertContains('<section class="aimeos catalog-list">', $response->getContent());
	}


	public function testStockAction()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\CatalogController@stockAction');

		$this->assertResponseOk();
		$this->assertContains('.aimeos .product .stock', $response->getContent());
	}


	public function testSuggestAction()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\CatalogController@suggestAction');

		$this->assertResponseOk();
		$this->assertContains('[]', $response->getContent());
	}
}