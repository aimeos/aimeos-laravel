<?php


class HelpersTest extends AimeosTestAbstract
{
	public function testAiconfig()
	{
		$this->assertEquals( 'notexisting', aiconfig( 'not/exists', 'notexisting' ) );
	}
}
