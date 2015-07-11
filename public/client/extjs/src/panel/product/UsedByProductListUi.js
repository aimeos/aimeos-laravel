/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel.product');

MShop.panel.product.UsedByProductListUi = Ext.extend(MShop.panel.AbstractUsedByListUi, {

    recordName : 'Product_List',
    idProperty : 'product.list.id',
    siteidProperty : 'product.list.siteid',
    itemUiXType : 'MShop.panel.product.itemui',

    autoExpandColumn : 'product-list-autoexpand-column',

    sortInfo : {
        field : 'product.list.parentid',
        direction : 'ASC'
    },

    parentIdProperty : 'product.list.parentid',
    parentDomainPorperty : 'product.list.domain',
    parentRefIdProperty : 'product.list.refid',

    initComponent : function() {
        MShop.panel.product.UsedByProductListUi.superclass.initComponent.call(this);

        this.title = MShop.I18n.dt('client/extjs', 'Used by');
    },

    getColumns : function() {
        return [
            {
                xtype : 'gridcolumn',
                dataIndex : 'product.list.id',
                header : MShop.I18n.dt('client/extjs', 'List ID'),
                sortable : true,
                width : 50,
                hidden : true
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'product.list.typeid',
                header : MShop.I18n.dt('client/extjs', 'List type'),
                sortable : true,
                width : 100,
                renderer : this.listTypeColumnRenderer.createDelegate(this, [
                    this.listTypeStore,
                    "product.list.type.label"], true)
            },
            {
                xtype : 'datecolumn',
                dataIndex : 'product.list.datestart',
                header : MShop.I18n.dt('client/extjs', 'List start date'),
                format : 'Y-m-d H:i:s',
                sortable : true,
                width : 120
            },
            {
                xtype : 'datecolumn',
                dataIndex : 'product.list.dateend',
                header : MShop.I18n.dt('client/extjs', 'List end date'),
                format : 'Y-m-d H:i:s',
                sortable : true,
                width : 120
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'product.list.position',
                header : MShop.I18n.dt('client/extjs', 'List position'),
                sortable : true,
                width : 70,
                hidden : true
            },
            {
                xtype : 'datecolumn',
                dataIndex : 'product.list.mtime',
                header : MShop.I18n.dt('client/extjs', 'List modification time'),
                format : 'Y-m-d H:i:s',
                sortable : true,
                width : 120,
                hidden : true
            },
            {
                xtype : 'datecolumn',
                dataIndex : 'product.list.ctime',
                header : MShop.I18n.dt('client/extjs', 'List creation time'),
                format : 'Y-m-d H:i:s',
                sortable : true,
                width : 120,
                hidden : true
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'product.list.editor',
                header : MShop.I18n.dt('client/extjs', 'List editor'),
                sortable : true,
                width : 120,
                hidden : true
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'product.list.parentid',
                header : MShop.I18n.dt('client/extjs', 'ID'),
                sortable : true,
                width : 100
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'product.list.parentid',
                header : MShop.I18n.dt('client/extjs', 'Status'),
                sortable : false,
                width : 50,
                renderer : this.statusColumnRenderer.createDelegate(this, [this.ParentItemUi.store, "product.status"],
                    true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'product.list.parentid',
                header : MShop.I18n.dt('client/extjs', 'Type'),
                sortable : false,
                width : 100,
                renderer : this.productTypeColumnRenderer.createDelegate(this, [
                    this.ParentItemUi.store,
                    this.productTypeStore,
                    "product.typeid",
                    "product.type.label"], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'product.list.parentid',
                header : MShop.I18n.dt('client/extjs', 'Code'),
                sortable : false,
                width : 100,
                renderer : this.listTypeColumnRenderer.createDelegate(this, [this.ParentItemUi.store, "product.code"],
                    true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'product.list.parentid',
                header : MShop.I18n.dt('client/extjs', 'Label'),
                sortable : false,
                id : 'product-list-autoexpand-column',
                renderer : MShop.panel.AbstractListUi.prototype.typeColumnRenderer.createDelegate(this, [
                    this.ParentItemUi.store,
                    "product.label"], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'product.list.parentid',
                header : MShop.I18n.dt('client/extjs', 'Supplier'),
                sortable : false,
                width : 100,
                hidden : true,
                renderer : MShop.panel.AbstractListUi.prototype.typeColumnRenderer.createDelegate(this, [
                    this.ParentItemUi.store,
                    "product.suppliercode"], true)
            },
            {
                xtype : 'datecolumn',
                dataIndex : 'product.list.parentid',
                header : MShop.I18n.dt('client/extjs', 'Start date'),
                format : 'Y-m-d H:i:s',
                sortable : false,
                width : 120,
                hidden : true,
                renderer : MShop.panel.AbstractListUi.prototype.typeColumnRenderer.createDelegate(this, [
                    this.ParentItemUi.store,
                    "product.datestart"], true)
            },
            {
                xtype : 'datecolumn',
                dataIndex : 'product.list.parentid',
                header : MShop.I18n.dt('client/extjs', 'End date'),
                format : 'Y-m-d H:i:s',
                sortable : false,
                width : 120,
                hidden : true,
                renderer : MShop.panel.AbstractListUi.prototype.typeColumnRenderer.createDelegate(this, [
                    this.ParentItemUi.store,
                    "product.dateend"], true)
            },
            {
                xtype : 'datecolumn',
                dataIndex : 'product.list.parentid',
                header : MShop.I18n.dt('client/extjs', 'Created'),
                format : 'Y-m-d H:i:s',
                sortable : false,
                width : 120,
                hidden : true,
                renderer : MShop.panel.AbstractListUi.prototype.typeColumnRenderer.createDelegate(this, [
                    this.ParentItemUi.store,
                    "product.ctime"], true)
            },
            {
                xtype : 'datecolumn',
                dataIndex : 'product.list.parentid',
                header : MShop.I18n.dt('client/extjs', 'Last modified'),
                format : 'Y-m-d H:i:s',
                sortable : false,
                width : 120,
                hidden : true,
                renderer : MShop.panel.AbstractListUi.prototype.typeColumnRenderer.createDelegate(this, [
                    this.ParentItemUi.store,
                    "product.mtime"], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'product.list.parentid',
                header : MShop.I18n.dt('client/extjs', 'Editor'),
                sortable : false,
                width : 100,
                hidden : true,
                renderer : MShop.panel.AbstractListUi.prototype.typeColumnRenderer.createDelegate(this, [
                    this.ParentItemUi.store,
                    "product.editor"], true)
            }];
    }
});

Ext.reg('MShop.panel.product.usedbyproductlistui', MShop.panel.product.UsedByProductListUi);

//hook parent product list into the product ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.product.ItemUi', 'MShop.panel.product.UsedByProductListUi',
    MShop.panel.product.UsedByProductListUi, 110);
