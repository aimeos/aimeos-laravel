<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019
 * @package laravel
 * @subpackage Facades
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the supplier frontend controller
 */
class Supplier extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new supplier frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Supplier\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Aimeos\Controller\Frontend::create( app( 'aimeos.context' )->get(), 'supplier' );
	}
}
