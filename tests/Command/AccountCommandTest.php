<?php

class AccountCommandTest extends AimeosTestAbstract
{
	public function testAccountCommandNew()
	{
		$args = array( 'site' => 'unittest', 'email' => 'unitCustomer@example.com', '--password' => 'test' );
		$this->assertEquals( 0, $this->artisan( 'aimeos:account', $args ) );
	}


	public function testAccountCommandAdmin()
	{
		$args = array( 'site' => 'unittest', 'email' => 'unitCustomer@example.com', '--password' => 'test', '--admin' => true );
		$this->assertEquals( 0, $this->artisan( 'aimeos:account', $args ) );
	}


	public function testAccountCommandApi()
	{
		$args = array( 'site' => 'unittest', 'email' => 'unitCustomer@example.com', '--password' => 'test', '--api' => true );
		$this->assertEquals( 0, $this->artisan( 'aimeos:account', $args ) );
	}


	public function testAccountCommandEditor()
	{
		$args = array( 'site' => 'unittest', 'email' => 'unitCustomer@example.com', '--password' => 'test', '--editor' => true );
		$this->assertEquals( 0, $this->artisan( 'aimeos:account', $args ) );
	}
}
