<?php

class AccountControllerTest extends AimeosTestAbstract
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
		$response = $this->action('GET', '\Aimeos\Shop\Controller\AccountController@indexAction', ['site' => 'unittest']);

		$this->assertResponseOk();
		$this->assertContains('<section class="aimeos account-history">', $response->getContent());
		$this->assertContains('<section class="aimeos account-favorite">', $response->getContent());
		$this->assertContains('<section class="aimeos account-watch">', $response->getContent());
	}
}