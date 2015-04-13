<?php

class PageControllerTest extends Orchestra\Testbench\TestCase
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


	protected function getPackageProviders()
	{
		return ['Aimeos\Shop\ShopServiceProvider'];
	}
}