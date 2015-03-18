<?php

class CatalogControllerTest extends TestCase
{
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
}