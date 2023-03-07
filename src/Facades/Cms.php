<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019-2023
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the CMS frontend controller
 */
class Cms extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new CMS frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Product\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Aimeos\Controller\Frontend::create( app( 'aimeos.context' )->get(), 'cms' );
	}
}
