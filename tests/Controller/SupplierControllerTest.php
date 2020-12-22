<?php

class SupplierControllerTest extends AimeosTestAbstract
{
	public function testDetailAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$response = $this->action( 'GET', '\Aimeos\Shop\Controller\SupplierController@detailAction', ['site' => 'unittest', 's_name' => 'Test supplier', 'f_supid' => 1] );

		$this->assertResponseOk();
		$this->assertStringContainsString( '<section class="aimeos supplier-detail', $response->getContent() );
		$this->assertStringContainsString( '<section class="aimeos catalog-list', $response->getContent() );
	}
}