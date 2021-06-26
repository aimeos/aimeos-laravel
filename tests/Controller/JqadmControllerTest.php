<?php

class JqadmControllerTest extends AimeosTestAbstract
{
	public function testFileActionCss()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JqadmController@fileAction', ['site' => 'unittest', 'type' => 'css'] );

		$this->assertResponseOk();
		$this->assertStringContainsString( '.aimeos', $response->getContent() );
	}


	public function testFileActionJs()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JqadmController@fileAction', ['site' => 'unittest', 'type' => 'js'] );

		$this->assertResponseOk();
		$this->assertStringContainsString( 'Aimeos = {', $response->getContent() );
	}


	public function testCopyAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'unittest', 'resource' => 'product', 'id' => '0'];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JqadmController@copyAction', $params );

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertStringContainsString( 'item-product', $response->getContent() );
	}


	public function testCreateAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'unittest', 'resource' => 'product'];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JqadmController@createAction', $params );

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertStringContainsString( 'item-product', $response->getContent() );
	}


	public function testDeleteAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );
		$this->app['session']->setPreviousUrl( 'http://localhost/unittest' );

		$params = ['site' => 'unittest', 'resource' => 'product', 'id' => '0'];
		$response = $this->action( 'POST', '\Aimeos\Shop\Controller\JqadmController@deleteAction', $params );

		$this->assertEquals( 302, $response->getStatusCode() );
	}


	public function testExportAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'unittest', 'resource' => 'order'];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JqadmController@exportAction', $params );

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertStringContainsString( 'list-items', $response->getContent() );
	}


	public function testGetAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'unittest', 'resource' => 'product', 'id' => '0'];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JqadmController@getAction', $params );

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertStringContainsString( 'item-product', $response->getContent() );
	}


	public function testSaveAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );
		$this->app['session']->setPreviousUrl( 'http://localhost/unittest' );

		$params = ['site' => 'unittest', 'resource' => 'product', 'id' => '0'];
		$response = $this->action( 'POST', '\Aimeos\Shop\Controller\JqadmController@saveAction', $params );

		$this->assertEquals( 302, $response->getStatusCode() );
	}


	public function testSearchAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'unittest', 'resource' => 'product'];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JqadmController@searchAction', $params );

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertStringContainsString( 'list-items', $response->getContent() );
	}


	public function testSearchActionSite()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'invalid', 'resource' => 'product'];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JqadmController@searchAction', $params );

		$this->assertEquals( 500, $response->getStatusCode() );
	}
}
