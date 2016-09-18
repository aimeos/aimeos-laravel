<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
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
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;

	/**
	 * @var \Aimeos\Shop\Base\Aimeos
	 */
	private $aimeos;

	/**
	 * @var \Aimeos\Shop\Base\Context
	 */
	private $context;

	/**
	 * @var \Aimeos\Shop\Base\View
	 */
	private $view;


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Contracts\Config\Repository $config Configuration object
	 * @param \Aimeos\Shop\Base\Aimeos $aimeos Aimeos object
	 * @param \Aimeos\Shop\Base\Context $context Context object
	 * @param \Aimeos\Shop\Base\Locale $locale Locale object
	 * @param \Aimeos\Shop\Base\View $view View object
	 */
	public function __construct( \Illuminate\Contracts\Config\Repository $config,
		\Aimeos\Shop\Base\Aimeos $aimeos, \Aimeos\Shop\Base\Context $context,
		\Aimeos\Shop\Base\Locale $locale, \Aimeos\Shop\Base\View $view )
	{
		$this->config = $config;
		$this->aimeos = $aimeos;
		$this->context = $context;
		$this->locale = $locale;
		$this->view = $view;
	}


	/**
	 * Returns the body and header sections created by the clients configured for the given page name.
	 *
	 * @param string $pageName Name of the configured page
	 * @return array Associative list with body and header output separated by client name
	 */
	public function getSections( $pageName )
	{
		$context = $this->context->get();
		$langid = $context->getLocale()->getLanguageId();
		$tmplPaths = $this->aimeos->get()->getCustomPaths( 'client/html/templates' );
		$view = $this->view->create( $context, $tmplPaths, $langid );
		$context->setView( $view );

		$pagesConfig = $this->config->get( 'shop.page', array() );
		$result = array( 'aibody' => array(), 'aiheader' => array() );

		if( isset( $pagesConfig[$pageName] ) )
		{
			foreach( (array) $pagesConfig[$pageName] as $clientName )
			{
				$client = \Aimeos\Client\Html\Factory::createClient( $context, $tmplPaths, $clientName );
				$client->setView( clone $view );
				$client->process();

				$result['aibody'][$clientName] = $client->getBody();
				$result['aiheader'][$clientName] = $client->getHeader();
			}
		}

		return $result;
	}
}