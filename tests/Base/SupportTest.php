<?php

class SupportTest extends AimeosTestAbstract
{
	public function testCheckGroup()
	{
		$context = $this->app->make('\Aimeos\Shop\Base\Context');
		$ctx = $context->get(false);

		$localeManager = \Aimeos\MShop\Locale\Manager\Factory::createManager( $ctx );
		$ctx->setLocale( $localeManager->bootstrap( 'unittest', '', '', false ) );

		$ctxMock = $this->getMockBuilder('\Aimeos\Shop\Base\Context')
			->disableOriginalConstructor()
			->setMethods( array('get') )
			->getMock();

		$ctxMock->expects( $this->once() )->method('get')
			->will( $this->returnValue($ctx) );

		$object = new \Aimeos\Shop\Base\Support($ctxMock);

		$this->assertFalse( $object->checkGroup( -1, 'admin' ) );
	}
}
