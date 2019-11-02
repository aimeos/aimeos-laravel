<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019
 * @package laravel
 * @subpackage Facades
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the customer frontend controller
 */
class Customer extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new customer frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Customer\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Aimeos\Controller\Frontend::create( app( 'aimeos.context' )->get(), 'customer' );
	}
}
