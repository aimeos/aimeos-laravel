<?php

class JsonapiControllerTest extends AimeosTestAbstract
{
	public function testOptionsAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'unittest'];
		$response = $this->action( 'OPTIONS', '\Aimeos\Shop\Controller\JsonapiController@optionsAction', $params );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertArrayHasKey( 'resources', $json['meta'] );
		$this->assertGreaterThan( 1, count( $json['meta']['resources'] ) );
	}


	public function testGetAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'unittest', 'resource' => 'product'];
		$getParams = ['filter' => ['f_search' => 'Cafe Noire Cap'], 'sort' => 'product.code'];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JsonapiController@getAction', $params, $getParams );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 3, $json['meta']['total'] );
		$this->assertEquals( 3, count( $json['data'] ) );
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
		$getParams = ['filter' => ['f_search' => 'Cafe Noire Cap', 'f_listtype' => 'unittype19'], 'sort' => 'product.code'];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JsonapiController@getAction', $params, $getParams );

		$this->assertResponseOk();
		$json = json_decode( $response->getContent(), true );
		$this->assertEquals( 'CNC', $json['data'][0]['attributes']['product.code'] );

		// add CNC product to basket
		$params = ['site' => 'unittest', 'resource' => 'basket', 'id' => 'default', 'related' => 'product'];
		$content = json_encode( ['data' => ['attributes' => ['product.id' => $json['data'][0]['id']]]] );
		$response = $this->action( 'POST', '\Aimeos\Shop\Controller\JsonapiController@postAction', $params, [], [], [], [], $content );

		$this->assertEquals( 201, $response->getStatusCode() );
		$json = json_decode( $response->getContent(), true );
		$this->assertEquals( 'CNC', $json['included'][0]['attributes']['order.base.product.prodcode'] );

		// change product quantity in basket
		$params = ['site' => 'unittest', 'resource' => 'basket', 'id' => 'default', 'related' => 'product', 'relatedid' => 0];
		$content = json_encode( ['data' => ['attributes' => ['quantity' => 2]]] );
		$response = $this->action( 'PATCH', '\Aimeos\Shop\Controller\JsonapiController@patchAction', $params, [], [], [], [], $content );

		$this->assertResponseOk();
		$json = json_decode( $response->getContent(), true );
		$this->assertEquals( 2, $json['included'][0]['attributes']['order.base.product.quantity'] );

		// delete product from basket
		$params = ['site' => 'unittest', 'resource' => 'basket', 'id' => 'default', 'related' => 'product', 'relatedid' => 0];
		$response = $this->action( 'DELETE', '\Aimeos\Shop\Controller\JsonapiController@deleteAction', $params );

		$this->assertResponseOk();
		$json = json_decode( $response->getContent(), true );
		$this->assertEquals( 0, count( $json['included'] ) );
	}


	public function testPutAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$params = ['site' => 'unittest', 'resource' => 'basket'];
		$response = $this->action( 'PUT', '\Aimeos\Shop\Controller\JsonapiController@putAction', $params );

		$this->assertEquals( 403, $response->getStatusCode() );
		$json = json_decode( $response->getContent(), true );
		$this->assertArrayHasKey( 'errors', $json );
	}
}
