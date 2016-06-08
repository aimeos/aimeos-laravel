<?php


class ViewTest extends AimeosTestAbstract
{
	public function testCreateNoLocale()
	{
		$object = new \Aimeos\Shop\Base\View();
		$context = new \Aimeos\MShop\Context\Item\Standard();
		$context->setConfig( new \Aimeos\MW\Config\PHPArray() );

		$this->assertInstanceOf( '\Aimeos\MW\View\Iface', $object->create( $context, array() ) );
	}
}
