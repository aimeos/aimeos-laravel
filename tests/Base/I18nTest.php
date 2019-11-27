<?php

class I18nTest extends AimeosTestAbstract
{
	public function testGet()
	{
		$aimeos = $this->app->make( '\Aimeos\Shop\Base\Aimeos' );

		$configMock = $this->getMockBuilder( '\Illuminate\Config\Repository' )
			->setMethods( array( 'get', 'has' ) )->getMock();

		$configMock->expects( $this->once() )->method( 'has' )
			->will( $this->returnValue( true ) );

		$configMock->expects( $this->exactly( 3 ) )->method( 'get' )
			->will( $this->onConsecutiveCalls( true, 'laravel:', array() ) );

		$object = new \Aimeos\Shop\Base\I18n( $configMock, $aimeos );
		$list = $object->get( array( 'en' ) );

		$this->assertInstanceOf( '\Aimeos\MW\Translation\Iface', $list['en'] );
	}
}
