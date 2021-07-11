<?php

class CatalogControllerTest extends AimeosTestAbstract
{
	public function testCountAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\CatalogController@countAction', ['site' => 'unittest'] );

		$this->assertResponseOk();
		$this->assertStringContainsString( '.catalog-filter-count', $response->getContent() );
		$this->assertStringContainsString( '.catalog-filter-attribute', $response->getContent() );
	}


	public function testDetailAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\CatalogController@detailAction', ['site' => 'unittest', 'd_name' => 'Cafe_Noire_Cappuccino'] );

		$this->assertResponseOk();
		$this->assertStringContainsString( '<section class="aimeos catalog-stage', $response->getContent() );
		$this->assertStringContainsString( '<section class="aimeos catalog-detail', $response->getContent() );
	}


	public function testListAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\CatalogController@listAction', ['site' => 'unittest'] );

		$this->assertResponseOk();
		$this->assertStringContainsString( '<section class="aimeos catalog-filter', $response->getContent() );
		$this->assertStringContainsString( '<section class="aimeos catalog-list', $response->getContent() );
	}


	public function testSessionAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\CatalogController@sessionAction', ['site' => 'unittest'] );

		$this->assertResponseOk();
		$this->assertStringContainsString( '<section class="aimeos catalog-session', $response->getContent() );
		$this->assertStringContainsString( '<section class="catalog-session-pinned', $response->getContent() );
		$this->assertStringContainsString( '<section class="catalog-session-seen', $response->getContent() );
	}


	public function testStockAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\CatalogController@stockAction', ['site' => 'unittest'] );

		$this->assertResponseOk();
		$this->assertStringContainsString( '.aimeos .product .stock', $response->getContent() );
	}


	public function testSuggestAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\CatalogController@suggestAction', ['site' => 'unittest'], ['f_search' => 'Cafe'] );

		$this->assertResponseOk();
		$this->assertRegexp( '/[{.*}]/', $response->getContent() );
	}


	public function testTreeAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\CatalogController@treeAction', ['site' => 'unittest', 'f_catid' => 1, 'f_name' => 'test'] );

		$this->assertResponseOk();
		$this->assertStringContainsString( '<section class="aimeos catalog-filter', $response->getContent() );
		$this->assertStringContainsString( '<section class="aimeos catalog-list', $response->getContent() );
	}
}