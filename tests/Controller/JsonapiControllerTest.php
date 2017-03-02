<?php

class JsonapiControllerTest extends AimeosTestAbstract
{
	public function setUp()
	{
		parent::setUp();
		View::addLocation(dirname(__DIR__).'/fixtures/views');
	}


	public function testOptionsAction()
	{
		$params = ['site' => 'unittest'];
		$response = $this->action('OPTIONS', '\Aimeos\Shop\Controller\JsonapiController@optionsAction', $params);

		$json = json_decode( $response->getContent(), true );

		$this->assertNotNull( $json );
		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertArrayHasKey( 'resources', $json['meta'] );
		$this->assertGreaterThan( 1, count( $json['meta']['resources'] ) );
	}


	public function testGetAction()
	{
		$params = ['site' => 'unittest', 'resource' => 'product'];
		$getParams = ['filter' => ['f_search' => 'Cafe Noire Cap', 'f_listtype' => 'unittype19']];
		$response = $this->action('GET', '\Aimeos\Shop\Controller\JsonapiController@getAction', $params, $getParams);

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 1, $json['meta']['total'] );
		$this->assertEquals( 1, count( $json['data'] ) );
		$this->assertArrayHasKey( 'id', $json['data'][0] );
		$this->assertEquals( 'CNC', $json['data'][0]['attributes']['product.code'] );

		$id = $json['data'][0]['id'];


		$params = ['site' => 'unittest', 'resource' => 'product', 'id' => $id ];
		$response = $this->action('GET', '\Aimeos\Shop\Controller\JsonapiController@getAction', $params);

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
		$this->assertEquals( 1, $json['meta']['total'] );
		$this->assertArrayHasKey( 'id', $json['data'] );
		$this->assertEquals( 'CNC', $json['data']['attributes']['product.code'] );
	}
}
