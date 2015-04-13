<?php

class BasketControllerTest extends AimeosTestAbstract
{
	public function setUp()
	{
		parent::setUp();
		View::addLocation(dirname(__DIR__).'/fixtures/views');

		require dirname(dirname(__DIR__)).'/src/routes.php';
		require dirname(dirname(__DIR__)).'/src/routes_account.php';
	}


	public function testActions()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\BasketController@indexAction');
		$this->assertResponseOk();
	}
}