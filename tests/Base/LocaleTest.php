<?php

class LocaleTest extends AimeosTestAbstract
{
	public function testGetBackend()
	{
		$mock = $this->getMockBuilder( '\Illuminate\Config\Repository' )->getMock();
		$context = $this->app->make( '\Aimeos\Shop\Base\Context' )->get( false, 'backend' );

		$object = new \Aimeos\Shop\Base\Locale( $mock );

		$this->assertInstanceOf( '\Aimeos\MShop\Locale\Item\Iface', $object->getBackend( $context, 'unittest' ) );
	}
}
