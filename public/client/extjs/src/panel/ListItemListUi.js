/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */

Ext.ns('MShop.panel');

MShop.panel.ListItemListUi = Ext.extend(MShop.panel.AbstractListUi, {
    /**
     * @cfg {String} domain
     */
    domain : null,

    /**
     * @cfg {Function} getAdditionalColumns
     */
    getAdditionalColumns : Ext.emptyFn,

    /**
     * @property MShop.panel.AbstractItemUi itemUi parent itemUi this listpanel
     *           is child of
     */
    itemUi : null,

    /**
     * @property MShop.panel.AbstractListItemPickerUi listItemPickerUi parent
     *           listItemPickerUi this listpanel is agregated in
     */
    listItemPickerUi : null,

    itemUiXType : 'MShop.panel.listitemitemui',

    initComponent : function() {
        // remove filter + paging
        this.gridConfig = this.gridConfig || {};
        this.gridConfig.tbar = null;
        this.gridConfig.bbar = null;

        this.autoExpandColumn = 'refcontent';

        // fetch ListItemPickerUi
        this.listItemPickerUi = this.findParentBy(function(c) {
            return c.isXType(MShop.panel.AbstractListItemPickerUi, false);
        });

        // fetch ItemUI
        this.itemUi = this.findParentBy(function(c) {
            return c.isXType(MShop.panel.AbstractItemUi, false);
        });
        this.itemUi.on('save', this.onItemUiSave, this);

        MShop.panel.ListItemListUi.superclass.initComponent.call(this);

        this.grid.getView().getRowClass = function(record, rowIndex, rowParams, store) {
            if((status = record.get(this.listItemPickerUi.itemConfig.listNamePrefix + 'status')) <= 0) {
                return 'statustext-' + Number(status);
            }
            return '';
        }.createDelegate(this);
    },

    initStore : function() {
        this.storeConfig = this.storeConfig || {};
        this.storeConfig.remoteSort = false;
        this.storeConfig.autoSave = false;

        MShop.panel.ListItemListUi.superclass.initStore.call(this);

        this.store.on('load', this.onStoreLoad, this);
        this.store.on('beforeload', this.setFilters, this);
        this.store.on('write', this.onStoreWrite, this);
        //this.store.on('exception', this.onStoreException, this);
    },

    onDestroy : function() {
        this.store.un('load', this.onStoreLoad, this);
        this.store.un('beforeload', this.setFilters, this);
        this.store.un('write', this.onStoreWrite, this);
        //this.store.un('exception', this.onStoreException, this);

        MShop.panel.ListItemListUi.superclass.onDestroy.apply(this, arguments);
    },

    onOpenEditWindow : function(action) {
        if(action === 'add') {
            return Ext.Msg.alert(MShop.I18n.dt('client/extjs', 'Select Item'), MShop.I18n.dt('client/extjs',
                'Please select an item on the right side and add it via drag and drop to this list.'));
        }

        return MShop.panel.ListItemListUi.superclass.onOpenEditWindow.apply(this, arguments);
    },

    onStoreLoad : function(store) {
        this.store.sort(this.listItemPickerUi.itemConfig.listNamePrefix + 'position', 'ASC');
    },

    onStoreWrite : function() {
        this.returnTicket();
    },

    onItemUiSave : function(itemUi, record, ticketFn) {
        // make sure all parentid are set
        this.store.each(function(r) {
            // Remove list id if the reference should be copied
            if(this.itemUi.action == 'copy') {
                r.id = null;
            }
            r.set(this.listItemPickerUi.itemConfig.listNamePrefix + 'parentid', record.id);
        }, this);

        if(this.store.save() !== -1) {
            this.returnTicket = ticketFn();
        }
    },

    setFilters : function(store, options) {
        if(this.itemUi.record.phantom && this.itemUi.action != 'copy') {
            // nothing to load
            return false;
        }

        // filter for refid
        //var parentIdProp = this.listItemPickerUi.listNamePrefix + ''
        var parentIdCriteria = {};
        parentIdCriteria[this.listItemPickerUi.itemConfig.listNamePrefix + 'parentid'] = this.itemUi.record.id;
        var domainCriteria = {};
        domainCriteria[this.listItemPickerUi.itemConfig.listNamePrefix + 'domain'] = this.domain;

        options.params = options.params || {};
        options.params.condition = {
            '&&' : [{
                '==' : parentIdCriteria
            }, {
                '==' : domainCriteria
            }]
        };

        return true;
    },

    getColumns : function() {
        var expr = this.listTypeCondition;
        var storeConfig = {
            baseParams : {
                site : MShop.config.site["locale.site.code"],
                condition : expr
            }
        };
        this.itemTypeStore = MShop.GlobalStoreMgr.get(this.listTypeControllerName, this.listTypeKey, storeConfig);

        return [{
            xtype : 'gridcolumn',
            dataIndex : this.listItemPickerUi.itemConfig.listNamePrefix + 'id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : this.listItemPickerUi.itemConfig.listNamePrefix + 'refid',
            header : MShop.I18n.dt('client/extjs', 'Ref-ID'),
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : this.listItemPickerUi.itemConfig.listNamePrefix + 'status',
            header : MShop.I18n.dt('client/extjs', 'List Status'),
            width : 50,
            hidden : true,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : this.listItemPickerUi.itemConfig.listNamePrefix + 'position',
            header : MShop.I18n.dt('client/extjs', 'Position'),
            width : 50,
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : this.listItemPickerUi.itemConfig.listNamePrefix + 'datestart',
            header : MShop.I18n.dt('client/extjs', 'Start date'),
            width : 120,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : this.listItemPickerUi.itemConfig.listNamePrefix + 'dateend',
            header : MShop.I18n.dt('client/extjs', 'End date'),
            width : 120,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : this.listItemPickerUi.itemConfig.listNamePrefix + 'config',
            header : MShop.I18n.dt('client/extjs', 'Configuration'),
            width : 200,
            editable : false,
            hidden : true,
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
            dataIndex : this.listItemPickerUi.itemConfig.listNamePrefix + 'ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            width : 120,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : this.listItemPickerUi.itemConfig.listNamePrefix + 'mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            width : 120,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : this.listItemPickerUi.itemConfig.listNamePrefix + 'editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            width : 50,
            hidden : true
        }].concat(this.getAdditionalColumns() || []);
    }
});

Ext.reg('MShop.panel.listitemlistui', MShop.panel.ListItemListUi);
