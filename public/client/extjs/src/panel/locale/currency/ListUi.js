/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://www.arcavias.com/en/license
 */


Ext.ns('MShop.panel.locale.currency');

MShop.panel.locale.currency.ListUi = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Locale_Currency',
    idProperty : 'locale.currency.id',
    siteidProperty : 'locale.currency.siteid',
    itemUiXType : 'MShop.panel.locale.currency.itemui',

    autoExpandColumn : 'locale-currency-label',

    filterConfig : {
        filters : [{
            dataIndex : 'locale.currency.label',
            operator : '=~',
            value : ''
        }]
    },

    sortInfo : {
        field : 'locale.currency.status',
        direction : 'DESC'
    },

    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Currency');

        MShop.panel.AbstractListUi.prototype.initActions.call(this);
        MShop.panel.AbstractListUi.prototype.initToolbar.call(this);

        MShop.panel.locale.currency.ListUi.superclass.initComponent.call(this);
    },

    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'locale.currency.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.currency.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 50,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.currency.code',
            header : MShop.I18n.dt('client/extjs', 'Code'),
            sortable : true,
            width : 100,
            editable : false
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.currency.label',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            sortable : true,
            width : 100,
            editable : false,
            id : 'locale-currency-label'
        }, {
            xtype : 'datecolumn',
            dataIndex : 'locale.currency.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'locale.currency.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.currency.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 130,
            editable : false,
            hidden : true
        }];
    }
});

Ext.reg('MShop.panel.locale.currency.listui', MShop.panel.locale.currency.ListUi);

// hook this into the main tab panel
Ext.ux.ItemRegistry.registerItem('MShop.panel.locale.tabui', 'MShop.panel.locale.currency.listui',
    MShop.panel.locale.currency.ListUi, 30);
