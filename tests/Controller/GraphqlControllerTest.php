<?php

class GraphqlControllerTest extends AimeosTestAbstract
{
	public function testQuery()
	{
		$params = ['site' => 'unittest'];
		$body = '{"query":"query {\n  findProduct(code: \"CNC\") {\n    id\n    code\n  }\n}\n","variables":{},"operationName":null}';
		$response = $this->action( 'POST', '\Aimeos\Shop\Controller\GraphqlController@indexAction', $params, [], [], [], [], $body );

		$json = json_decode( $response->getContent(), true );

		$this->assertResponseOk();
		$this->assertNotNull( $json );
	}
}
