<?php

class CheckoutControllerTest extends TestCase
{
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