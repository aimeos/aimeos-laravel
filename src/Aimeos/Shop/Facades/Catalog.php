<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019
 * @package laravel
 * @subpackage Facades
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the catalog frontend controller
 */
class Catalog extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new catalog frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Catalog\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Aimeos\Controller\Frontend::create( app( 'aimeos.context' )->get(), 'catalog' );
	}
}
