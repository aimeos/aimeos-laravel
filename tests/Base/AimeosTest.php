<?php

class AimeosTest extends TestCase
{
	public function testGet()
	{
		$object = $this->app->make('\Aimeos\Shop\Base\Aimeos')->get();
		$this->assertInstanceOf( '\Arcavias', $object );
	}
}
