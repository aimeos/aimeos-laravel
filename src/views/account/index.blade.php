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

@section('aimeos_head_basket')
    <?= $aibody['basket/mini'] ?? '' ?>
@stop

@section('aimeos_head_nav')
    <?= $aibody['catalog/tree'] ?? '' ?>
@stop

@section('aimeos_head_locale')
    <?= $aibody['locale/select'] ?? '' ?>
@stop

@section('aimeos_head_search')
    <?= $aibody['catalog/search'] ?? '' ?>
@stop

@section('aimeos_body')
    <?= $aibody['account/profile'] ?? '' ?>
    <?= $aibody['account/review'] ?? '' ?>
    <?= $aibody['account/subscription'] ?? '' ?>
    <?= $aibody['account/history'] ?? '' ?>
    <?= $aibody['account/favorite'] ?? '' ?>
    <?= $aibody['account/watch'] ?? '' ?>
@stop

@section('aimeos_aside')
    <?= $aibody['catalog/session'] ?>
@stop
