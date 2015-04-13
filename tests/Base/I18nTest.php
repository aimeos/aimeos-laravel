<?php

class I18nTest extends Orchestra\Testbench\TestCase
{
	public function testGet()
	{
		$aimeos = $this->app->make('\Aimeos\Shop\Base\Aimeos');

		$configMock = $this->getMockBuilder('\Illuminate\Config\Repository')
			->setMethods( array('get', 'has') )->getMock();

		$configMock->expects( $this->once() )->method('has')
			->will( $this->returnValue(true) );

		if( function_exists('apc_store') ) {
			$configMock->expects( $this->exactly(3) )->method('get')
				->will( $this->onConsecutiveCalls( true, 'laravel:', array() ) );
		} else {
			$configMock->expects( $this->once() )->method('get')
				->will( $this->returnValue( array() ) );
		}

		$object = new \Aimeos\Shop\Base\I18n($aimeos, $configMock);
		$list = $object->get( array('en') );

		$this->assertInstanceOf( '\MW_Translation_Interface', $list['en'] );
	}


	protected function getPackageProviders()
	{
		return ['Aimeos\Shop\ShopServiceProvider'];
	}
}
