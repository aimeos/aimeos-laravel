<?php

class SetupCommandTest extends AimeosTestAbstract
{
	public function testSetupCommand()
	{
		$this->assertEquals(0, $this->artisan('aimeos:setup', array('site' => 'unittest')));
	}
}
