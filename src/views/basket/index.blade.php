@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['basket/standard'] ?>
    <?= $aiheader['basket/related'] ?>
@stop

@section('aimeos_body')
    <?= $aibody['basket/standard'] ?>
    <?= $aibody['basket/related'] ?>
@stop
