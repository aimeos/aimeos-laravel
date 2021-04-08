<?php

class ClearCommandTest extends AimeosTestAbstract
{
	public function testSetupCommand()
	{
		$this->assertEquals( 0, $this->artisan( 'aimeos:clear' ) );
	}
}
