@extends('shop::base')

@section('aimeos_header')
	<?= $aiheader['basket/mini'] ?? '' ?>
    <?= $aiheader['cms/page'] ?? '' ?>
@stop

@section('aimeos_body')
	<?= $aibody['basket/mini'] ?? '' ?>
	<?= $aibody['cms/page'] ?? '' ?>
@stop
