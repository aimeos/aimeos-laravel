<?php

class JsonadmControllerTest extends AimeosTestAbstract
{
	public function testOptionsActionSite()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );
		$this->app['session']->setPreviousUrl( 'http://localhost/invalid' );

		$params = ['site' => 'invalid', 'resource' => 'product'];
		$response = $this->action( 'OPTIONS', '\Aimeos\Shop\Controller\JsonadmController@optionsAction', $params );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
	}


	public function testOptionsAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );
		$this->app['session']->setPreviousUrl( 'http://localhost/unittest' );

		$params = ['site' => 'unittest', 'resource' => 'product'];
		$response = $this->action( 'OPTIONS', '\Aimeos\Shop\Controller\JsonadmController@optionsAction', $params );

		$json = json_decode( $response->getContent(), true );

		$this->assertNotNull( $json );
		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertArrayHasKey( 'resources', $json['meta'] );
		$this->assertGreaterThan( 1, count( $json['meta']['resources'] ) );


		$params = ['site' => 'unittest'];
		$response = $this->action( 'OPTIONS', '\Aimeos\Shop\Controller\JsonadmController@optionsAction', $params );

		$json = json_decode( $response->getContent(), true );

		$this->assertNotNull( $json );
		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertArrayHasKey( 'resources', $json['meta'] );
		$this->assertGreaterThan( 1, count( $json['meta']['resources'] ) );
	}


	public function testActionsSingle()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );
		$this->app['session']->setPreviousUrl( 'http://localhost/unittest' );

		$params = ['site' => 'unittest', 'resource' => 'stock/type'];
		$content = '{"data":{"type":"stock/type","attributes":{"stock.type.code":"laravel","stock.type.label":"laravel"}}}';
		$response = $this->action( 'POST', '\Aimeos\Shop\Controller\JsonadmController@postAction', $params, [], [], [], [], $content );

		$json = json_decode( $response->getContent(), true );

		$this->assertEquals( 201, $response->getStatusCode() );
		$this->assertNotNull( $json );
		$this->assertArrayHasKey( 'stock.type.id', $json['data']['attributes'] );
		$this->assertEquals( 'laravel', $json['data']['attributes']['stock.type.code'] );
		$this->assertEquals( 'laravel', $json['data']['attributes']['stock.type.label'] );
		$this->assertEquals( 1, $json['meta']['total'] );

		$id = $json['data']['attributes']['stock.type.id'];


		$params = ['site' => 'unittest', 'resource' => 'stock/type', 'id' => $id];
		$content = '{"data":{"type":"stock/type","attributes":{"stock.type.code":"laravel2","stock.type.label":"laravel2"}}}';
		$response = $this->action( 'PATCH', '\Aimeos\Shop\Controller\JsonadmController@patchAction', $params, [], [], [], [], $content );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertArrayHasKey( 'stock.type.id', $json['data']['attributes'] );
		$this->assertEquals( 'laravel2', $json['data']['attributes']['stock.type.code'] );
		$this->assertEquals( 'laravel2', $json['data']['attributes']['stock.type.label'] );
		$this->assertEquals( $id, $json['data']['attributes']['stock.type.id'] );
		$this->assertEquals( 1, $json['meta']['total'] );


		$params = ['site' => 'unittest', 'resource' => 'stock/type', 'id' => $id];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JsonadmController@getAction', $params );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertArrayHasKey( 'stock.type.id', $json['data']['attributes'] );
		$this->assertEquals( 'laravel2', $json['data']['attributes']['stock.type.code'] );
		$this->assertEquals( 'laravel2', $json['data']['attributes']['stock.type.label'] );
		$this->assertEquals( $id, $json['data']['attributes']['stock.type.id'] );
		$this->assertEquals( 1, $json['meta']['total'] );


		$params = ['site' => 'unittest', 'resource' => 'stock/type', 'id' => $id];
		$response = $this->action( 'DELETE', '\Aimeos\Shop\Controller\JsonadmController@deleteAction', $params );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 1, $json['meta']['total'] );
	}


	public function testActionsBulk()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );
		$this->app['session']->setPreviousUrl( 'http://localhost/unittest' );

		$params = ['site' => 'unittest', 'resource' => 'stock/type'];
		$content = '{"data":[
			{"type":"stock/type","attributes":{"stock.type.code":"laravel","stock.type.label":"laravel"}},
			{"type":"stock/type","attributes":{"stock.type.code":"laravel2","stock.type.label":"laravel"}}
		]}';
		$response = $this->action( 'POST', '\Aimeos\Shop\Controller\JsonadmController@postAction', $params, [], [], [], [], $content );

		$json = json_decode( $response->getContent(), true );

		$this->assertEquals( 201, $response->getStatusCode() );
		$this->assertNotNull( $json );
		$this->assertEquals( 2, count( $json['data'] ) );
		$this->assertArrayHasKey( 'stock.type.id', $json['data'][0]['attributes'] );
		$this->assertArrayHasKey( 'stock.type.id', $json['data'][1]['attributes'] );
		$this->assertEquals( 'laravel', $json['data'][0]['attributes']['stock.type.label'] );
		$this->assertEquals( 'laravel', $json['data'][1]['attributes']['stock.type.label'] );
		$this->assertEquals( 2, $json['meta']['total'] );

		$ids = array( $json['data'][0]['attributes']['stock.type.id'], $json['data'][1]['attributes']['stock.type.id'] );


		$params = ['site' => 'unittest', 'resource' => 'stock/type'];
		$content = '{"data":[
			{"type":"stock/type","id":' . $ids[0] . ',"attributes":{"stock.type.label":"laravel2"}},
			{"type":"stock/type","id":' . $ids[1] . ',"attributes":{"stock.type.label":"laravel2"}}
		]}';
		$response = $this->action( 'PATCH', '\Aimeos\Shop\Controller\JsonadmController@patchAction', $params, [], [], [], [], $content );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 2, count( $json['data'] ) );
		$this->assertArrayHasKey( 'stock.type.id', $json['data'][0]['attributes'] );
		$this->assertArrayHasKey( 'stock.type.id', $json['data'][1]['attributes'] );
		$this->assertEquals( 'laravel2', $json['data'][0]['attributes']['stock.type.label'] );
		$this->assertEquals( 'laravel2', $json['data'][1]['attributes']['stock.type.label'] );
		$this->assertTrue( in_array( $json['data'][0]['attributes']['stock.type.id'], $ids ) );
		$this->assertTrue( in_array( $json['data'][1]['attributes']['stock.type.id'], $ids ) );
		$this->assertEquals( 2, $json['meta']['total'] );


		$params = ['site' => 'unittest', 'resource' => 'stock/type'];
		$getParams = ['filter' => ['&&' => [
			['=~' => ['stock.type.code' => 'laravel']],
			['==' => ['stock.type.label' => 'laravel2']]
			]],
			'sort' => 'stock.type.code', 'page' => ['offset' => 0, 'limit' => 3]
		];
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\JsonadmController@getAction', $params, $getParams );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 2, count( $json['data'] ) );
		$this->assertEquals( 'laravel', $json['data'][0]['attributes']['stock.type.code'] );
		$this->assertEquals( 'laravel2', $json['data'][1]['attributes']['stock.type.code'] );
		$this->assertEquals( 'laravel2', $json['data'][0]['attributes']['stock.type.label'] );
		$this->assertEquals( 'laravel2', $json['data'][1]['attributes']['stock.type.label'] );
		$this->assertTrue( in_array( $json['data'][0]['attributes']['stock.type.id'], $ids ) );
		$this->assertTrue( in_array( $json['data'][1]['attributes']['stock.type.id'], $ids ) );
		$this->assertEquals( 2, $json['meta']['total'] );


		$params = ['site' => 'unittest', 'resource' => 'stock/type'];
		$content = '{"data":[
			{"type":"stock/type","id":' . $ids[0] . '},
			{"type":"stock/type","id":' . $ids[1] . '}
		]}';
		$response = $this->action( 'DELETE', '\Aimeos\Shop\Controller\JsonadmController@deleteAction', $params, [], [], [], [], $content );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 2, $json['meta']['total'] );
	}


	public function testPutAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );
		$this->app['session']->setPreviousUrl( 'http://localhost/unittest' );

		$params = ['site' => 'unittest', 'resource' => 'stock/type'];
		$content = '{"data":[
			{"type":"stock/type","attributes":{"stock.type.code":"laravel","stock.type.label":"laravel"}},
			{"type":"stock/type","attributes":{"stock.type.code":"laravel2","stock.type.label":"laravel"}}
		]}';
		$response = $this->action( 'PUT', '\Aimeos\Shop\Controller\JsonadmController@postAction', $params, [], [], [], [], $content );

		$json = json_decode( $response->getContent(), true );

		$this->assertEquals( 501, $response->getStatusCode() );
		$this->assertNotNull( $json );
	}
}
