@extends('shop::base')

@section('aimeos_header')
	<?= $aiheader['basket/mini'] ?? '' ?>
    <?= $aiheader['cms/page'] ?? '' ?>
@stop

@section('aimeos_head')
	<?= $aibody['basket/mini'] ?? '' ?>
@stop

@section('aimeos_body')
	<?= $aibody['cms/page'] ?? '' ?>
@stop
