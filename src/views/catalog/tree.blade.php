@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['basket/mini'] ?>
    <?= $aiheader['catalog/filter'] ?>
    <?= $aiheader['catalog/lists'] ?>
@stop

@section('aimeos_head')
    <?= $aibody['basket/mini'] ?>
@stop

@section('aimeos_nav')
    <?= $aibody['catalog/filter'] ?>
@stop

@section('aimeos_body')
     <?= $aibody['catalog/lists'] ?>
@stop
