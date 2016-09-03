@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['basket/mini'] ?>
    <?= $aiheader['account/profile'] ?>
    <?= $aiheader['account/history'] ?>
    <?= $aiheader['account/favorite'] ?>
    <?= $aiheader['account/watch'] ?>
    <?= $aiheader['catalog/session'] ?>
@stop

@section('aimeos_head')
    <?= $aibody['basket/mini'] ?>
@stop

@section('aimeos_body')
    <?= $aibody['account/profile'] ?>
    <?= $aibody['account/history'] ?>
    <?= $aibody['account/favorite'] ?>
    <?= $aibody['account/watch'] ?>
@stop

@section('aimeos_aside')
    <?= $aibody['catalog/session'] ?>
@stop
