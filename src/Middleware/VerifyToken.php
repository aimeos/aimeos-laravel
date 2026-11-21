<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2026
 */


namespace Aimeos\Shop\Middleware;


/**
 * Requires a valid CSRF token for modifying requests
 *
 * Laravel 13+ accepts same-origin requests without CSRF token but same-origin
 * requests can be sent by HTML content too, e.g. by forms or <a ping="...">.
 */
class VerifyToken extends \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken
{
	/**
	 * The XSRF cookie is already added by the CSRF middleware of the "web" group
	 *
	 * @var bool
	 */
	protected $addHttpCookie = false;


	/**
	 * Never accept requests by their origin alone
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return bool
	 */
	protected function hasValidOrigin( $request )
	{
		return false;
	}
}
