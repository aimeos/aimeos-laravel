<?php

class SetupCommandTest extends AimeosTestAbstract
{
	public function testSetupCommandRollback()
	{
		$args = array('site' => 'unittest', 'tplsite' => 'unittest', '--task' => 'TablesCreateMShop', '--action' => 'rollback');
		$this->assertEquals(0, $this->artisan('aimeos:setup', $args));
	}


	public function testSetupCommandClean()
	{
		$args = array('site' => 'unittest', 'tplsite' => 'unittest', '--task' => 'TablesCreateMShop', '--action' => 'clean');
		$this->assertEquals(0, $this->artisan('aimeos:setup', $args));
	}


	public function testSetupCommand()
	{
		$args = array('site' => 'unittest', 'tplsite' => 'unittest', '--option' => 'setup/default/demo:0');
		$this->assertEquals(0, $this->artisan('aimeos:setup', $args));
	}
}
