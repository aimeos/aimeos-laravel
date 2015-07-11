/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.locale.site');

MShop.panel.locale.site.ListUi = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Locale_Site',
    idProperty : 'locale.site.id',
    siteidProperty : 'locale.site.id',
    itemUiXType : 'MShop.panel.locale.site.itemui',

    autoExpandColumn : 'locale-site-label',

    filterConfig : {
        filters : [{
            dataIndex : 'locale.site.label',
            operator : '=~',
            value : 0
        }]
    },

    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Site');

        MShop.panel.AbstractListUi.prototype.initActions.call(this);
        MShop.panel.AbstractListUi.prototype.initToolbar.call(this);

        this.initStore();

        MShop.panel.locale.site.ListUi.superclass.initComponent.call(this);
    },

    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'locale.site.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.site.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 50,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.site.code',
            header : MShop.I18n.dt('client/extjs', 'Code'),
            sortable : true,
            width : 100,
            editable : false
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.site.label',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            sortable : true,
            width : 100,
            editable : false,
            id : 'locale-site-label'
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.site.config',
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
            dataIndex : 'locale.site.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'locale.site.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'locale.site.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 130,
            editable : false,
            hidden : true
        }];
    },

    initToolbar : function() {
        this.tbar = [this.actionAdd, this.actionEdit, this.actionDelete, this.actionExport, this.importButton];
    },

    initStore : function() {
        this.store = new Ext.data.DirectStore(Ext.apply({
            autoLoad : false,
            remoteSort : true,
            hasMultiSort : true,
            fields : MShop.Schema.getRecord(this.recordName),
            api : {
                read : MShop.API[this.recordName].searchItems,
                create : MShop.API[this.recordName].insertItems,
                update : MShop.API[this.recordName].saveItems,
                destroy : MShop.API[this.recordName].deleteItems
            },
            writer : new Ext.data.JsonWriter({
                writeAllFields : true,
                encode : false
            }),
            paramsAsHash : true,
            root : 'items',
            totalProperty : 'total',
            idProperty : this.idProperty,
            sortInfo : this.sortInfo
        }, this.storeConfig));

        // make sure site param gets set for read/write actions
        this.store.on('beforeload', this.onBeforeLoad, this);
        this.store.on('exception', this.onStoreException, this);
        this.store.on('beforewrite', this.onBeforeWrite, this);
    }
});

Ext.reg('MShop.panel.locale.site.listui', MShop.panel.locale.site.ListUi);

// hook this into the main tab panel
Ext.ux.ItemRegistry.registerItem('MShop.panel.locale.tabui', 'MShop.panel.locale.site.listui',
    MShop.panel.locale.site.ListUi, 20);
