@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['locale/select'] ?? '' ?>
    <?= $aiheader['basket/mini'] ?? '' ?>
    <?= $aiheader['catalog/stage'] ?? '' ?>
    <?= $aiheader['catalog/filter'] ?? '' ?>
    <?= $aiheader['catalog/search'] ?? '' ?>
    <?= $aiheader['catalog/tree'] ?? '' ?>
    <?= $aiheader['catalog/price'] ?? '' ?>
    <?= $aiheader['catalog/supplier'] ?? '' ?>
    <?= $aiheader['catalog/attribute'] ?? '' ?>
    <?= $aiheader['catalog/stage'] ?? '' ?>
    <?= $aiheader['catalog/lists'] ?? '' ?>
@stop

@section('aimeos_head')
    <?= $aibody['locale/select'] ?? '' ?>
    <?= $aibody['basket/mini'] ?? '' ?>
@stop

@section('aimeos_stage')
    <?= $aibody['catalog/stage'] ?? '' ?>
@stop

@section('aimeos_nav')
    <?= $aibody['catalog/filter'] ?? '' ?>
    <?= $aibody['catalog/search'] ?? '' ?>
    <?= $aibody['catalog/tree'] ?? '' ?>
    <?= $aibody['catalog/price'] ?? '' ?>
    <?= $aibody['catalog/supplier'] ?? '' ?>
    <?= $aibody['catalog/attribute'] ?? '' ?>
@stop

@section('aimeos_body')
    <div class="container">
        <div class="row">
            <aside class="col-lg-3">
                <div class="shop-tools">
                    <?= $aibody['catalog/filter'] ?>
                </div>
                <div class="advert">
                    <?= $aibody['cms/page'] ?? '' ?>
                </div>
                <div class="shop-tools">
                    <?= $aibody['catalog/session'] ?? '' ?>
                </div>
            </aside>
            <div class="col-lg-9">
                <?= $aibody['catalog/lists'] ?>
            </div>
        </div>
    </div>
@stop
