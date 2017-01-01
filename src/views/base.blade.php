@extends('app')

@section('aimeos_styles')
    <link type="text/css" rel="stylesheet" href="{{ asset('packages/aimeos/shop/themes/elegance/common.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('packages/aimeos/shop/themes/elegance/aimeos.css') }}" />
@stop

@section('aimeos_scripts')
    <script type="text/javascript" src="{{ asset('packages/aimeos/shop/themes/jquery-ui.custom.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/aimeos/shop/themes/aimeos.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/aimeos/shop/themes/elegance/aimeos.js') }}"></script>
@stop
