@extends('shop::base')

@section('aimeos_header')
    <title>{{ __( 'Profile') }}</title>
    <?= $aiheader['locale/select'] ?? '' ?>
    <?= $aiheader['basket/mini'] ?? '' ?>
    <?= $aiheader['account/profile'] ?? '' ?>
    <?= $aiheader['account/review'] ?? '' ?>
    <?= $aiheader['account/subscription'] ?? '' ?>
    <?= $aiheader['account/history'] ?? '' ?>
    <?= $aiheader['account/favorite'] ?? '' ?>
    <?= $aiheader['account/watch'] ?? '' ?>
    <?= $aiheader['catalog/search'] ?? '' ?>
    <?= $aiheader['catalog/session'] ?? '' ?>
    <?= $aiheader['catalog/tree'] ?? '' ?>
@stop

@section('aimeos_head')
    <?= $aibody['locale/select'] ?? '' ?>
    <?= $aibody['basket/mini'] ?? '' ?>
@stop

@section('aimeos_nav')
    <?= $aibody['catalog/tree'] ?? '' ?>
    <?= $aibody['catalog/search'] ?? '' ?>
@stop

@section('aimeos_body')
    <div class="container">
        <?= $aibody['account/profile'] ?? '' ?>
        <?= $aibody['account/review'] ?? '' ?>
        <?= $aibody['account/subscription'] ?? '' ?>
        <?= $aibody['account/history'] ?? '' ?>
        <?= $aibody['account/favorite'] ?? '' ?>
        <?= $aibody['account/watch'] ?? '' ?>
    </div>
@stop

@section('aimeos_aside')
    <?= $aibody['catalog/session'] ?>
@stop
