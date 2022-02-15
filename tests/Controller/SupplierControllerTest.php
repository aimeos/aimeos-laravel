<?php

class SupplierControllerTest extends AimeosTestAbstract
{
	public function testDetailAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$context = app( 'aimeos.context' )->get( true );
		$item = \Aimeos\Controller\Frontend::create( $context, 'supplier' )->slice( 0, 1 )->search()->first();
		$params = ['site' => 'unittest', 's_name' => 'Test supplier', 'f_supid' => $item->getId()];

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\SupplierController@detailAction', $params );

		$this->assertResponseOk();
		$this->assertStringContainsString( '<section class="aimeos supplier-detail', $response->getContent() );
		$this->assertStringContainsString( '<section class="aimeos catalog-list', $response->getContent() );
	}
}