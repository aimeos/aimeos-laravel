<?php

class JsonadmControllerTest extends AimeosTestAbstract
{
	public function setUp()
	{
		parent::setUp();
		View::addLocation(dirname(__DIR__).'/fixtures/views');
	}


	public function testActionsSingle()
	{
		$params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse'];
		$content = '{"data":{"type":"product/stock/warehouse","attributes":{"product.stock.warehouse.code":"laravel","product.stock.warehouse.label":"laravel"}}}';
		$response = $this->action('POST', '\Aimeos\Shop\Controller\JsonadmController@postAction', $params, [], [], [], [], $content);

		$json = json_decode( $response->getContent(), true );

		$this->assertEquals( 201, $response->getStatusCode() );
		$this->assertNotNull( $json );
		$this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data']['attributes'] );
		$this->assertEquals( 'laravel', $json['data']['attributes']['product.stock.warehouse.code'] );
		$this->assertEquals( 'laravel', $json['data']['attributes']['product.stock.warehouse.label'] );
		$this->assertEquals( 1, $json['meta']['total'] );

		$id = $json['data']['attributes']['product.stock.warehouse.id'];


		$params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse', 'id' => $id ];
		$content = '{"data":{"type":"product/stock/warehouse","attributes":{"product.stock.warehouse.code":"laravel2","product.stock.warehouse.label":"laravel2"}}}';
		$response = $this->action('PATCH', '\Aimeos\Shop\Controller\JsonadmController@patchAction', $params, [], [], [], [], $content);

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data']['attributes'] );
		$this->assertEquals( 'laravel2', $json['data']['attributes']['product.stock.warehouse.code'] );
		$this->assertEquals( 'laravel2', $json['data']['attributes']['product.stock.warehouse.label'] );
		$this->assertEquals( $id, $json['data']['attributes']['product.stock.warehouse.id'] );
		$this->assertEquals( 1, $json['meta']['total'] );


		$params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse', 'id' => $id ];
		$response = $this->action('GET', '\Aimeos\Shop\Controller\JsonadmController@getAction', $params);

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data']['attributes'] );
		$this->assertEquals( 'laravel2', $json['data']['attributes']['product.stock.warehouse.code'] );
		$this->assertEquals( 'laravel2', $json['data']['attributes']['product.stock.warehouse.label'] );
		$this->assertEquals( $id, $json['data']['attributes']['product.stock.warehouse.id'] );
		$this->assertEquals( 1, $json['meta']['total'] );


		$params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse', 'id' => $id ];
		$response = $this->action('DELETE', '\Aimeos\Shop\Controller\JsonadmController@deleteAction', $params);

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 1, $json['meta']['total'] );
	}


	public function testActionsBulk()
	{
		$params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse'];
		$content = '{"data":[
			{"type":"product/stock/warehouse","attributes":{"product.stock.warehouse.code":"laravel","product.stock.warehouse.label":"laravel"}},
			{"type":"product/stock/warehouse","attributes":{"product.stock.warehouse.code":"laravel2","product.stock.warehouse.label":"laravel"}}
		]}';
		$response = $this->action('POST', '\Aimeos\Shop\Controller\JsonadmController@postAction', $params, [], [], [], [], $content);

		$json = json_decode( $response->getContent(), true );

		$this->assertEquals( 201, $response->getStatusCode() );
		$this->assertNotNull( $json );
		$this->assertEquals( 2, count( $json['data'] ) );
		$this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data'][0]['attributes'] );
		$this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data'][1]['attributes'] );
		$this->assertEquals( 'laravel', $json['data'][0]['attributes']['product.stock.warehouse.label'] );
		$this->assertEquals( 'laravel', $json['data'][1]['attributes']['product.stock.warehouse.label'] );
		$this->assertEquals( 2, $json['meta']['total'] );

		$ids = array( $json['data'][0]['attributes']['product.stock.warehouse.id'], $json['data'][1]['attributes']['product.stock.warehouse.id'] );


		$params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse' ];
		$content = '{"data":[
			{"type":"product/stock/warehouse","id":' . $ids[0] . ',"attributes":{"product.stock.warehouse.label":"laravel2"}},
			{"type":"product/stock/warehouse","id":' . $ids[1] . ',"attributes":{"product.stock.warehouse.label":"laravel2"}}
		]}';
		$response = $this->action('PATCH', '\Aimeos\Shop\Controller\JsonadmController@patchAction', $params, [], [], [], [], $content);

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 2, count( $json['data'] ) );
		$this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data'][0]['attributes'] );
		$this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data'][1]['attributes'] );
		$this->assertEquals( 'laravel2', $json['data'][0]['attributes']['product.stock.warehouse.label'] );
		$this->assertEquals( 'laravel2', $json['data'][1]['attributes']['product.stock.warehouse.label'] );
		$this->assertTrue( in_array( $json['data'][0]['attributes']['product.stock.warehouse.id'], $ids ) );
		$this->assertTrue( in_array( $json['data'][1]['attributes']['product.stock.warehouse.id'], $ids ) );
		$this->assertEquals( 2, $json['meta']['total'] );


		$params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse' ];
		$getParams = ['filter' => ['&&' => [
			['=~' => ['product.stock.warehouse.code' => 'laravel']],
			['==' => ['product.stock.warehouse.label' => 'laravel2']]
			]],
			'sort' => 'product.stock.warehouse.code', 'page' => ['offset' => 0, 'limit' => 3]
		];
		$response = $this->action('GET', '\Aimeos\Shop\Controller\JsonadmController@getAction', $params, $getParams);

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 2, count( $json['data'] ) );
		$this->assertEquals( 'laravel', $json['data'][0]['attributes']['product.stock.warehouse.code'] );
		$this->assertEquals( 'laravel2', $json['data'][1]['attributes']['product.stock.warehouse.code'] );
		$this->assertEquals( 'laravel2', $json['data'][0]['attributes']['product.stock.warehouse.label'] );
		$this->assertEquals( 'laravel2', $json['data'][1]['attributes']['product.stock.warehouse.label'] );
		$this->assertTrue( in_array( $json['data'][0]['attributes']['product.stock.warehouse.id'], $ids ) );
		$this->assertTrue( in_array( $json['data'][1]['attributes']['product.stock.warehouse.id'], $ids ) );
		$this->assertEquals( 2, $json['meta']['total'] );


		$params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse' ];
		$content = '{"data":[
			{"type":"product/stock/warehouse","id":' . $ids[0] . '},
			{"type":"product/stock/warehouse","id":' . $ids[1] . '}
		]}';
		$response = $this->action('DELETE', '\Aimeos\Shop\Controller\JsonadmController@deleteAction', $params, [], [], [], [], $content);

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 2, $json['meta']['total'] );
	}
}
