@extends('shop::base')

@section('aimeos_header')
    <title>{{ __( 'Thank you') }}</title>
    <?= $aiheader['checkout/confirm'] ?>
    <?= $aiheader['catalog/search'] ?? '' ?>
    <?= $aiheader['catalog/tree'] ?? '' ?>
@stop

@section('aimeos_nav')
    <?= $aibody['catalog/tree'] ?? '' ?>
    <?= $aibody['catalog/search'] ?? '' ?>
@stop

@section('aimeos_body')
    <div class="container">
        <?= $aibody['checkout/confirm'] ?>
    </div>
@stop
