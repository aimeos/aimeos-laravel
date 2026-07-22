<?php

class ToolTest extends AimeosTestAbstract
{
	public function testDefinition()
	{
		if( !class_exists( \Laravel\Mcp\Server\Tool::class ) ) {
			$this->markTestSkipped( 'The optional laravel/mcp package is not installed' );
		}

		$tool = $this->createTool();
		$adapter = new \Aimeos\Shop\Mcp\Tool( $tool );
		$definition = $adapter->toArray();

		$this->assertSame( 'test-echo', $definition['name'] );
		$this->assertSame( 'Returns the supplied message.', $definition['description'] );
		$this->assertSame( $tool->schema()->toArray(), $definition['inputSchema'] );
		$this->assertSame( $tool->annotations(), $definition['annotations'] );
	}


	public function testHandle()
	{
		if( !class_exists( \Laravel\Mcp\Server\Tool::class ) ) {
			$this->markTestSkipped( 'The optional laravel/mcp package is not installed' );
		}

		$adapter = new \Aimeos\Shop\Mcp\Tool( $this->createTool() );
		$response = $adapter->handle( new \Laravel\Mcp\Request( ['message' => 'Hello'] ) );

		$this->assertInstanceOf( \Laravel\Mcp\ResponseFactory::class, $response );
		$this->assertSame( ['message' => 'Hello'], $response->getStructuredContent() );
		$this->assertFalse( $response->responses()->first()->isError() );
	}


	public function testInvalidArguments()
	{
		if( !class_exists( \Laravel\Mcp\Server\Tool::class ) ) {
			$this->markTestSkipped( 'The optional laravel/mcp package is not installed' );
		}

		$adapter = new \Aimeos\Shop\Mcp\Tool( $this->createTool() );
		$response = $adapter->handle( new \Laravel\Mcp\Request() );

		$this->assertInstanceOf( \Laravel\Mcp\Response::class, $response );
		$this->assertTrue( $response->isError() );
		$this->assertStringContainsString( 'Invalid arguments', (string) $response->content() );
	}


	public function testEmptyResult()
	{
		if( !class_exists( \Laravel\Mcp\Server\Tool::class ) ) {
			$this->markTestSkipped( 'The optional laravel/mcp package is not installed' );
		}

		$adapter = new \Aimeos\Shop\Mcp\Tool( $this->createTool() );
		$response = $adapter->handle( new \Laravel\Mcp\Request( ['message' => ''] ) );

		$this->assertInstanceOf( \Laravel\Mcp\ResponseFactory::class, $response );
		$this->assertSame( [], $response->getStructuredContent() );
		$this->assertSame( '[]', (string) $response->responses()->first()->content() );
	}


	protected function createTool() : \Aimeos\Admin\Mcp\Tool
	{
		$context = new \Aimeos\MShop\Context();
		$context->setConfig( new \Aimeos\Base\Config\PHPArray() );

		$view = new \Aimeos\Base\View\Standard();
		$view->addHelper( 'access', new \Aimeos\Base\View\Helper\Access\All( $view ) );
		$context->setView( $view );

		return new McpEchoTool( $context );
	}
}


class McpEchoTool extends \Aimeos\Admin\Mcp\Tool
{
	protected const ACTION = 'echo';
	protected const DOMAIN = 'test';


	public function description() : string
	{
		return 'Returns the supplied message.';
	}


	public function schema() : \Aimeos\Prisma\Schema\Schema
	{
		return $this->objectSchema( [
			'message' => \Aimeos\Prisma\Schema\Schema::string()->required(),
		] );
	}


	protected function run( array $arguments ) : array
	{
		if( $arguments['message'] === '' ) {
			return [];
		}

		return ['message' => $arguments['message']];
	}
}
