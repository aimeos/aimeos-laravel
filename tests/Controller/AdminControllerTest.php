<?php

class AdminControllerTest extends AimeosTestAbstract
{
	public function testIndexAction()
	{
		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\AdminController@indexAction' );

		$this->assertEquals( '302', $response->getStatusCode() );
	}
}