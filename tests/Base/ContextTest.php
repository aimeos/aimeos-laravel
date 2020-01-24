<?php

class ContextTest extends AimeosTestAbstract
{
	public function testGetNoLocale()
	{
		$session = $this->getMockBuilder( '\Illuminate\Session\Store' )->disableOriginalConstructor()->getMock();
		$config = $this->app->make( '\Aimeos\Shop\Base\Config' );
		$locale = $this->app->make( '\Aimeos\Shop\Base\Locale' );
		$i18n = $this->app->make( '\Aimeos\Shop\Base\I18n' );

		$object = new \Aimeos\Shop\Base\Context( $session, $config, $locale, $i18n );
		$ctx = $object->get( false );

		$this->assertInstanceOf( '\Aimeos\MShop\Context\Item\Iface', $ctx );
		$this->assertIsArray( $ctx->getGroupIds() );
	}
}
