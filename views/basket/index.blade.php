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

@section('aimeos_head_nav')
    <?= $aibody['catalog/tree'] ?? '' ?>
@stop

@section('aimeos_head_locale')
    <?= $aibody['locale/select'] ?? '' ?>
@stop

@section('aimeos_head_search')
    <?= $aibody['catalog/search'] ?? '' ?>
@stop

@section('aimeos_body')
    <div class="container-fluid">
        <?= $aibody['basket/standard'] ?? '' ?>
        <?= $aibody['basket/related'] ?? '' ?>
        <?= $aibody['basket/bulk'] ?? '' ?>
    </div>
@stop
