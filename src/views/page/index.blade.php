@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['cms/page'] ?? '' ?>
@stop

@section('aimeos_body')
	<?= $aibody['cms/page'] ?? '' ?>
@stop
