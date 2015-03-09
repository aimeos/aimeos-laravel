<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


/**
 * Service providing the page object
 *
 * @package laravel
 * @subpackage Base
 */
class Page
{
	/**
	 * Returns the body and header sections created by the clients configured for the given page name.
	 *
	 * @param string $pageName Name of the configured page
	 * @return array Associative list with body and header output separated by client name
	 */
	public function getSections( $pageName )
	{
		$tmplPaths = app('Aimeos\Shop\Base\Aimeos')->get()->getCustomPaths( 'client/html' );
		$context = app('Aimeos\Shop\Base\Context')->get( $tmplPaths );

		$langid = $context->getLocale()->getLanguageId();
		$view = app('Aimeos\Shop\Base\View')->create( $context->getConfig(), $tmplPaths, $langid );

		$pagesConfig = \Config::get( 'shop::config.page', array() );
		$result = array( 'aibody' => array(), 'aiheader' => array() );

		if( isset( $pagesConfig[$pageName] ) )
		{
			foreach( (array) $pagesConfig[$pageName] as $clientName )
			{
				$client = \Client_Html_Factory::createClient( $context, $tmplPaths, $clientName );
				$client->setView( clone $view );
				$client->process();

				$result['aibody'][$clientName] = $client->getBody();
				$result['aiheader'][$clientName] = $client->getHeader();
			}
		}

		return $result;
	}
}