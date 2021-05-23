@extends('shop::base')

@section('aimeos_scripts')
    <script type="text/javascript" src="{{ asset('vendor/shop/themes/aimeos-detail.js') }}"></script>
@stop

@section('aimeos_header')
    <?= $aiheader['basket/mini'] ?? '' ?>
    <?= $aiheader['catalog/stage'] ?? '' ?>
    <?= $aiheader['catalog/detail'] ?? '' ?>
    <?= $aiheader['catalog/session'] ?? '' ?>
@stop

@section('aimeos_head')
    <?= $aibody['basket/mini'] ?? '' ?>
@stop

@section('aimeos_stage')
    <?= $aibody['catalog/stage'] ?? '' ?>
@stop

@section('aimeos_body')
    <?= $aibody['catalog/detail'] ?? '' ?>
@stop

@section('aimeos_aside')
    <?= $aibody['catalog/session'] ?? '' ?>
@stop
