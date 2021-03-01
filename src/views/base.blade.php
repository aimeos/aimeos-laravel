@extends('app')

@section('aimeos_styles')
	<link type="text/css" rel="stylesheet" href="{{ asset(config( 'shop.client.html.common.template.baseurl', 'packages/aimeos/shop/themes/elegance' ) . '/aimeos.css') }}" />
@stop

@section('aimeos_scripts')
	<script type="text/javascript" src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
	<script type="text/javascript" src="{{ asset('packages/aimeos/shop/themes/aimeos.js') }}"></script>
@stop
