<?php

class AccountControllerTest extends AimeosTestAbstract
{
	public function setUp()
	{
		parent::setUp();
		View::addLocation(dirname(__DIR__).'/fixtures/views');
	}


	public function testActions()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\AccountController@indexAction', ['site' => 'unittest']);

		$this->assertResponseOk();
		$this->assertContains('<section class="aimeos account-profile"', $response->getContent());
		$this->assertContains('<section class="aimeos account-history"', $response->getContent());
		$this->assertContains('<section class="aimeos account-favorite"', $response->getContent());
		$this->assertContains('<section class="aimeos account-watch"', $response->getContent());
	}


	public function testDownload()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\AccountController@downloadAction', ['site' => 'unittest', 'dl_id' => 0]);

		$this->assertEquals( 401, $response->getStatusCode() );
	}
}