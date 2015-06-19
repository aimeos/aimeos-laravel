<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


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
	 * @param \MW_Config_Interface $config Configuration object
	 * @param array $templatePaths List of base path names with relative template paths as key/value pairs
	 * @param string|null $locale Code of the current language or null for no translation
	 * @return \MW_View_Interface View object
	 */
	public function create( \MW_Config_Interface $config, array $templatePaths, $locale = null )
	{
		$params = $fixed = array();

		if( $locale !== null )
		{
			$params = \Route::current()->parameters() + \Input::all();
			$params['target'] = \Route::currentRouteName();

			$fixed = $this->getFixedParams();

			$i18n = app('\Aimeos\Shop\Base\I18n')->get( array( $locale ) );
			$translation = $i18n[$locale];
		}
		else
		{
			$translation = new \MW_Translation_None( 'en' );
		}


		$view = new \MW_View_Default();

		$helper = new \MW_View_Helper_Translate_Default( $view, $translation );
		$view->addHelper( 'translate', $helper );

		$helper = new \MW_View_Helper_Url_Laravel5( $view, app('url'), $fixed );
		$view->addHelper( 'url', $helper );

		$helper = new \MW_View_Helper_Partial_Default( $view, $config, $templatePaths );
		$view->addHelper( 'partial', $helper );

		$helper = new \MW_View_Helper_Parameter_Default( $view, $params );
		$view->addHelper( 'param', $helper );

		$helper = new \MW_View_Helper_Config_Default( $view, $config );
		$view->addHelper( 'config', $helper );

		$sepDec = $config->get( 'client/html/common/format/seperatorDecimal', '.' );
		$sep1000 = $config->get( 'client/html/common/format/seperator1000', ' ' );
		$helper = new \MW_View_Helper_Number_Default( $view, $sepDec, $sep1000 );
		$view->addHelper( 'number', $helper );

		$helper = new \MW_View_Helper_FormParam_Default( $view, array() );
		$view->addHelper( 'formparam', $helper );

		$helper = new \MW_View_Helper_Encoder_Default( $view );
		$view->addHelper( 'encoder', $helper );

		$helper = new \MW_View_Helper_Csrf_Default( $view, '_token', csrf_token() );
		$view->addHelper( 'csrf', $helper );

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

		if( ( $value = \Route::input( 'site' ) ) !== null ) {
			$fixed['site'] = $value;
		}

		if( ( $value = \Route::input( 'locale' ) ) !== null ) {
			$fixed['locale'] = $value;
		}

		if( ( $value = \Route::input( 'currency' ) ) !== null ) {
			$fixed['currency'] = $value;
		}

		return $fixed;
	}
}