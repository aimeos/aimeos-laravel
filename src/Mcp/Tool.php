<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2026
 */


namespace Aimeos\Shop\Mcp;

use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;


/**
 * Adapts one framework-neutral Aimeos tool to the Laravel MCP runtime
 */
class Tool extends \Laravel\Mcp\Server\Tool
{
	public function __construct( private \Aimeos\Admin\Mcp\Tool $tool )
	{
	}


	public function description() : string
	{
		return $this->tool->description();
	}


	public function name() : string
	{
		return $this->tool->name();
	}


	/**
	 * Executes the native Aimeos validation, authorization and tool action.
	 */
	public function handle( Request $request ) : Response|ResponseFactory
	{
		try {
			$result = $this->tool->execute( $request->all() );
		} catch( \Aimeos\Admin\Mcp\Exception $e ) {
			return Response::error( $e->getMessage() );
		}

		if( $result === [] ) {
			return Response::make( Response::text( '[]' ) )->withStructuredContent( $result );
		}

		return Response::structured( $result );
	}


	/**
	 * Returns the native JSON schema and behavior hints without translating them.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray() : array
	{
		$schema = $this->tool->schema()->toArray();
		$schema['properties'] ??= (object) [];

		return [
			'name' => $this->name(),
			'description' => $this->description(),
			'inputSchema' => $schema,
			'annotations' => $this->tool->annotations(),
		];
	}
}
