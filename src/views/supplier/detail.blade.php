@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['basket/mini'] ?? '' ?>
    <?= $aiheader['supplier/detail'] ?? '' ?>
    <?= $aiheader['catalog/lists'] ?? '' ?>
@stop

@section('aimeos_head')
    <?= $aibody['basket/mini'] ?? '' ?>
@stop

@section('aimeos_body')
    <?= $aibody['supplier/detail'] ?? '' ?>
    <?= $aibody['catalog/lists'] ?? '' ?>
@stop
