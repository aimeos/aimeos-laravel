<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2023
 */

namespace Aimeos\Shop\Base;


/**
 * Service providing the shop object
 */
class Shop
{
	/**
	 * @var \Aimeos\MShop\ContextIface
	 */
	private $context;

	/**
	 * @var \Aimeos\Base\View\Iface
	 */
	private $view;

	/**
	 * @var array
	 */
	private $objects = [];


	/**
	 * Initializes the object
	 *
	 * @param \Aimeos\Shop\Base\Aimeos $aimeos Aimeos object
	 * @param \Aimeos\Shop\Base\Context $context Context object
	 * @param \Aimeos\Shop\Base\View $view View object
	 */
	public function __construct( \Aimeos\Shop\Base\Aimeos $aimeos,
		\Aimeos\Shop\Base\Context $context, \Aimeos\Shop\Base\View $view )
	{
		$this->context = $context->get();
		$locale = $this->context->locale();

		$tmplPaths = $aimeos->get()->getTemplatePaths( 'client/html/templates', $locale->getSiteItem()->getTheme() );
		$langid = $locale->getLanguageId();

		$this->view = $view->create( $this->context, $tmplPaths, $langid );
		$this->context->setView( $this->view );
	}


	/**
	 * Returns the HTML client for the given name
	 *
	 * @param string $name Name of the shop component
	 * @return \Aimeos\Client\Html\Iface HTML client
	 */
	public function get( string $name ) : \Aimeos\Client\Html\Iface
	{
		if( !isset( $this->objects[$name] ) )
		{
			$client = \Aimeos\Client\Html::create( $this->context, $name );
			$client->setView( clone $this->view );
			$client->init();

			$this->objects[$name] = $client;
		}

		return $this->objects[$name];
	}


	/** Returns the view template for the given name
	 *
	 * @param string $name View name, e.g. "account.index"
	 * @return string Template name, e.g. "shop::account.indx"
	 */
	public function template( string $name ) : string
	{
		$theme = $this->context->locale()->getSiteItem()->getTheme();
		return \Illuminate\Support\Facades\View::exists( $theme . '::' . $name ) ? $theme . '::' . $name : 'shop::' . $name;
	}


	/**
	 * Returns the used view object
	 *
	 * @return \Aimeos\Base\View\Iface View object
	 */
	public function view() : \Aimeos\Base\View\Iface
	{
		return $this->view;
	}
}
