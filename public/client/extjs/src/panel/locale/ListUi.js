/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.locale');

MShop.panel.locale.ListUi = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Locale',
    idProperty : 'locale.id',
    siteidProperty : 'locale.siteid',
    itemUiXType : 'MShop.panel.locale.itemui',

    sortInfo : {
        field : 'locale.position',
        direction : 'ASC'
    },

    autoExpandColumn : 'locale-currencyid',

    filterConfig : {
        filters : [{
            dataIndex : 'locale.position',
            operator : '>=',
            value : 0
        }]
    },

    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'List');

        MShop.panel.AbstractListUi.prototype.initActions.call(this);
        MShop.panel.AbstractListUi.prototype.initToolbar.call(this);

        MShop.panel.locale.ListUi.superclass.initComponent.call(this);
    },

    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'locale.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 50,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.languageid',
            header : MShop.I18n.dt('client/extjs', 'Language'),
            sortable : true,
            width : 100,
            renderer : MShop.elements.language.renderer
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.currencyid',
            header : MShop.I18n.dt('client/extjs', 'Currency'),
            sortable : true,
            width : 100,
            id : 'locale-currencyid',
            renderer : MShop.elements.currency.renderer
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.position',
            header : MShop.I18n.dt('client/extjs', 'Position'),
            sortable : true,
            width : 50
        }, {
            xtype : 'datecolumn',
            dataIndex : 'locale.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'locale.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 130,
            editable : false,
            hidden : true
        }];
    }
});

Ext.reg('MShop.panel.locale.listui', MShop.panel.locale.ListUi);

// hook this into the main tab panel
Ext.ux.ItemRegistry.registerItem('MShop.panel.locale.tabui', 'MShop.panel.locale.listui', MShop.panel.locale.ListUi, 10);
