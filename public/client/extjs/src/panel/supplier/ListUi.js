/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel.supplier');

MShop.panel.supplier.ListUi = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Supplier',
    idProperty : 'supplier.id',
    siteidProperty : 'supplier.siteid',
    itemUiXType : 'MShop.panel.supplier.itemui',

    autoExpandColumn : 'supplier-list-label',

    filterConfig : {
        filters : [{
            dataIndex : 'supplier.label',
            operator : '=~',
            value : ''
        }]
    },

    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Supplier');

        MShop.panel.AbstractListUi.prototype.initActions.call(this);
        MShop.panel.AbstractListUi.prototype.initToolbar.call(this);

        MShop.panel.supplier.ListUi.superclass.initComponent.call(this);
    },

    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'supplier.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            width : 50,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'supplier.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 70,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'supplier.label',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            sortable : true,
            width : 100,
            editable : false,
            id : 'supplier-list-label'
        }, {
            xtype : 'datecolumn',
            dataIndex : 'supplier.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'supplier.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'supplier.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 130,
            hidden : true
        }];
    }

});

Ext.reg('MShop.panel.supplier.listui', MShop.panel.supplier.ListUi);

// hook this into the main tab panel
Ext.ux.ItemRegistry.registerItem('MShop.MainTabPanel', 'MShop.panel.supplier.listui', MShop.panel.supplier.ListUi, 55);
