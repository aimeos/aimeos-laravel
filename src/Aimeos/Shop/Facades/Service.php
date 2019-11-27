<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019
 * @package laravel
 * @subpackage Facades
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the service frontend controller
 */
class Service extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new service frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Service\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Aimeos\Controller\Frontend::create( app( 'aimeos.context' )->get(), 'service' );
	}
}
