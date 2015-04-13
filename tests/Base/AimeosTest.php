<?php

class AimeosTest extends Orchestra\Testbench\TestCase
{
	public function testGet()
	{
		$object = $this->app->make('\Aimeos\Shop\Base\Aimeos')->get();
		$this->assertInstanceOf( '\Arcavias', $object );
	}


	protected function getPackageProviders()
	{
		return ['Aimeos\Shop\ShopServiceProvider'];
	}
}
