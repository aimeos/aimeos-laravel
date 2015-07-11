/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.locale.language');

MShop.panel.locale.language.ListUi = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Locale_Language',
    idProperty : 'locale.language.id',
    siteidProperty : 'locale.language.siteid',
    itemUiXType : 'MShop.panel.locale.language.itemui',

    autoExpandColumn : 'locale-language-label',

    filterConfig : {
        filters : [{
            dataIndex : 'locale.language.label',
            operator : '=~',
            value : ''
        }]
    },

    sortInfo : {
        field : 'locale.language.status',
        direction : 'DESC'
    },

    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Language');

        MShop.panel.AbstractListUi.prototype.initActions.call(this);
        MShop.panel.AbstractListUi.prototype.initToolbar.call(this);

        MShop.panel.locale.language.ListUi.superclass.initComponent.call(this);
    },

    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'locale.language.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.language.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 50,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.language.code',
            header : MShop.I18n.dt('client/extjs', 'Code'),
            sortable : true,
            width : 100,
            editable : false
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.language.label',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            sortable : true,
            width : 100,
            editable : false,
            id : 'locale-language-label'
        }, {
            xtype : 'datecolumn',
            dataIndex : 'locale.language.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'locale.language.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.language.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 130,
            editable : false,
            hidden : true
        }];
    }
});

Ext.reg('MShop.panel.locale.language.listui', MShop.panel.locale.language.ListUi);

// hook this into the main tab panel
Ext.ux.ItemRegistry.registerItem('MShop.panel.locale.tabui', 'MShop.panel.locale.language.listui',
    MShop.panel.locale.language.ListUi, 30);
