/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel');

MShop.panel.AbstractListUi = Ext.extend(Ext.Panel, {
    /**
     * @cfg {String} recordName (required)
     */
    recordName : null,

    /**
     * @cfg {String} idProperty (required)
     */
    idProperty : null,

    /**
     * @cfg {String} siteidProperty (required)
     */
    siteidProperty : null,

    /**
     * @cfg {String} exportMethod (required)
     */
    exportMethod : null,

    /**
     * @cfg {String} domain (optional)
     */
    domain : null,

    /**
     * @cfg {String} domainProperty (optional)
     */
    domainProperty : null,

    /**
     * @cfg {Object} sortInfo (optional)
     */
    sortInfo : null,

    /**
     * @cfg {String} autoExpandColumn (optional)
     */
    autoExpandColumn : null,

    /**
     * @cfg {Object} storeConfig (optional)
     */
    storeConfig : null,

    /**
     * @cfg {Object} gridConfig (optional)
     */
    gridConfig : null,

    /**
     * @cfg {Object} filterConfig (optional)
     */
    filterConfig : null,

    /**
     * @cfg {String} itemUi xtype
     */
    itemUi : '',

    /**
     * @cfg {String} rowCssClass (inherited)
     */
    rowCssClass : 'site-mismatch',

    /**
     * @cfg {String} importMethod (optional)
     */
    importMethod : null,

    border : false,
    layout : 'fit',

    initComponent : function() {
        this.initActions();
        this.initToolbar();
        this.initStore();

        if(this.filterConfig) {
            this.filterConfig.filterModel = this.filterConfig.filterModel ||
                MShop.Schema.getFilterModel(this.recordName);
        }

        this.grid = new Ext.grid.GridPanel(Ext.apply({
            border : false,
            store : this.store,
            loadMask : true,
            autoExpandColumn : this.autoExpandColumn,
            columns : this.getColumns(),
            tbar : Ext.apply({
                xtype : 'ux.advancedsearch',
                store : this.store
            }, this.filterConfig),
            bbar : {
                xtype : 'MShop.elements.pagingtoolbar',
                store : this.store
            }
        }, this.gridConfig));

        this.items = [this.grid];

        this.grid.on('rowcontextmenu', this.onGridContextMenu, this);
        this.grid.on('rowdblclick', this.onOpenEditWindow.createDelegate(this, ['edit']), this);
        this.grid.getSelectionModel().on('selectionchange', this.onGridSelectionChange, this, {
            buffer : 10
        });

        MShop.panel.AbstractListUi.superclass.initComponent.apply(this, arguments);

        Ext.apply(this.grid, {
            viewConfig : {
                emptyText : MShop.I18n.dt('client/extjs', 'No items'),
                getRowClass : function(record, index) {

                    var siteid = MShop.config.site['locale.site.id'];
                    var recSiteid = record.get(this.siteidProperty) || null;

                    if(record.phantom === false && recSiteid !== null && recSiteid != siteid) {
                        return this.rowCssClass;
                    }
                    return '';

                }.createDelegate(this)
            }
        });
    },

    initActions : function() {
        this.actionAdd = new Ext.Action({
            text : MShop.I18n.dt('client/extjs', 'Add'),
            handler : this.onOpenEditWindow.createDelegate(this, ['add'])
        });

        this.actionEdit = new Ext.Action({
            text : MShop.I18n.dt('client/extjs', 'Edit'),
            disabled : true,
            handler : this.onOpenEditWindow.createDelegate(this, ['edit'])
        });

        this.actionCopy = new Ext.Action({
            text : MShop.I18n.dt('client/extjs', 'Copy'),
            disabled : true,
            handler : this.onOpenEditWindow.createDelegate(this, ['copy'])
        });

        this.actionDelete = new Ext.Action({
            text : MShop.I18n.dt('client/extjs', 'Delete'),
            disabled : true,
            handler : this.onDeleteSelectedItems.createDelegate(this)
        });

        this.actionExport = new Ext.Action({
            text : MShop.I18n.dt('client/extjs', 'Export'),
            disabled : (this.exportMethod === null),
            handler : this.onExport ? this.onExport.createDelegate(this) : Ext.emptyFn
        });

        this.actionImport = new MShop.elements.ImportButton({
            text : MShop.I18n.dt('client/extjs', 'Import'),
            disabled : (this.importMethod === null),
            importMethod : this.importMethod,
            handler : this.onFileSelect ? this.onFileSelect.createDelegate(this) : null
        });

    },

    initToolbar : function() {
        this.tbar = [
            this.actionAdd,
            this.actionEdit,
            this.actionCopy,
            this.actionDelete,
            this.actionExport,
            this.actionImport];
    },

    initStore : function() {
        this.store = new Ext.data.DirectStore(Ext.apply({
            autoLoad : false,
            remoteSort : true,
            hasMultiSort : true,
            fields : MShop.Schema.getRecord(this.recordName),
            api : {
                read : MShop.API[this.recordName].searchItems,
                create : MShop.API[this.recordName].saveItems,
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
    },

    afterRender : function() {
        MShop.panel.AbstractListUi.superclass.afterRender.apply(this, arguments);

        if(!this.store.autoLoad) {
            this.store.load.defer(50, this.store);
        }
    },

    getCtxMenu : function() {
        if(!this.ctxMenu) {
            this.ctxMenu = new Ext.menu.Menu({
                items : [this.actionAdd, this.actionEdit, this.actionCopy, this.actionDelete, this.actionExport]
            });
        }

        return this.ctxMenu;
    },

    onBeforeLoad : function(store, options) {
        this.setSiteParam(store);

        if(this.domain) {
            this.setDomainFilter(store, options);
        }

        this.actionExport.setDisabled(this.exportMethod === null);
    },

    onBeforeWrite : function(store, action, records, options) {
        this.setSiteParam(store);

        if(this.domain) {
            this.setDomainProperty(store, action, records, options);
        }
    },

    onDeleteSelectedItems : function() {
        var that = this;

        Ext.Msg.show({
            title : MShop.I18n.dt('client/extjs', 'Delete items?'),
            msg : MShop.I18n.dt('client/extjs', 'You are going to delete one or more items. Would you like to proceed?'),
            buttons : Ext.Msg.YESNO,
            fn : function(btn) {
                if(btn == 'yes') {
                    that.store.remove(that.grid.getSelectionModel().getSelections());
                }
            },
            animEl : 'elId',
            icon : Ext.MessageBox.QUESTION
        });
    },

    /**
     * start download
     */
    onExport : function() {
        var win = new MShop.elements.exportlanguage.Window();
        win.on('save', this.finishExport, this);
        win.show();
    },

    finishExport : function(langwin, languages) {
        var selection = this.grid.getSelectionModel().getSelections(), ids = [];

        Ext.each(selection, function(r) {
            ids.push(r.id);
        }, this);

        var downloader = new Ext.ux.file.Downloader({
            url : MShop.config.smd.target,
            params : {
                method : this.exportMethod,
                params : Ext.encode({
                    items : ids,
                    lang : languages,
                    site : MShop.config.site['locale.site.code']
                })
            }
        }).start();
    },

    onDestroy : function() {
        this.grid.un('rowcontextmenu', this.onGridContextMenu, this);
        this.grid.un('rowdblclick', this.onOpenEditWindow.createDelegate(this, ['edit']), this);
        this.grid.getSelectionModel().un('selectionchange', this.onGridSelectionChange, this, {
            buffer : 10
        });
        this.store.un('beforeload', this.onBeforeLoad, this);
        this.store.un('beforewrite', this.onBeforeWrite, this);
        this.store.un('exception', this.onStoreException, this);

        MShop.panel.AbstractListUi.superclass.onDestroy.apply(this, arguments);
    },

    onGridContextMenu : function(grid, row, e) {
        e.preventDefault();
        var selModel = grid.getSelectionModel();
        if(!selModel.isSelected(row)) {
            selModel.selectRow(row);
        }
        this.getCtxMenu().showAt(e.getXY());
    },

    onGridSelectionChange : function(sm) {
        var numSelected = sm.getCount();
        this.actionEdit.setDisabled(numSelected !== 1);
        this.actionCopy.setDisabled(numSelected !== 1);
        this.actionDelete.setDisabled(numSelected === 0);
        this.actionExport.setDisabled(this.exportMethod === null);
    },

    onOpenEditWindow : function(action) {
        var itemUi = Ext.ComponentMgr.create({
            xtype : this.itemUiXType,
            domain : this.domain,
            record : (action == 'copy' || action == 'edit') ? this.grid.getSelectionModel().getSelected() : null,
            store : this.store,
            listUI : this,
            action : action
        }, this);

        itemUi.show();
    },

    onStoreException : function(proxy, type, action, options, response) {
        var msg, code;
        var title = MShop.I18n.dt('client/extjs', 'Error');
        var errmsg = MShop.I18n.dt('client/extjs', 'No error information available');

        if(response.error !== undefined) {
            msg = response && response.error ? Ext.util.Format.nl2br( response.error.message ) : errmsg;
            code = response && response.error ? response.error.code : 0;
        } else {
            msg = response && response.xhr.responseText[0].error ? Ext.util.Format.nl2br( response.xhr.responseText[0].error ) : errmsg;
            code = response && response.xhr.responseText[0].tid ? response.xhr.responseText[0].tid : 0;
        }
        Ext.Msg.alert(title + ' (' + code + ')', msg);
    },

    setSiteParam : function(store) {
        store.baseParams = store.baseParams || {};
        store.baseParams.site = MShop.config.site["locale.site.code"];
    },

    setDomainFilter : function(store, options) {
        options.params = options.params || {};
        options.params.condition = options.params.condition || {};
        options.params.condition['&&'] = options.params.condition['&&'] || [];

        if(!this.domainProperty) {
            this.domainProperty = this.idProperty.replace(/\..*$/, '.domain');
        }

        var condition = {};
        condition[this.domainProperty] = this.domain;

        options.params.condition['&&'].push({
            '==' : condition
        });
    },

    setDomainProperty : function(store, action, records, options) {
        var rs = [].concat(records);

        Ext.each(rs, function(record) {
            if(!this.domainProperty) {
                this.domainProperty = this.idProperty.replace(/\..*$/, '.domain');
            }
            record.data[this.domainProperty] = this.domain;
        }, this);
    },

    typeColumnRenderer : function(typeId, metaData, record, rowIndex, colIndex, store, typeStore, displayField) {
        var type = typeStore.getById(typeId);
        return type ? type.get(displayField) : typeId;
    },

    statusColumnRenderer : function(status, metaData) {
        metaData.css = 'statusicon-' + Number(status);
    }
});
