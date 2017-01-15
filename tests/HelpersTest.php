<?php


class HelpersTest extends AimeosTestAbstract
{
	public function testAiconfig()
	{
		$this->assertEquals( 'notexisting', aiconfig( 'not/exists', 'notexisting' ) );
	}


	public function testAitrans()
	{
		$this->assertEquals( '1 not exists', aitrans( '%1$d not exists', array( 1 ) ) );
	}


	public function testAitransplural()
	{
		$this->assertEquals( '2 not exist', aitransplural( '%1$d not exists', '%1$d not exist', 2, array( 2 ) ) );
	}
}
