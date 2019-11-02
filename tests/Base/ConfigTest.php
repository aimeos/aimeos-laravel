<?php

class ConfigTest extends AimeosTestAbstract
{
	public function testGet()
	{
		$aimeos = $this->app->make( '\Aimeos\Shop\Base\Aimeos' );

		$configMock = $this->getMockBuilder( '\Illuminate\Config\Repository' )
			->setMethods( array( 'get' ) )->getMock();

		$configMock->expects( $this->exactly( 4 ) )->method( 'get' )
			->will( $this->onConsecutiveCalls( true, 'laravel:', array(), array() ) );

		$object = new \Aimeos\Shop\Base\Config( $configMock, $aimeos );

		$this->assertInstanceOf( '\Aimeos\MW\Config\Iface', $object->get() );
	}
}
