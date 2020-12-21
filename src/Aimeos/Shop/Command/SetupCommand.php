<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Command
 */


namespace Aimeos\Shop\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


/**
 * Command for initializing or updating the Aimeos database tables
 * @package laravel
 * @subpackage Command
 */
class SetupCommand extends AbstractCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'aimeos:setup
		{site=default : Site for updating database entries}
		{tplsite=default : Site used as template for creating the new one}
		{--task= : Name of the setup task that should be executed}
		{--option= : Setup configuration, name and value are separated by ":" like "setup/default/demo:1"}
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
		$ctx = $this->getLaravel()->make( 'aimeos.context' )->get( false, 'command' );
		$ctx->setEditor( 'aimeos:setup' );

		$config = $ctx->getConfig();
		$site = $this->argument( 'site' );
		$template = $this->argument( 'tplsite' );

		$task = $this->option( 'task' );

		$config->set( 'setup/site', $site );
		$dbconfig = $this->getDbConfig( $config );
		$this->setOptions( $config );

		\Aimeos\MShop::cache( false );
		\Aimeos\MAdmin::cache( false );

		$taskPaths = $this->getLaravel()->make( 'aimeos' )->get()->getSetupPaths( $template );
		$manager = new \Aimeos\MW\Setup\Manager\Multiple( $ctx->getDatabaseManager(), $dbconfig, $taskPaths, $ctx );

		$this->info( sprintf( 'Initializing or updating the Aimeos database tables for site "%1$s"', $site ) );

		$manager->migrate( $task );
	}


	/**
	 * Returns the database configuration from the config object.
	 *
	 * @param \Aimeos\MW\Config\Iface $conf Config object
	 * @return array Multi-dimensional associative list of database configuration parameters
	 */
	protected function getDbConfig( \Aimeos\MW\Config\Iface $conf ) : array
	{
		$dbconfig = $conf->get( 'resource', array() );

		foreach( $dbconfig as $rname => $dbconf )
		{
			if( strncmp( $rname, 'db', 2 ) !== 0 ) {
				unset( $dbconfig[$rname] );
			} else {
				$conf->set( 'resource/' . $rname . '/limit', 5 );
			}
		}

		return $dbconfig;
	}


	/**
	 * Extracts the configuration options from the input object and updates the configuration values in the config object.
	 *
	 * @param \Aimeos\MW\Config\Iface $conf Configuration object
	 * @param array Associative list of database configurations
	 * @throws \RuntimeException If the format of the options is invalid
	 */
	protected function setOptions( \Aimeos\MW\Config\Iface $conf )
	{
		foreach( (array) $this->option( 'option' ) as $option )
		{
			list( $name, $value ) = explode( ':', $option );
			$conf->set( str_replace( '\\', '/', $name ), $value );
		}
	}
}
