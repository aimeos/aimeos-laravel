<?php

class SupportTest extends AimeosTestAbstract
{
	public function testCheckGroup()
	{
		$object = new \Aimeos\Shop\Base\Support();

		$this->assertFalse( $object->checkGroup( -1, 'admin', 'unittest' ) );
	}
}
