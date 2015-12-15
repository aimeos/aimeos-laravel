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
/*		$params = ['site' => 'unittest', 'resource' => 'product', 'id' => '1'];
		$response = $this->action('GET', '\Aimeos\Shop\Controller\JqadmController@copyAction', $params);

		$this->assertNotNull( $response->getContent() );
		$this->assertEquals( 200, $response->getStatusCode() );
*/	}
}
