<?php

class JobsCommandTest extends AimeosTestAbstract
{
	public function testJobsCommand()
	{
		$this->assertEquals( 0, $this->artisan( 'aimeos:jobs', array( 'jobs' => 'customer/email/watch', 'site' => 'unittest' ) ) );
	}
}
