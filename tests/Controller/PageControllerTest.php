<?php

class PageControllerTest extends AimeosTestAbstract
{
	public function testIndexAction()
	{
		View::addLocation( dirname( __DIR__ ) . '/fixtures/views' );

		$this->action( 'GET', '\Aimeos\Shop\Controller\PageController@indexAction', ['site' => 'unittest', 'path' => '/'] );
		$this->assertResponseOk();
	}
}