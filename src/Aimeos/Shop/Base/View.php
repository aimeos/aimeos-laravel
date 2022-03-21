<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


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
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;

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
	 * @param \Illuminate\Contracts\Config\Repository $config Configuration object
	 * @param \Aimeos\Shop\Base\I18n $i18n I18n object
	 * @param \Aimeos\Shop\Base\Support $support Support object
	 */
	public function __construct( \Illuminate\Contracts\Config\Repository $config,
		\Aimeos\Shop\Base\I18n $i18n, \Aimeos\Shop\Base\Support $support )
	{
		$this->i18n = $i18n;
		$this->config = $config;
		$this->support = $support;
	}


	/**
	 * Creates the view object for the HTML client.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @param array $templatePaths List of base path names with relative template paths as key/value pairs
	 * @param string|null $locale Code of the current language or null for no translation
	 * @return \Aimeos\Base\View\Iface View object
	 */
	public function create( \Aimeos\MShop\Context\Item\Iface $context, array $templatePaths,
		string $locale = null ) : \Aimeos\Base\View\Iface
	{
		$engine = new \Aimeos\Base\View\Engine\Blade( app( 'Illuminate\Contracts\View\Factory' ) );
		$view = new \Aimeos\Base\View\Standard( $templatePaths, array( '.blade.php' => $engine ) );

		$config = $context->config();
		$session = $context->session();

		$this->addCsrf( $view );
		$this->addAccess( $view, $context );
		$this->addConfig( $view, $config );
		$this->addNumber( $view, $config, $locale );
		$this->addParam( $view );
		$this->addRequest( $view );
		$this->addResponse( $view );
		$this->addSession( $view, $session );
		$this->addTranslate( $view, $locale );
		$this->addUrl( $view );

		return $view;
	}


	/**
	 * Adds the "access" helper to the view object
	 *
	 * @param \Aimeos\Base\View\Iface $view View object
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\Base\View\Iface Modified view object
	 */
	protected function addAccess( \Aimeos\Base\View\Iface $view, \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\Base\View\Iface
	{
		if( $this->config->get( 'shop.accessControl', true ) === false
			|| ( ( $user = \Illuminate\Support\Facades\Auth::user() ) !== null && $user->superuser )
		) {
			$helper = new \Aimeos\Base\View\Helper\Access\All( $view );
		}
		else
		{
			$support = $this->support;

			$fcn = function() use ( $support, $context ) {
				return $support->getGroups( $context );
			};

			$helper = new \Aimeos\Base\View\Helper\Access\Standard( $view, $fcn );
		}

		$view->addHelper( 'access', $helper );

		return $view;
	}


	/**
	 * Adds the "config" helper to the view object
	 *
	 * @param \Aimeos\Base\View\Iface $view View object
	 * @param \Aimeos\Base\Config\Iface $config Configuration object
	 * @return \Aimeos\Base\View\Iface Modified view object
	 */
	protected function addConfig( \Aimeos\Base\View\Iface $view, \Aimeos\Base\Config\Iface $config ) : \Aimeos\Base\View\Iface
	{
		$prefixes = ['version', 'admin', 'client', 'common', 'resource/fs/baseurl', 'resource/fs-media/baseurl', 'resource/fs-theme/baseurl'];
		$config = new \Aimeos\Base\Config\Decorator\Protect( clone $config, $prefixes );
		$helper = new \Aimeos\Base\View\Helper\Config\Standard( $view, $config );
		$view->addHelper( 'config', $helper );

		return $view;
	}


	/**
	 * Adds the "access" helper to the view object
	 *
	 * @param \Aimeos\Base\View\Iface $view View object
	 * @return \Aimeos\Base\View\Iface Modified view object
	 */
	protected function addCsrf( \Aimeos\Base\View\Iface $view ) : \Aimeos\Base\View\Iface
	{
		$helper = new \Aimeos\Base\View\Helper\Csrf\Standard( $view, '_token', csrf_token() );
		$view->addHelper( 'csrf', $helper );

		return $view;
	}


	/**
	 * Adds the "number" helper to the view object
	 *
	 * @param \Aimeos\Base\View\Iface $view View object
	 * @param \Aimeos\Base\Config\Iface $config Configuration object
	 * @param string|null $locale Code of the current language or null for no translation
	 * @return \Aimeos\Base\View\Iface Modified view object
	 */
	protected function addNumber( \Aimeos\Base\View\Iface $view, \Aimeos\Base\Config\Iface $config,
		string $locale = null ) : \Aimeos\Base\View\Iface
	{
		if( config( 'shop.num_formatter', 'Locale' ) === 'Locale' )
		{
			$pattern = $config->get( 'client/html/common/format/pattern' );
			$helper = new \Aimeos\Base\View\Helper\Number\Locale( $view, $locale, $pattern );
		}
		else
		{
			$sep1000 = $config->get( 'client/html/common/format/separator1000', '' );
			$decsep = $config->get( 'client/html/common/format/separatorDecimal', '.' );
			$helper = new \Aimeos\Base\View\Helper\Number\Standard( $view, $decsep, $sep1000 );
		}

		return $view->addHelper( 'number', $helper );
	}


	/**
	 * Adds the "param" helper to the view object
	 *
	 * @param \Aimeos\Base\View\Iface $view View object
	 * @return \Aimeos\Base\View\Iface Modified view object
	 */
	protected function addParam( \Aimeos\Base\View\Iface $view ) : \Aimeos\Base\View\Iface
	{
		$params = ( Route::current() ? Route::current()->parameters() : array() ) + Request::all();
		$helper = new \Aimeos\Base\View\Helper\Param\Standard( $view, $params );
		$view->addHelper( 'param', $helper );

		return $view;
	}


	/**
	 * Adds the "request" helper to the view object
	 *
	 * @param \Aimeos\Base\View\Iface $view View object
	 * @return \Aimeos\Base\View\Iface Modified view object
	 */
	protected function addRequest( \Aimeos\Base\View\Iface $view ) : \Aimeos\Base\View\Iface
	{
		$helper = new \Aimeos\Base\View\Helper\Request\Laravel( $view, Request::instance() );
		$view->addHelper( 'request', $helper );

		return $view;
	}


	/**
	 * Adds the "response" helper to the view object
	 *
	 * @param \Aimeos\Base\View\Iface $view View object
	 * @return \Aimeos\Base\View\Iface Modified view object
	 */
	protected function addResponse( \Aimeos\Base\View\Iface $view ) : \Aimeos\Base\View\Iface
	{
		$helper = new \Aimeos\Base\View\Helper\Response\Laravel( $view );
		$view->addHelper( 'response', $helper );

		return $view;
	}


	/**
	 * Adds the "session" helper to the view object
	 *
	 * @param \Aimeos\Base\View\Iface $view View object
	 * @param \Aimeos\Base\Session\Iface $session Session object
	 * @return \Aimeos\Base\View\Iface Modified view object
	 */
	protected function addSession( \Aimeos\Base\View\Iface $view, \Aimeos\Base\Session\Iface $session ) : \Aimeos\Base\View\Iface
	{
		$helper = new \Aimeos\Base\View\Helper\Session\Standard( $view, $session );
		$view->addHelper( 'session', $helper );

		return $view;
	}


	/**
	 * Adds the "translate" helper to the view object
	 *
	 * @param \Aimeos\Base\View\Iface $view View object
	 * @param string|null $locale ISO language code, e.g. "de" or "de_CH"
	 * @return \Aimeos\Base\View\Iface Modified view object
	 */
	protected function addTranslate( \Aimeos\Base\View\Iface $view, string $locale = null ) : \Aimeos\Base\View\Iface
	{
		if( $locale !== null )
		{
			$i18n = $this->i18n->get( array( $locale ) );
			$translation = $i18n[$locale];
		}
		else
		{
			$translation = new \Aimeos\Base\Translation\None( 'en' );
		}

		$helper = new \Aimeos\Base\View\Helper\Translate\Standard( $view, $translation );
		$view->addHelper( 'translate', $helper );

		return $view;
	}


	/**
	 * Adds the "url" helper to the view object
	 *
	 * @param \Aimeos\Base\View\Iface $view View object
	 * @return \Aimeos\Base\View\Iface Modified view object
	 */
	protected function addUrl( \Aimeos\Base\View\Iface $view ) : \Aimeos\Base\View\Iface
	{
		$fixed = [
			'site' => Request::input( 'site', env( 'SHOP_MULTISHOP' ) ? config( 'shop.mshop.locale.site', 'default' ) : null ),
			'locale' => Request::input( 'locale' ),
			'currency' => Request::input( 'currency' )
		];

		if( Route::current() )
		{
			$fixed['site'] = Request::route( 'site', $fixed['site'] );
			$fixed['locale'] = Request::route( 'locale', $fixed['locale'] );
			$fixed['currency'] = Request::route( 'currency', $fixed['currency'] );
		}

		$helper = new \Aimeos\Base\View\Helper\Url\Laravel( $view, app( 'url' ), array_filter( $fixed ) );
		$view->addHelper( 'url', $helper );

		return $view;
	}
}