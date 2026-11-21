<?php

class VerifyTokenTest extends AimeosTestAbstract
{
	public function testHandleSameOriginWithoutToken()
	{
		$request = $this->request( ['Sec-Fetch-Site' => 'same-origin'] );

		$this->expectException( \Illuminate\Session\TokenMismatchException::class );
		$this->object()->handle( $request, fn() => response( 'ok' ) );
	}


	public function testHandleWithToken()
	{
		$request = $this->request( ['Sec-Fetch-Site' => 'same-origin'] );
		$request->headers->set( 'X-CSRF-TOKEN', $request->session()->token() );

		$response = $this->object()->handle( $request, fn() => response( 'ok' ) );

		$this->assertEquals( 'ok', $response->getContent() );
	}


	public function testHandleGet()
	{
		$request = $this->request( ['Sec-Fetch-Site' => 'same-origin'], 'GET' );

		$response = $this->object()->handle( $request, fn() => response( 'ok' ) );

		$this->assertEquals( 'ok', $response->getContent() );
	}


	public function testRoutes()
	{
		foreach( ['aimeos_shop_jqadm_save', 'aimeos_shop_jqadm_delete', 'aimeos_shop_graphql_post'] as $name ) {
			$this->assertContains( \Aimeos\Shop\Middleware\VerifyToken::class, Route::getRoutes()->getByName( $name )->middleware(), $name );
		}
	}


	protected function object() : \Aimeos\Shop\Middleware\VerifyToken
	{
		return new class( $this->app, $this->app['encrypter'] ) extends \Aimeos\Shop\Middleware\VerifyToken {
			protected function runningUnitTests()
			{
				return false;
			}
		};
	}


	protected function request( array $headers, string $method = 'POST' ) : \Illuminate\Http\Request
	{
		$request = \Illuminate\Http\Request::create( '/unittest/jqadm/save/customer', $method, ['item' => ['customer.password' => 'x']] );
		$request->setLaravelSession( $this->app['session']->driver( 'array' ) );
		$request->session()->regenerateToken();
		$request->headers->add( $headers );

		return $request;
	}
}
