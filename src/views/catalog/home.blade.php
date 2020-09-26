@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['basket/mini'] ?>
    <?= $aiheader['catalog/home'] ?>
@stop

@section('aimeos_head')
    <?= $aibody['basket/mini'] ?>
@stop

@section('aimeos_body')
     <?= $aibody['catalog/home'] ?>
@stop
