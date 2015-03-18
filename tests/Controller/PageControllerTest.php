<?php

class PageControllerTest extends TestCase
{
	public function testPrivacyAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\PageController@privacyAction');
		$this->assertResponseOk();
	}


	public function testTermsAction()
	{
		$this->action('GET', '\Aimeos\Shop\Controller\PageController@termsAction');
		$this->assertResponseOk();
	}
}