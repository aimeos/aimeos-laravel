@extends('shop::base')

@section('aimeos_scripts')
    <script type="text/javascript" src="{{ asset('vendor/shop/themes/aimeos-detail.js') }}"></script>
@stop

@section('aimeos_header')
    <?= $aiheader['locale/select'] ?? '' ?>
    <?= $aiheader['basket/mini'] ?? '' ?>
    <?= $aiheader['catalog/stage'] ?? '' ?>
    <?= $aiheader['catalog/detail'] ?? '' ?>
    <?= $aiheader['catalog/session'] ?? '' ?>
@stop

@section('aimeos_head')
    <?= $aibody['locale/select'] ?? '' ?>
    <?= $aibody['basket/mini'] ?? '' ?>
@stop

@section('aimeos_nav')
    <?= $aibody['catalog/filter'] ?? '' ?>
    <?= $aibody['catalog/search'] ?? '' ?>
    <?= $aibody['catalog/tree'] ?? '' ?>
    <?= $aibody['catalog/price'] ?? '' ?>
    <?= $aibody['catalog/supplier'] ?? '' ?>
    <?= $aibody['catalog/attribute'] ?? '' ?>
@stop

@section('aimeos_stage')
    <?= $aibody['catalog/stage'] ?? '' ?>
@stop

@section('aimeos_body')
    <div class="container">
        <?= $aibody['catalog/detail'] ?? '' ?>
    </div>
@stop

@section('aimeos_aside')
    <?= $aibody['catalog/session'] ?? '' ?>
@stop
