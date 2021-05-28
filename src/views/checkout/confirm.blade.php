@extends('shop::base')

@section('aimeos_header')
    <title>{{ __( 'Thank you') }} }}</title>
    <?= $aiheader['checkout/confirm'] ?>
@stop

@section('aimeos_body')
    <?= $aibody['checkout/confirm'] ?>
@stop
