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
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;

	/**
	 * @var \Aimeos\MShop\Locale\Item\Iface
	 */
	private $locale;


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Contracts\Config\Repository $config Configuration object
	 */
	public function __construct( \Illuminate\Contracts\Config\Repository $config )
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
			$site = Input::get( 'site', 'default' );
			$currency = Input::get( 'currency', '' );
			$lang = Input::get( 'locale', '' );

			if( Route::current() )
			{
				$site =  Route::input( 'site', $site );
				$currency = Route::input( 'currency', $currency );
				$lang = Route::input( 'locale', $lang );
			}

			$disableSites = $this->config->get( 'shop.disableSites', true );

			$localeManager = \Aimeos\MShop::create( $context, 'locale' );
			$this->locale = $localeManager->bootstrap( $site, $lang, $currency, $disableSites );
		}

		return $this->locale;
	}


	/**
	 * Returns the locale item for the current request
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @param string $site Unique site code
	 * @return \Aimeos\MShop\Locale\Item\Iface Locale item object
	 */
	public function getBackend( \Aimeos\MShop\Context\Item\Iface $context, $site )
	{
		$localeManager = \Aimeos\MShop::create( $context, 'locale' );

		try {
			$localeItem = $localeManager->bootstrap( $site, '', '', false, null, true );
		} catch( \Aimeos\MShop\Exception $e ) {
			$localeItem = $localeManager->createItem();
		}

		return $localeItem;
	}
}
