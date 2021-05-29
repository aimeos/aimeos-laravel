@extends('shop::base')

@section('aimeos_header')
    <title>{{ __( 'Basket') }}</title>
    <?= $aiheader['basket/bulk'] ?? '' ?>
    <?= $aiheader['basket/standard'] ?? '' ?>
    <?= $aiheader['basket/related'] ?? '' ?>
@stop

@section('aimeos_body')
    <?= $aibody['basket/bulk'] ?? '' ?>
    <?= $aibody['basket/standard'] ?? '' ?>
    <?= $aibody['basket/related'] ?? '' ?>
@stop
