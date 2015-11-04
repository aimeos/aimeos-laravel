<?php

class SetupCommandTest extends AimeosTestAbstract
{
	public function testSetupCommand()
	{
		$params = array('--option' => 'setup/default/demo:0');
		$this->assertEquals(0, $this->artisan('aimeos:setup', array('site' => 'unittest', 'template' => 'unittest'), $params));
	}
}
