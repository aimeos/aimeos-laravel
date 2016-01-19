<?php

class JqadmControllerTest extends AimeosTestAbstract
{
	public function setUp()
	{
		parent::setUp();
		View::addLocation(dirname(__DIR__).'/fixtures/views');
	}


	public function testCopyAction()
	{
		$params = ['site' => 'unittest', 'resource' => 'product', 'id' => '0'];
		$response = $this->action('GET', '\Aimeos\Shop\Controller\JqadmController@copyAction', $params);

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertContains( '<div class="product-item', $response->getContent() );
	}


	public function testCreateAction()
	{
		$params = ['site' => 'unittest', 'resource' => 'product'];
		$response = $this->action('GET', '\Aimeos\Shop\Controller\JqadmController@createAction', $params);

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertContains( '<div class="product-item', $response->getContent() );
	}


	public function testDeleteAction()
	{
		$params = ['site' => 'unittest', 'resource' => 'product', 'id' => '0'];
		$response = $this->action('GET', '\Aimeos\Shop\Controller\JqadmController@deleteAction', $params);

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertContains( '<table class="list-items', $response->getContent() );
	}


	public function testGetAction()
	{
		$params = ['site' => 'unittest', 'resource' => 'product', 'id' => '0'];
		$response = $this->action('GET', '\Aimeos\Shop\Controller\JqadmController@getAction', $params);

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertContains( '<div class="product-item', $response->getContent() );
	}


	public function testSaveAction()
	{
		$params = ['site' => 'unittest', 'resource' => 'product', 'id' => '0'];
		$response = $this->action('POST', '\Aimeos\Shop\Controller\JqadmController@saveAction', $params);

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertContains( '<div class="product-item', $response->getContent() );
	}


	public function testSearchAction()
	{
		$params = ['site' => 'unittest', 'resource' => 'product'];
		$response = $this->action('GET', '\Aimeos\Shop\Controller\JqadmController@searchAction', $params);

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertContains( '<table class="list-items', $response->getContent() );
	}


	public function testSearchActionSite()
	{
		$params = ['site' => 'invalid', 'resource' => 'product'];
		$response = $this->action('GET', '\Aimeos\Shop\Controller\JqadmController@searchAction', $params);

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertContains( '<table class="list-items', $response->getContent() );
	}
}
