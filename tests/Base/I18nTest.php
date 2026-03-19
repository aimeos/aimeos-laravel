<?php

class I18nTest extends AimeosTestAbstract
{
	public function testGet()
	{
		$aimeos = $this->app->make( '\Aimeos\Shop\Base\Aimeos' );

		$configMock = $this->getMockBuilder( '\Illuminate\Config\Repository' )
			->onlyMethods( array( 'get', 'has' ) )->getMock();

		$configMock->expects( $this->once() )->method( 'has' )
			->willReturn( true );

		$configMock->expects( $this->exactly( 3 ) )->method( 'get' )
			->willReturnOnConsecutiveCalls( true, 'laravel:', array() );

		$object = new \Aimeos\Shop\Base\I18n( $configMock, $aimeos );
		$list = $object->get( array( 'en' ) );

		$this->assertInstanceOf( '\Aimeos\Base\Translation\Iface', $list['en'] );
	}
}
