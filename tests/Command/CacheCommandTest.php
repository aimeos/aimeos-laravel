<?php

class CacheCommandTest extends TestCase
{
	public function testSetupCommand()
	{
		$this->assertEquals(0, $this->artisan('aimeos:cache', array('--site' => 'unittest')));
	}
}
