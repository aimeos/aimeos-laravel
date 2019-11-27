<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019
 * @package laravel
 * @subpackage Facades
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the product frontend controller
 */
class Product extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new product frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Product\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Aimeos\Controller\Frontend::create( app( 'aimeos.context' )->get(), 'product' );
	}
}
