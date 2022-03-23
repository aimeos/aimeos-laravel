<?php


class ViewTest extends AimeosTestAbstract
{
	public function testCreateNoLocale()
	{
		$config = $this->getMockBuilder( '\Illuminate\Config\Repository' )->getMock();

		$i18n = $this->getMockBuilder( '\Aimeos\Shop\Base\I18n' )
			->disableOriginalConstructor()
			->getMock();

		$support = $this->getMockBuilder( '\Aimeos\Shop\Base\Support' )
			->disableOriginalConstructor()
			->getMock();

		$context = new \Aimeos\MShop\Context();
		$context->setConfig( new \Aimeos\Base\Config\PHPArray() );
		$context->setSession( new \Aimeos\Base\Session\None() );

		$object = new \Aimeos\Shop\Base\View( $config, $i18n, $support );

		$this->assertInstanceOf( '\Aimeos\Base\View\Iface', $object->create( $context, array() ) );
	}
}
