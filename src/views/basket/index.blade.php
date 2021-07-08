@extends('shop::base')

@section('aimeos_header')
    <title>{{ __( 'Basket') }}</title>
    <?= $aiheader['locale/select'] ?? '' ?>
    <?= $aiheader['catalog/search'] ?? '' ?>
    <?= $aiheader['catalog/tree'] ?? '' ?>
    <?= $aiheader['basket/bulk'] ?? '' ?>
    <?= $aiheader['basket/standard'] ?? '' ?>
    <?= $aiheader['basket/related'] ?? '' ?>
@stop

@section('aimeos_head')
    <?= $aibody['locale/select'] ?? '' ?>
@stop

@section('aimeos_nav')
    <?= $aibody['catalog/tree'] ?? '' ?>
    <?= $aibody['catalog/search'] ?? '' ?>
@stop

@section('aimeos_body')
    <div class="container">
        <?= $aibody['basket/standard'] ?? '' ?>
        <?= $aibody['basket/related'] ?? '' ?>
        <?= $aibody['basket/bulk'] ?? '' ?>
    </div>
@stop
