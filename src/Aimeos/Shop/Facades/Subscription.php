<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019
 * @package laravel
 * @subpackage Facades
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the subscription frontend controller
 */
class Subscription extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new subscription frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Subscription\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Aimeos\Controller\Frontend::create( app( 'aimeos.context' )->get(), 'subscription' );
	}
}
