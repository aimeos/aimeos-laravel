<?php

class PageControllerTest extends AimeosTestAbstract
{
	public function testIndexAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$this->action( 'GET', '\Aimeos\Shop\Controller\PageController@indexAction', ['site' => 'unittest', 'path' => 'contact'] );
		$this->assertResponseOk();
	}


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