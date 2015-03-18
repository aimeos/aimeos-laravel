<?php

class SetupCommandTest extends TestCase
{
	public function testSetupCommand()
	{
		$this->assertEquals(0, $this->artisan('aimeos:setup', array('site' => 'unittest')));
	}
}
