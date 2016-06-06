<?php

class SupportTest extends AimeosTestAbstract
{
	public function testCheckGroup()
	{
		$context = $this->app->make( '\Aimeos\Shop\Base\Context' );
		$ctx = $context->get( false );

		$ctxMock = $this->getMockBuilder( '\Aimeos\Shop\Base\Context' )
			->disableOriginalConstructor()
			->setMethods( array( 'get' ) )
			->getMock();

		$ctxMock->expects( $this->once() )->method( 'get' )
			->will( $this->returnValue( $ctx ) );

		$object = new \Aimeos\Shop\Base\Support( $ctxMock, 'unittest' );

		$this->assertFalse( $object->checkGroup( -1, 'admin' ) );
	}
}
