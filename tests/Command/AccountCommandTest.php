<?php

class AccountCommandTest extends AimeosTestAbstract
{
	public function testAccountCommandAdmin()
	{
		$args = array('site' => 'unittest', 'email' => 'unitCustomer@example.com', '--password' => 'test');
		$this->assertEquals(0, $this->artisan('aimeos:account', $args));
	}


	public function testAccountCommandNew()
	{
		$args = array('site' => 'unittest', 'email' => 'unitCustomer@example.com', '--password' => 'test', '--admin' => true);
		$this->assertEquals(0, $this->artisan('aimeos:account', $args));
	}
}
