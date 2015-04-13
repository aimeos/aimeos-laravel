<?php

class BasketControllerTest extends AimeosTestAbstract
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


	public function testActions()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\BasketController@indexAction', ['site' => 'unittest']);

		$this->assertResponseOk();
		$this->assertContains('<section class="aimeos basket-standard">', $response->getContent());
		$this->assertContains('<section class="aimeos basket-related">', $response->getContent());
	}
}