<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


/**
 * Service providing the view objects
 *
 * @package laravel
 * @subpackage Base
 */
class View
{
	/**
	 * Creates the view object for the HTML client.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @param array $templatePaths List of base path names with relative template paths as key/value pairs
	 * @param string|null $locale Code of the current language or null for no translation
	 * @return \Aimeos\MW\View\Iface View object
	 */
	public function create( \Aimeos\MShop\Context\Item\Iface $context, array $templatePaths, $locale = null )
	{
		$params = $fixed = array();

		if( $locale !== null )
		{
			$params = Route::current()->parameters() + Input::all();
			$fixed = $this->getFixedParams();

			$i18n = app('\Aimeos\Shop\Base\I18n')->get( array( $locale ) );
			$translation = $i18n[$locale];
		}
		else
		{
			$translation = new \Aimeos\MW\Translation\None( 'en' );
		}


		$view = new \Aimeos\MW\View\Standard( $templatePaths );

		$helper = new \Aimeos\MW\View\Helper\Translate\Standard( $view, $translation );
		$view->addHelper( 'translate', $helper );

		$helper = new \Aimeos\MW\View\Helper\Url\Laravel5( $view, app('url'), $fixed );
		$view->addHelper( 'url', $helper );

		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $view, $params );
		$view->addHelper( 'param', $helper );

		$config = new \Aimeos\MW\Config\Decorator\Protect( clone $context->getConfig(), array( 'admin', 'client' ) );
		$helper = new \Aimeos\MW\View\Helper\Config\Standard( $view, $config );
		$view->addHelper( 'config', $helper );

		$sepDec = $config->get( 'client/html/common/format/seperatorDecimal', '.' );
		$sep1000 = $config->get( 'client/html/common/format/seperator1000', ' ' );
		$decimals = $config->get( 'client/html/common/format/decimals', 2 );
		$helper = new \Aimeos\MW\View\Helper\Number\Standard( $view, $sepDec, $sep1000, $decimals );
		$view->addHelper( 'number', $helper );

		$helper = new \Aimeos\MW\View\Helper\Request\Laravel5( $view, Request::instance() );
		$view->addHelper( 'request', $helper );

		$helper = new \Aimeos\MW\View\Helper\Response\Laravel5( $view );
		$view->addHelper( 'response', $helper );

		$helper = new \Aimeos\MW\View\Helper\Csrf\Standard( $view, '_token', csrf_token() );
		$view->addHelper( 'csrf', $helper );

		$helper = new \Aimeos\MW\View\Helper\Access\Standard( $view, $this->getGroups( $context ) );
		$view->addHelper( 'access', $helper );

		return $view;
	}


	/**
	 * Returns the routing parameters passed in the URL
	 *
	 * @return array Associative list of parameters with "site", "locale" and "currency" if available
	 */
	protected function getFixedParams()
	{
		$fixed = array();

		if( ( $value = Route::input( 'site' ) ) !== null ) {
			$fixed['site'] = $value;
		}

		if( ( $value = Route::input( 'locale' ) ) !== null ) {
			$fixed['locale'] = $value;
		}

		if( ( $value = Route::input( 'currency' ) ) !== null ) {
			$fixed['currency'] = $value;
		}

		return $fixed;
	}


	/**
	 * Returns the closure for retrieving the user groups
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Closure Function which returns the user group codes
	 */
	protected function getGroups( \Aimeos\MShop\Context\Item\Iface $context )
	{
		return function() use ( $context )
		{
			$list = array();
			$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer/group' );

			$search = $manager->createSearch();
			$search->setConditions( $search->compare( '==', 'customer.group.id', $context->getGroupIds() ) );

			foreach( $manager->searchItems( $search ) as $item ) {
				$list[] = $item->getCode();
			}

			return $list;
		};
	}
}