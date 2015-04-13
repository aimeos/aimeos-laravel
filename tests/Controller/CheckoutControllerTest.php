<?php

class CheckoutControllerTest extends AimeosTestAbstract
{
	public function setUp()
	{
		parent::setUp();
		View::addLocation(dirname(__DIR__).'/fixtures/views');

		Route::group(['prefix' => '{site}'], function() {
			require dirname(dirname(__DIR__)).'/src/routes.php';
			require dirname(dirname(__DIR__)).'/src/routes_account.php';
		});
	}


	public function testConfirmAction()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\CheckoutController@confirmAction', ['site' => 'unittest']);

		$this->assertResponseOk();
		$this->assertContains('<section class="aimeos checkout-confirm">', $response->getContent());
	}


	public function testIndexAction()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\CheckoutController@indexAction', ['site' => 'unittest']);

		$this->assertResponseOk();
		$this->assertContains('<section class="checkout-standard-address">', $response->getContent());
	}


	public function testUpdateAction()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\CheckoutController@updateAction', ['site' => 'unittest']);

		$this->assertResponseOk();
		$this->assertEquals('', $response->getContent());
	}
}