/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */


Ext.ns('MShop.panel.plugin');

MShop.panel.plugin.ListUi = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Plugin',
    idProperty : 'plugin.id',
    siteidProperty : 'plugin.siteid',
    itemUiXType : 'MShop.panel.plugin.itemui',

    autoExpandColumn : 'plugin-list-label',

    sortInfo : {
        field : 'plugin.position',
        direction : 'ASC'
    },

    filterConfig : {
        filters : [{
            dataIndex : 'plugin.label',
            operator : '=~',
            value : ''
        }]
    },

    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Plugin');

        MShop.panel.AbstractListUi.prototype.initActions.call(this);
        MShop.panel.AbstractListUi.prototype.initToolbar.call(this);

        MShop.panel.plugin.ListUi.superclass.initComponent.call(this);
    },

    getColumns : function() {
        // make sure plugin type store gets loaded in same batch as this grid data
        this.typeStore = MShop.GlobalStoreMgr.get('Plugin_Type');

        return [{
            xtype : 'gridcolumn',
            dataIndex : 'plugin.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            width : 50,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'plugin.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 70,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'plugin.typeid',
            header : MShop.I18n.dt('client/extjs', 'Type'),
            width : 100,
            renderer : this.typeColumnRenderer.createDelegate(this, [this.typeStore, "plugin.type.label"], true)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'plugin.provider',
            header : MShop.I18n.dt('client/extjs', 'Provider'),
            id : 'plugin-list-provider',
            sortable : true,
            editable : false
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'plugin.label',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            sortable : true,
            width : 100,
            editable : false,
            id : 'plugin-list-label'
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'plugin.position',
            header : MShop.I18n.dt('client/extjs', 'Position'),
            sortable : true,
            width : 100,
            editable : false
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'plugin.config',
            header : MShop.I18n.dt('client/extjs', 'Configuration'),
            width : 200,
            editable : false,
            renderer : function(value) {
                var s = "";
                Ext.iterate(value, function(key, value, object) {
                    if(typeof value === "object") {
                        value = Ext.util.JSON.encode(value);
                    }
                    s = s + String.format('<div>{0}: {1}</div>', key, value);
                }, this);
                return s;
            }
        }, {
            xtype : 'datecolumn',
            dataIndex : 'plugin.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'plugin.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'plugin.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 130,
            hidden : true
        }];
    }

});

Ext.reg('MShop.panel.plugin.listui', MShop.panel.plugin.ListUi);

// hook this into the main tab panel
Ext.ux.ItemRegistry.registerItem('MShop.MainTabPanel', 'MShop.panel.plugin.listui', MShop.panel.plugin.ListUi, 60);
