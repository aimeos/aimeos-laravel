<?php

class JsonapiControllerTest extends AimeosTestAbstract
{
	public function testOptionsAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'unittest'];
		$response = $this->action( 'OPTIONS', '\Aimeos\Shop\Controller\JsonapiController@optionsAction', $params );

		$json = json_decode( $response->getContent(), true );

		$this->assertNotNull( $json );
		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertArrayHasKey( 'resources', $json['meta'] );
		$this->assertGreaterThan( 1, count( $json['meta']['resources'] ) );
	}


	public function testGetAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'unittest', 'resource' => 'product'];
		$getParams = ['filter' => ['f_search' => 'Cafe Noire Cap']];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JsonapiController@getAction', $params, $getParams );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 2, $json['meta']['total'] );
		$this->assertEquals( 2, count( $json['data'] ) );
		$this->assertArrayHasKey( 'id', $json['data'][0] );
		$this->assertEquals( 'CNC', $json['data'][0]['attributes']['product.code'] );

		$id = $json['data'][0]['id'];


		$params = ['site' => 'unittest', 'resource' => 'product', 'id' => $id];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JsonapiController@getAction', $params );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 1, $json['meta']['total'] );
		$this->assertArrayHasKey( 'id', $json['data'] );
		$this->assertEquals( 'CNC', $json['data']['attributes']['product.code'] );
	}


	public function testPostPatchDeleteAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		// get CNC product
		$params = ['site' => 'unittest', 'resource' => 'product'];
		$getParams = ['filter' => ['f_search' => 'Cafe Noire Cap', 'f_listtype' => 'unittype19']];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JsonapiController@getAction', $params, $getParams );

		$json = json_decode( $response->getContent(), true );
		$this->assertEquals( 'CNC', $json['data'][0]['attributes']['product.code'] );

		// add CNC product to basket
		$params = ['site' => 'unittest', 'resource' => 'basket', 'id' => 'default', 'related' => 'product'];
		$content = json_encode( ['data' => ['attributes' => ['product.id' => $json['data'][0]['id']]]] );
		$response = $this->action( 'POST', '\Aimeos\Shop\Controller\JsonapiController@postAction', $params, [], [], [], [], $content );

		$json = json_decode( $response->getContent(), true );
		$this->assertEquals( 'CNC', $json['included'][0]['attributes']['order.base.product.prodcode'] );

		// change product quantity in basket
		$params = ['site' => 'unittest', 'resource' => 'basket', 'id' => 'default', 'related' => 'product', 'relatedid' => 0];
		$content = json_encode( ['data' => ['attributes' => ['quantity' => 2]]] );
		$response = $this->action( 'PATCH', '\Aimeos\Shop\Controller\JsonapiController@patchAction', $params, [], [], [], [], $content );

		$json = json_decode( $response->getContent(), true );
		$this->assertEquals( 2, $json['included'][0]['attributes']['order.base.product.quantity'] );

		// delete product from basket
		$params = ['site' => 'unittest', 'resource' => 'basket', 'id' => 'default', 'related' => 'product', 'relatedid' => 0];
		$response = $this->action( 'DELETE', '\Aimeos\Shop\Controller\JsonapiController@deleteAction', $params );

		$json = json_decode( $response->getContent(), true );
		$this->assertEquals( 0, count( $json['included'] ) );
	}


	public function testPutAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'unittest', 'resource' => 'basket'];
		$response = $this->action( 'PUT', '\Aimeos\Shop\Controller\JsonapiController@putAction', $params );

		$json = json_decode( $response->getContent(), true );
		$this->assertArrayHasKey( 'errors', $json );
	}
}
