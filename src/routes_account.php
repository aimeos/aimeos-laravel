<?php

Route::match( array( 'GET', 'POST' ), 'myaccount', array(
	'as' => 'aimeos_shop_account',
	'uses' => '\Aimeos\Shop\Controller\AccountController@indexAction'
));
Route::match( array( 'GET', 'POST' ), 'myaccount/favorite/{fav_action?}/{fav_id?}/{d_prodid?}/{d_name?}/{l_pos?}', array(
	'as' => 'aimeos_shop_account_favorite',
	'uses' => '\Aimeos\Shop\Controller\AccountController@indexAction'
));
Route::match( array( 'GET', 'POST' ), 'myaccount/watch/{wat_action?}/{wat_id?}/{d_prodid?}/{d_name?}/{l_pos?}', array(
	'as' => 'aimeos_shop_account_watch',
	'uses' => '\Aimeos\Shop\Controller\AccountController@indexAction'
));
