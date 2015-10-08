<?php


class ViewTest extends AimeosTestAbstract
{
	public function testCreateNoLocale()
	{
		$config = new \Aimeos\MW\Config\PHPArray();
		$object = new \Aimeos\Shop\Base\View();

		$this->assertInstanceOf( '\Aimeos\MW\View\Iface', $object->create( $config, array() ) );
	}


	public function testCreate()
	{
		$config = new \Aimeos\MW\Config\PHPArray();
		$object = new \Aimeos\Shop\Base\View();

/*		Breaks with orchestra/testbench

		\Route::shouldReceive('input')->once()->with('site')->andReturn('unittest');
		\Route::shouldReceive('input')->once()->with('locale')->andReturn('de');
		\Route::shouldReceive('input')->once()->with('currency')->andReturn('EUR');

		$routeMock = $this->getMockBuilder('\Illuminate\Routing\Route')
			->setMethods( array('parameters') )->disableOriginalConstructor()->getMock();

		$routeMock->expects( $this->once() )->method('parameters')
			->will( $this->returnValue( array() ) );

		\Route::shouldReceive('current')->once()->andReturn($routeMock);
		\Route::shouldReceive('currentRouteName')->once();
*/
		$this->assertInstanceOf('\Aimeos\MW\View\Iface', $object->create($config, array()));
	}
}
