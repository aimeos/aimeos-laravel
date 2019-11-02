<?php

class SetupCommandTest extends AimeosTestAbstract
{
	public function testSetupCommand()
	{
		$args = array( 'site' => 'unittest', 'tplsite' => 'unittest', '--option' => 'setup/default/demo:0' );
		$this->assertEquals( 0, $this->artisan( 'aimeos:setup', $args ) );
	}
}
