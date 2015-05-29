@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['locale/select'] ?>
    <?= $aiheader['basket/standard'] ?>
    <?= $aiheader['basket/related'] ?>
@stop

@section('aimeos_head')
    <?= $aibody['locale/select'] ?>
@stop

@section('aimeos_body')
    <?= $aibody['basket/standard'] ?>
    <?= $aibody['basket/related'] ?>
@stop
