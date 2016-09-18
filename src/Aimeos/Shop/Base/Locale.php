<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2016
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;


/**
 * Service providing the context objects
 *
 * @package laravel
 * @subpackage Base
 */
class Locale
{
	/**
	 * @var \Aimeos\Shop\Base\Config
	 */
	private $config;

	/**
	 * @var \Aimeos\MShop\Locale\Item\Iface
	 */
	private $locale;


	/**
	 * Initializes the object
	 *
	 * @param \Aimeos\Shop\Base\Config $config Configuration object
	 */
	public function __construct( \Aimeos\Shop\Base\Config $config )
	{
		$this->config = $config;
	}


	/**
	 * Returns the locale item for the current request
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Locale\Item\Iface Locale item object
	 */
	public function get( \Aimeos\MShop\Context\Item\Iface $context )
	{
		if( $this->locale === null )
		{
			$site = Route::input( 'site', Input::get( 'site', 'default' ) );
			$currency = Route::input( 'currency', Input::get( 'currency', '' ) );
			$lang = Route::input( 'locale', Input::get( 'locale', '' ) );

			$disableSites = $this->config->get()->get( 'disableSites', true );

			$localeManager = \Aimeos\MShop\Locale\Manager\Factory::createManager( $context );
			$this->locale = $localeManager->bootstrap( $site, $lang, $currency, $disableSites );
		}

		return $this->locale;
	}
}
