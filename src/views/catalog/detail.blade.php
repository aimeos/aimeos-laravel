@extends('shop::base')

@section('aimeos_scripts')
    <script src="{{ asset('vendor/shop/themes/default/aimeos-detail.js') }}"></script>
@stop

@section('aimeos_header')
    <?= $aiheader['locale/select'] ?? '' ?>
    <?= $aiheader['basket/mini'] ?? '' ?>
    <?= $aiheader['catalog/tree'] ?? '' ?>
    <?= $aiheader['catalog/search'] ?? '' ?>
    <?= $aiheader['catalog/stage'] ?? '' ?>
    <?= $aiheader['catalog/detail'] ?? '' ?>
    <?= $aiheader['catalog/session'] ?? '' ?>
@stop

@section('aimeos_head')
    <?= $aibody['locale/select'] ?? '' ?>
    <?= $aibody['basket/mini'] ?? '' ?>
@stop

@section('aimeos_nav')
    <?= $aibody['catalog/tree'] ?? '' ?>
    <?= $aibody['catalog/search'] ?? '' ?>
@stop

@section('aimeos_stage')
    <?= $aibody['catalog/stage'] ?? '' ?>
@stop

@section('aimeos_body')
    <div class="container-xl">
        <?= $aibody['catalog/detail'] ?? '' ?>
    </div>
@stop

@section('aimeos_aside')
    <?= $aibody['catalog/session'] ?? '' ?>
@stop
