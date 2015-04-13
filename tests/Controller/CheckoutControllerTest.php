<?php

class CheckoutControllerTest extends AimeosTestAbstract
{
	public function setUp()
	{
		parent::setUp();
		View::addLocation(dirname(__DIR__).'/fixtures/views');

		require dirname(dirname(__DIR__)).'/src/routes.php';
		require dirname(dirname(__DIR__)).'/src/routes_account.php';
	}


	public function testConfirmAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CheckoutController@confirmAction');
		$this->assertResponseOk();
	}


	public function testIndexAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CheckoutController@indexAction');
		$this->assertResponseOk();
	}


	public function testUpdateAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\CheckoutController@updateAction');
		$this->assertResponseOk();
	}
}