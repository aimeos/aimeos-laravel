<?php

class ServerTest extends AimeosTestAbstract
{
	public function testTools()
	{
		if( !class_exists( \Laravel\Mcp\Server::class ) ) {
			$this->markTestSkipped( 'The optional laravel/mcp package is not installed' );
		}

		$context = new \Aimeos\MShop\Context();
		$context->setConfig( new \Aimeos\Base\Config\PHPArray( [
			'admin' => ['mcp' => ['tools' => [McpServerTool::class]]],
		] ) );

		$site = $this->createStub( \Aimeos\MShop\Locale\Item\Site\Iface::class );
		$site->method( 'getConfig' )->willReturn( [] );
		$locale = $this->createStub( \Aimeos\MShop\Locale\Item\Iface::class );
		$locale->method( 'getSiteItem' )->willReturn( $site );

		$view = new \Aimeos\Base\View\Standard();
		$view->addHelper( 'access', new \Aimeos\Base\View\Helper\Access\All( $view ) );

		$contexts = $this->createStub( \Aimeos\Shop\Base\Context::class );
		$contexts->method( 'get' )->willReturn( $context );
		$i18n = $this->createStub( \Aimeos\Shop\Base\I18n::class );
		$i18n->method( 'get' )->willReturn( [] );
		$locales = $this->createStub( \Aimeos\Shop\Base\Locale::class );
		$locales->method( 'getBackend' )->willReturn( $locale );
		$views = $this->createStub( \Aimeos\Shop\Base\View::class );
		$views->method( 'create' )->willReturn( $view );

		$this->app->instance( 'aimeos.context', $contexts );
		$this->app->instance( 'aimeos.i18n', $i18n );
		$this->app->instance( 'aimeos.locale', $locales );
		$this->app->instance( 'aimeos.view', $views );

		$server = new \Aimeos\Shop\Mcp\Server( new \Laravel\Mcp\Server\Transport\FakeTransporter() );
		$server->start();
		$tools = $server->createContext()->tools();

		$this->assertCount( 1, $tools );
		$this->assertInstanceOf( \Aimeos\Shop\Mcp\Tool::class, $tools->first() );
		$this->assertSame( 'test-server', $tools->first()->name() );
	}


	public function testRoute()
	{
		if( !class_exists( \Laravel\Mcp\Facades\Mcp::class ) ) {
			$this->markTestSkipped( 'The optional laravel/mcp package is not installed' );
		}

		$route = app( 'router' )->getRoutes()->getByName( 'aimeos_shop_mcp' );

		$this->assertNotNull( $route );
		$this->assertSame( '{site}/mcp', $route->uri() );
		$this->assertSame( ['POST'], $route->methods() );
	}


	public function testRouteWithoutSdk()
	{
		if( class_exists( \Laravel\Mcp\Facades\Mcp::class ) ) {
			$this->markTestSkipped( 'The optional laravel/mcp package is installed' );
		}

		$this->assertNull( app( 'router' )->getRoutes()->getByName( 'aimeos_shop_mcp' ) );
	}
}


class McpServerTool extends \Aimeos\Admin\Mcp\Tool
{
	protected const ACTION = 'server';
	protected const DOMAIN = 'test';


	public function description() : string
	{
		return 'Tests the server catalog.';
	}


	public function schema() : \Aimeos\Prisma\Schema\Schema
	{
		return $this->objectSchema( [] );
	}


	protected function run( array $arguments ) : array
	{
		return [];
	}
}
