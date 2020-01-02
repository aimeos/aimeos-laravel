<?php

class SupportTest extends AimeosTestAbstract
{
	public function testCheckUserGroup()
	{
		$context = $this->app->make( '\Aimeos\Shop\Base\Context' );
		$locale = $this->app->make( '\Aimeos\Shop\Base\Locale' );

		$object = new \Aimeos\Shop\Base\Support( $context, $locale );
		$user = new \Illuminate\Foundation\Auth\User();
		$user->siteid = '0';

		$this->assertFalse( $object->checkUserGroup( $user, 'admin' ) );
	}


	public function testGetGroups()
	{
		$context = $this->app->make( '\Aimeos\Shop\Base\Context' );
		$locale = $this->app->make( '\Aimeos\Shop\Base\Locale' );

		$ctx = $context->get( false );
		$ctx->setLocale( $locale->getBackend( $ctx, 'unittest' ) );

		$object = new \Aimeos\Shop\Base\Support( $context, $locale );

		$this->assertEquals( array(), $object->getGroups( $ctx ) );
	}
}
