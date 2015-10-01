<?php

class AimeosTest extends AimeosTestAbstract
{
	public function testGet()
	{
		$object = $this->app->make('\Aimeos\Shop\Base\Aimeos')->get();
		$this->assertInstanceOf( '\Aimeos', $object );
	}
}
