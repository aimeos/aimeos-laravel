<?php

class AdminControllerTest extends AimeosTestAbstract
{
	public function setUp()
	{
		parent::setUp();
		require dirname(dirname(__DIR__)).'/src/routes_admin.php';
	}


	public function testIndexAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\AdminController@indexAction');
		$this->assertResponseOk();
	}


	public function testDoAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\AdminController@doAction');
		$this->assertResponseOk();
	}
}