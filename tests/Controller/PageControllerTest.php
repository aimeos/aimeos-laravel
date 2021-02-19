<?php

class PageControllerTest extends AimeosTestAbstract
{
	public function testPrivacyAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$this->action( 'GET', '\Aimeos\Shop\Controller\PageController@privacyAction', ['site' => 'unittest'] );
		$this->assertResponseOk();
	}


	public function testTermsAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$this->action( 'GET', '\Aimeos\Shop\Controller\PageController@termsAction', ['site' => 'unittest'] );
		$this->assertResponseOk();
	}
}