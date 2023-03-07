<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2023
 */


namespace Aimeos\Shop\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


/**
 * Command for initializing or updating the Aimeos database tables
 */
class SetupCommand extends AbstractCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'aimeos:setup
		{site? : Site for updating database entries}
		{tplsite=default : Site used as template for creating the new one}
		{--q : Quiet}
		{--v=v : Verbosity level}
		{--option= : Setup configuration, name and value are separated by colon like "setup/default/demo:1"}
	';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initialize or update the Aimeos database tables';


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		\Aimeos\MShop::cache( false );
		\Aimeos\MAdmin::cache( false );

		$template = $this->argument( 'tplsite' );

		if( ( $site = $this->argument( 'site' ) ) === null ) {
			$site = config( 'shop.mshop.locale.site', 'default' );
		}

		$boostrap = $this->getLaravel()->make( 'aimeos' )->get();
		$ctx = $this->getLaravel()->make( 'aimeos.context' )->get( false, 'command' );

		$this->info( sprintf( 'Initializing or updating the Aimeos database tables for site "%1$s"', $site ) );

		\Aimeos\Setup::use( $boostrap )
			->verbose( $this->option( 'q' ) ? '' : $this->option( 'v' ) )
			->context( $this->addConfig( $ctx->setEditor( 'aimeos:setup' ) ) )
			->up( $site, $template );
	}


	/**
	 * Adds the configuration options from the input object to the given context
	 *
	 * @param \Aimeos\MShop\ContextIface $ctx Context object
	 * @return array Associative list of key/value pairs of configuration options
	 */
	protected function addConfig( \Aimeos\MShop\ContextIface $ctx ) : \Aimeos\MShop\ContextIface
	{
		$config = $ctx->config();

		foreach( (array) $this->option( 'option' ) as $option )
		{
			list( $name, $value ) = explode( ':', $option );
			$config->set( $name, $value );
		}

		return $ctx;
	}
}
