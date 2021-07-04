@extends('shop::base')

@section('aimeos_header')
    <title>{{ __( 'Checkout') }}</title>
    <?= $aiheader['checkout/standard'] ?>
@stop

@section('aimeos_body')
    <div class="container">
        <?= $aibody['checkout/standard'] ?>
    </div>
@stop
