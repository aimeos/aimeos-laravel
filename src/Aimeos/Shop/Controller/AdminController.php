<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2014-2016
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * Controller providing the ExtJS administration interface
 *
 * @package laravel
 * @subpackage Controller
 */
class AdminController extends Controller
{
	use AuthorizesRequests;


	/**
	 * Returns the initial HTML view for the admin interface.
	 *
	 * @param \Illuminate\Http\Request $request Laravel request object
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function indexAction( Request $request )
	{
		if( config( 'shop.authorize', true ) && ( Auth::check() === false
			|| $request->user()->can( 'admin', ['admin', 'editor'] ) ) === false
		) {
			return View::make( 'shop::admin.index' );
		}

		$param = array(
			'resource' => 'product',
			'site' => Route::input( 'site', 'default' ),
			'lang' => Input::get( 'lang', config( 'app.locale', 'en' ) ),
		);

		return redirect()->route( 'aimeos_shop_jqadm_search', $param );
	}
}