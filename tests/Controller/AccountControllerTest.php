<?php

class AccountControllerTest extends TestCase
{
	public function testActions()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\AccountController@indexAction');
		$this->assertResponseOk();
	}
}