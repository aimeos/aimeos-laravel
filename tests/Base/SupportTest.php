<?php

class SupportTest extends AimeosTestAbstract
{
	public function testCheckGroup()
	{
		$this->assertFalse( $this->app->make('\Aimeos\Shop\Base\Support')->checkGroup( -1, 'admin' ) );
	}
}
