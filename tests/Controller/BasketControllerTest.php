<?php

class BasketControllerTest extends TestCase
{
	public function testActions()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\BasketController@indexAction');
		$this->assertResponseOk();
	}
}