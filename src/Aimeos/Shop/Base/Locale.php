<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2016
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


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
	private $locale = null;


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
	public function get( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Locale\Item\Iface
	{
		if( null !== $this->locale ) {
			return $this->locale;
		}

		if(app()->runningInConsole()) {
			$site = 'default';
		} else {
			$site = request()->getHost();
		}

		$language = app()->getLocale();
		$currency = '';// TODO

		$localeManager = \Aimeos\MShop::create( $context, 'locale' );
		$disableSites = $this->config->get( 'shop.disableSites', true );

		return ($this->locale = $localeManager->bootstrap( $site, $language, $currency, $disableSites ));
	}


	/**
	 * Returns the locale item for the stated domain
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @param string $site Unique site code
	 * @return \Aimeos\MShop\Locale\Item\Iface Locale item object
	 */
	public function getBackend( \Aimeos\MShop\Context\Item\Iface $context, string $site ) : \Aimeos\MShop\Locale\Item\Iface
	{
		$localeManager = \Aimeos\MShop::create( $context, 'locale' );

		try {
			$localeItem = $localeManager->bootstrap( $site, '', '', false, null, true );
		} catch( \Aimeos\MShop\Exception $e ) {
			$localeItem = $localeManager->create();
		}

		return $localeItem->setCurrencyId( null )->setLanguageId( null );
	}
}
