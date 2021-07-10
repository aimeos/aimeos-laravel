@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['locale/select'] ?? '' ?>
    <?= $aiheader['basket/mini'] ?? '' ?>
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

@section('aimeos_nav')
    <?= $aibody['catalog/tree'] ?? '' ?>
    <?= $aibody['catalog/search'] ?? '' ?>
@stop

@section('aimeos_body')
    <?= $aibody['catalog/stage'] ?? '' ?>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-lg-3">
                <div class="catalog-filter-group">
                    <?= $aibody['catalog/price'] ?? '' ?>
                    <?= $aibody['catalog/supplier'] ?? '' ?>
                    <?= $aibody['catalog/attribute'] ?? '' ?>
                </div>
                <?= $aibody['catalog/session'] ?? '' ?>
            </aside>
            <div class="col-lg-9">
                <?= $aibody['catalog/lists'] ?>
            </div>
        </div>
    </div>
@stop
