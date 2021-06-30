@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['basket/mini'] ?? '' ?>
    <?= $aiheader['catalog/filter'] ?? '' ?>
    <?= $aiheader['catalog/search'] ?? '' ?>
    <?= $aiheader['catalog/tree'] ?? '' ?>
    <?= $aiheader['catalog/price'] ?? '' ?>
    <?= $aiheader['catalog/supplier'] ?? '' ?>
    <?= $aiheader['catalog/attribute'] ?? '' ?>
    <?= $aiheader['catalog/home'] ?? '' ?>
    <?= $aiheader['cms/page'] ?? '' ?>
@stop

@section('aimeos_head')
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

@section('aimeos_body')
    <?= $aibody['catalog/home'] ?? '' ?>
    <?= $aibody['cms/page'] ?? '' ?>
@stop
