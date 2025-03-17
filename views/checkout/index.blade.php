@extends('shop::base')

@section('aimeos_header')
	<title>{{ __( 'Checkout') }}</title>
	<meta name="robots" content="noindex">

	<?= $aiheader['checkout/standard'] ?>
	<?= $aiheader['catalog/search'] ?? '' ?>
	<?= $aiheader['catalog/tree'] ?? '' ?>
@stop

@section('aimeos_nav')
	<?= $aibody['catalog/tree'] ?? '' ?>
	<?= $aibody['catalog/search'] ?? '' ?>
@stop

@section('aimeos_body')
	<div class="container-fluid">
		<?= $aibody['checkout/standard'] ?>
	</div>
@stop
