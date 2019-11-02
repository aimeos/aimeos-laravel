<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019
 * @package laravel
 * @subpackage Facades
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the order frontend controller
 */
class Order extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new order frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Order\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Aimeos\Controller\Frontend::create( app( 'aimeos.context' )->get(), 'order' );
	}
}
