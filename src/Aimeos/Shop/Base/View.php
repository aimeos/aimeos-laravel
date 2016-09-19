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
	 * @var \Aimeos\Shop\Base\I18n
	 */
	private $i18n;

	/**
	 * @var \Aimeos\Shop\Base\Support
	 */
	private $support;


	/**
	 * Initializes the object
	 *
	 * @param \Aimeos\Shop\Base\I18n $i18n I18n object
	 * @param \Aimeos\Shop\Base\Support $support Support object
	 */
	public function __construct( \Aimeos\Shop\Base\I18n $i18n, \Aimeos\Shop\Base\Support $support )
	{
		$this->i18n = $i18n;
		$this->support = $support;
	}


	/**
	 * Creates the view object for the HTML client.
	 *
	 * @param \Aimeos\MW\Config\Iface $config Configuration object
	 * @param array $templatePaths List of base path names with relative template paths as key/value pairs
	 * @param string|null $locale Code of the current language or null for no translation
	 * @return \Aimeos\MW\View\Iface View object
	 */
	public function create( \Aimeos\MW\Config\Iface $config, array $templatePaths, $locale = null )
	{
		$view = new \Aimeos\MW\View\Standard( $templatePaths );

		$this->addConfig( $view, $config );
		$this->addNumber( $view, $config );
		$this->addRequest( $view );
		$this->addResponse( $view );
		$this->addParam( $view );
		$this->addUrl( $view );
		$this->addCsrf( $view );
		$this->addAccess( $view );
		$this->addTranslate( $view, $config, $locale );

		return $view;
	}


	/**
	 * Adds the "access" helper to the view object
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @return \Aimeos\MW\View\Iface Modified view object
	 */
	protected function addAccess( \Aimeos\MW\View\Iface $view )
	{
		$support = $this->support;

		$fcn = function() use ( $support ) {
			return $support->getGroups();
		};

		$helper = new \Aimeos\MW\View\Helper\Access\Standard( $view, $fcn );
		$view->addHelper( 'access', $helper );

		return $view;
	}


	/**
	 * Adds the "config" helper to the view object
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @param \Aimeos\MW\Config\Iface $config Configuration object
	 * @return \Aimeos\MW\View\Iface Modified view object
	 */
	protected function addConfig( \Aimeos\MW\View\Iface $view, \Aimeos\MW\Config\Iface $config )
	{
		$config = new \Aimeos\MW\Config\Decorator\Protect( clone $config, array( 'admin', 'client' ) );
		$helper = new \Aimeos\MW\View\Helper\Config\Standard( $view, $config );
		$view->addHelper( 'config', $helper );

		return $view;
	}


	/**
	 * Adds the "access" helper to the view object
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @return \Aimeos\MW\View\Iface Modified view object
	 */
	protected function addCsrf( \Aimeos\MW\View\Iface $view )
	{
		$helper = new \Aimeos\MW\View\Helper\Csrf\Standard( $view, '_token', csrf_token() );
		$view->addHelper( 'csrf', $helper );

		return $view;
	}


	/**
	 * Adds the "number" helper to the view object
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @param \Aimeos\MW\Config\Iface $config Configuration object
	 * @return \Aimeos\MW\View\Iface Modified view object
	 */
	protected function addNumber( \Aimeos\MW\View\Iface $view, \Aimeos\MW\Config\Iface $config )
	{
		$sepDec = $config->get( 'client/html/common/format/seperatorDecimal', '.' );
		$sep1000 = $config->get( 'client/html/common/format/seperator1000', ' ' );
		$decimals = $config->get( 'client/html/common/format/decimals', 2 );

		$helper = new \Aimeos\MW\View\Helper\Number\Standard( $view, $sepDec, $sep1000, $decimals );
		$view->addHelper( 'number', $helper );

		return $view;
	}


	/**
	 * Adds the "param" helper to the view object
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @return \Aimeos\MW\View\Iface Modified view object
	 */
	protected static function addParam( \Aimeos\MW\View\Iface $view )
	{
		$params = ( Route::current() ? Route::current()->parameters() + Input::all() : array() );
		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $view, $params );
		$view->addHelper( 'param', $helper );

		return $view;
	}


	/**
	 * Adds the "request" helper to the view object
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @return \Aimeos\MW\View\Iface Modified view object
	 */
	protected static function addRequest( \Aimeos\MW\View\Iface $view )
	{
		$helper = new \Aimeos\MW\View\Helper\Request\Laravel5( $view, Request::instance() );
		$view->addHelper( 'request', $helper );

		return $view;
	}


	/**
	 * Adds the "response" helper to the view object
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @return \Aimeos\MW\View\Iface Modified view object
	 */
	protected static function addResponse( \Aimeos\MW\View\Iface $view )
	{
		$helper = new \Aimeos\MW\View\Helper\Response\Laravel5( $view );
		$view->addHelper( 'response', $helper );

		return $view;
	}


	/**
	 * Adds the "url" helper to the view object
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @return \Aimeos\MW\View\Iface Modified view object
	 */
	protected function addUrl( \Aimeos\MW\View\Iface $view )
	{
		$fixed = array();

		if( Route::current() )
		{
			if( ( $value = Route::input( 'site' ) ) !== null ) {
				$fixed['site'] = $value;
			}

			if( ( $value = Route::input( 'locale' ) ) !== null ) {
				$fixed['locale'] = $value;
			}

			if( ( $value = Route::input( 'currency' ) ) !== null ) {
				$fixed['currency'] = $value;
			}
		}

		$helper = new \Aimeos\MW\View\Helper\Url\Laravel5( $view, app('url'), $fixed );
		$view->addHelper( 'url', $helper );

		return $view;
	}


	/**
	 * Adds the "translate" helper to the view object
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @param \Aimeos\MW\Config\Iface $config Configuration object
	 * @param string|null $locale ISO language code, e.g. "de" or "de_CH"
	 * @return \Aimeos\MW\View\Iface Modified view object
	 */
	protected function addTranslate( \Aimeos\MW\View\Iface $view, \Aimeos\MW\Config\Iface $config, $locale )
	{
		if( $locale !== null )
		{
			$i18n = $this->i18n->get( array( $locale ), $config->get( 'i18n', array() ) );
			$translation = $i18n[$locale];
		}
		else
		{
			$translation = new \Aimeos\MW\Translation\None( 'en' );
		}

		$helper = new \Aimeos\MW\View\Helper\Translate\Standard( $view, $translation );
		$view->addHelper( 'translate', $helper );

		return $view;
	}
}