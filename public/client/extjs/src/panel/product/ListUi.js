/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */

Ext.ns('MShop.panel.product');

MShop.panel.product.ListUi = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Product',
    idProperty : 'product.id',
    siteidProperty : 'product.siteid',
    itemUiXType : 'MShop.panel.product.itemui',
    exportMethod : 'Product_Export_Text.createJob',
    importMethod : 'Product_Import_Text.uploadFile',

    autoExpandColumn : 'product-list-label',

    filterConfig : {
        filters : [{
            dataIndex : 'product.label',
            operator : '=~',
            value : ''
        }]
    },

    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Product');

        MShop.panel.AbstractListUi.prototype.initActions.call(this);
        MShop.panel.AbstractListUi.prototype.initToolbar.call(this);

        MShop.panel.product.ListUi.superclass.initComponent.call(this);
    },

    getColumns : function() {
        // make sure product type store gets loaded in same batch as this grid data
        this.typeStore = MShop.GlobalStoreMgr.get('Product_Type');

        return [{
            xtype : 'gridcolumn',
            dataIndex : 'product.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            width : 50,
            editable : false,
            hidden : false
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'product.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 50,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'product.typeid',
            header : MShop.I18n.dt('client/extjs', 'Type'),
            width : 100,
            renderer : this.typeColumnRenderer.createDelegate(this, [this.typeStore, "product.type.label"], true)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'product.code',
            header : MShop.I18n.dt('client/extjs', 'Code'),
            sortable : true,
            width : 100,
            editable : false
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'product.label',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            sortable : true,
            width : 100,
            editable : false,
            id : 'product-list-label'
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'product.suppliercode',
            header : MShop.I18n.dt('client/extjs', 'Supplier'),
            sortable : true,
            width : 100,
            editable : false
        }, {
            xtype : 'datecolumn',
            dataIndex : 'product.datestart',
            header : MShop.I18n.dt('client/extjs', 'Start date'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false
        }, {
            xtype : 'datecolumn',
            dataIndex : 'product.dateend',
            header : MShop.I18n.dt('client/extjs', 'End date'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false
        }, {
            xtype : 'datecolumn',
            dataIndex : 'product.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'product.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'product.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 130,
            editable : false,
            hidden : true
        }];
    }
});

Ext.reg('MShop.panel.product.listui', MShop.panel.product.ListUi);

// hook this into the main tab panel
Ext.ux.ItemRegistry.registerItem('MShop.MainTabPanel', 'MShop.panel.product.listui', MShop.panel.product.ListUi, 20);
