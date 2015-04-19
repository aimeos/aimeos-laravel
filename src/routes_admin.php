<?php

Route::match( array( 'GET', 'POST' ), 'admin/do', array(
	'as' => 'aimeos_shop_admin_json',
	'uses' => '\Aimeos\Shop\Controller\AdminController@doAction'
));
Route::match( array( 'GET', 'POST' ), 'admin/{site?}/{lang?}/{tab?}', array(
	'as' => 'aimeos_shop_admin',
	'uses' => '\Aimeos\Shop\Controller\AdminController@indexAction'
));
