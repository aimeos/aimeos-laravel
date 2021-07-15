@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['locale/select'] ?? '' ?>
    <?= $aiheader['basket/mini'] ?? '' ?>
    <?= $aiheader['catalog/tree'] ?? '' ?>
    <?= $aiheader['catalog/search'] ?? '' ?>
    <?= $aiheader['supplier/detail'] ?? '' ?>
    <?= $aiheader['catalog/lists'] ?? '' ?>
@stop

@section('aimeos_nav')
    <?= $aibody['catalog/tree'] ?? '' ?>
    <?= $aibody['catalog/search'] ?? '' ?>
@stop

@section('aimeos_head')
    <?= $aibody['locale/select'] ?? '' ?>
    <?= $aibody['basket/mini'] ?? '' ?>
@stop

@section('aimeos_body')
    <?= $aibody['supplier/detail'] ?? '' ?>
    <?= $aibody['catalog/lists'] ?? '' ?>
@stop
