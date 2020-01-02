<?php

class CheckoutControllerTest extends AimeosTestAbstract
{
	public function testConfirmAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\CheckoutController@confirmAction', ['site' => 'unittest'] );

		$this->assertResponseOk();
		$this->assertStringContainsString( '<section class="aimeos checkout-confirm"', $response->getContent() );
	}


	public function testIndexAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\CheckoutController@indexAction', ['site' => 'unittest'] );

		$this->assertResponseOk();
		$this->assertStringContainsString( '<section class="checkout-standard-address"', $response->getContent() );
	}


	public function testUpdateAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\CheckoutController@updateAction', ['site' => 'unittest'], ['code' => 'paypalexpress'] );

		$this->assertResponseOk();
		$this->assertEquals( '', $response->getContent() );
	}
}