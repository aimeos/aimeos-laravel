<?php


class FacadesTest extends AimeosTestAbstract
{
	public function testAttribute()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Attribute::uses( [] ) );
	}


	public function testBasket()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Basket::clear() );
	}


	public function testCatalog()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Catalog::uses( [] ) );
	}


	public function testCms()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Cms::uses( [] ) );
	}


	public function testCustomer()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Customer::uses( [] ) );
	}


	public function testLocale()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Locale::uses( [] ) );
	}


	public function testOrder()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Order::uses( [] ) );
	}


	public function testProduct()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Product::uses( [] ) );
	}


	public function testService()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Service::uses( [] ) );
	}


	public function testStock()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Stock::uses( [] ) );
	}


	public function testSubscription()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Subscription::uses( [] ) );
	}


	public function testSupplier()
	{
		$this->assertInstanceOf( \Aimeos\Controller\Frontend\Iface::class, \Aimeos\Shop\Facades\Supplier::uses( [] ) );
	}
}
