<?php

class BasketControllerTest extends AimeosTestAbstract
{
	public function testActions()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\BasketController@indexAction', ['site' => 'unittest'] );

		$this->assertResponseOk();
		$this->assertStringContainsString( '<section class="aimeos basket-standard"', $response->getContent() );
		$this->assertStringContainsString( '<section class="aimeos basket-related"', $response->getContent() );
	}
}