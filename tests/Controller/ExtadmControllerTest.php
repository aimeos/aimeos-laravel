<?php

class ExtadmControllerTest extends AimeosTestAbstract
{
	public function testIndexAction()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\ExtadmController@indexAction', ['site' => 'unittest']);

		$this->assertResponseOk();
		$this->assertRegexp('#<script type="text/javascript">.*window.MShop = {#smu', $response->getContent());
	}


	public function testDoAction()
	{
		$response = $this->action('POST', '\Aimeos\Shop\Controller\ExtadmController@doAction', ['site' => 'unittest']);

		$this->assertResponseOk();
		$this->assertRegexp('#{.*}#smu', $response->getContent());
	}


	public function testFileAction()
	{
		$response = $this->action('GET', '\Aimeos\Shop\Controller\ExtadmController@fileAction', ['site' => 'unittest']);

		$this->assertResponseOk();
		$this->assertContains('EXTUTIL', $response->getContent());
	}
}