/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.elements.exportlanguage');

/**
 * Window
 * 
 * @namespace MShop
 * @class MShop.elements.exportlanguage.Window
 * @extends Ext.Window
 */
MShop.elements.exportlanguage.Window = Ext.extend(Ext.Window, {

        modal : true,
        constrain : true,
        maximized : true,
        layout : 'fit',
        title : MShop.I18n.dt('client/extjs', 'Select languages to export'),

        gridItemList : null,
        gridList : null,
        refStore : null,

        recordName : 'Locale_Language',

        idProperty : 'locale.language.id',

        gridConfig : {
            enableDragDrop : true,
            ddGroup : 'listItemsDDGroup'
        },

        storeConfig : null,

        sortInfo : {
            field : 'locale.language.status',
            direction : 'DESC'
        },

        filterConfig : {
            filters : [{
                dataIndex : 'locale.language.label',
                operator : '=~',
                value : ''
            }]
        },

        initComponent : function() {
            this.initFbar();
            this.initStore();
            this.initActions();

            if(this.filterConfig) {
                this.filterConfig.filterModel = this.filterConfig.filterModel ||
                    MShop.Schema.getFilterModel(this.recordName);
            }

            this.gridItemList = new Ext.grid.GridPanel(Ext.apply({
                border : true,
                ref : 'itemListUi',
                flex : 1,
                store : new Ext.data.ArrayStore({
                    fields : ['locale.language.status', 'locale.language.id', 'locale.language.label'],
                    idIndex : 0
                }),
                autoExpandColumn : 'dd-global-language-label',
                columns : [{
                    xtype : 'gridcolumn',
                    dataIndex : 'locale.language.status',
                    header : MShop.I18n.dt('client/extjs', 'Status'),
                    width : 50,
                    renderer : this.statusColumnRenderer
                }, {
                    xtype : 'gridcolumn',
                    dataIndex : 'locale.language.id',
                    header : MShop.I18n.dt('client/extjs', 'ID'),
                    width : 50
                }, {
                    xtype : 'gridcolumn',
                    dataIndex : 'locale.language.label',
                    id : 'dd-global-language-label',
                    header : MShop.I18n.dt('client/extjs', 'Label')
                }]
            }, this.gridConfig));

            this.gridList = new Ext.grid.GridPanel(Ext.apply({
                border : true,
                ref : 'listUi',
                flex : 1,
                store : this.store,
                autoExpandColumn : 'global-language-label',
                columns : [{
                    xtype : 'gridcolumn',
                    dataIndex : 'locale.language.status',
                    header : MShop.I18n.dt('client/extjs', 'Status'),
                    width : 50,
                    sortable : true,
                    renderer : this.statusColumnRenderer
                }, {
                    xtype : 'gridcolumn',
                    dataIndex : 'locale.language.id',
                    header : MShop.I18n.dt('client/extjs', 'ID'),
                    sortable : true,
                    width : 50
                }, {
                    xtype : 'gridcolumn',
                    dataIndex : 'locale.language.label',
                    id : 'global-language-label',
                    sortable : true,
                    header : MShop.I18n.dt('client/extjs', 'Label')
                }],
                tbar : Ext.apply({
                    xtype : 'ux.advancedsearch',
                    store : this.store
                }, this.filterConfig),
                bbar : {
                    xtype : 'MShop.elements.pagingtoolbar',
                    store : this.store
                }
            }, this.gridConfig));

            this.items = [{
                xtype : 'panel',
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                items : [{
                    xtype : 'panel',
                    border : false,
                    layout : 'fit',
                    flex : 1,
                    items : [this.gridItemList],
                    tbar : [this.actionDelete]
                }, {
                    xtype : 'panel',
                    border : false,
                    layout : 'fit',
                    flex : 1,
                    items : [this.gridList],
                    tbar : []
                }]
            }];

            this.gridItemList.on('rowcontextmenu', this.onGridItemListContextMenu, this);
            this.gridItemList.getSelectionModel().on('selectionchange', this.onGridSelectionChange, this, {
                buffer : 10
            });

            MShop.elements.exportlanguage.Window.superclass.initComponent.call(this);
        },

        initActions : function() {
            this.actionDelete = new Ext.Action({
                text : MShop.I18n.dt('client/extjs', 'Delete'),
                disabled : true,
                handler : this.onDeleteSelectedItems.createDelegate(this)
            });
        },

        afterRender : function() {
            MShop.elements.exportlanguage.Window.superclass.afterRender.apply(this, arguments);
            this.initDropZone();
            this.gridItemList.store.on('remove', this.onListStoreRemove, this);
        },

        initDropZone : function() {
            var view = this.gridItemList.getView();

            if(!view.scroller) {
                return this.initDropZone.defer(10, this);
            }

            var gridDropTargetEl = this.gridItemList.getView().scroller.dom;
            var dropTarget = new Ext.dd.DropTarget(gridDropTargetEl, {
                ddGroup : 'listItemsDDGroup',
                notifyDrop : this.onListItemDrop.createDelegate(this)
            });

            /** @todo Is this correct? */
            return true;
        },

        insertListItems : function(records, rowIndex) {
            // remove duplicates and highlight them in grid
            var refStore = this.getRefStore();
            var duplicats = [];
            var clones = [];

            Ext.each([].concat(records), function(record) {
                if(refStore.getById(record.id)) {
                    records.remove(record);

                    var idx = this.gridItemList.store.find('locale.language.refid', record.id);
                    Ext.fly(this.gridItemList.getView().getRow(idx)).highlight();
                } else {
                    clones.push(record.copy());
                }
            }, this);

            records = clones;
            if(Ext.isEmpty(records)) {
                return;
            }

            refStore.add(records);

            var rs = [], recordType = MShop.Schema.getRecord(this.recordName);
            Ext.each(records, function(record) {
                var data = {};
                data['locale.language.refid'] = record.id;
                data['locale.language.status'] = record.data['locale.language.status'];
                data['locale.language.id'] = record.data['locale.language.id'];
                data['locale.language.label'] = record.data['locale.language.label'];
                data['locale.language.domain'] = 'locale';
                data['locale.language.position'] = 0;
                rs.push(new recordType(data));
            }, this);

            this.gridItemList.store.insert(rowIndex !== false ? rowIndex : this.gridItemList.store.getCount(), rs);

            this.gridItemList.store.each(function(record, idx) {
                record.set('locale.language.position', idx);
            }, this);

        },

        onListItemDrop : function(ddSource, e, data) {
            var records = ddSource.dragData.selections;
            var store = this.gridItemList.store;
            var view = this.gridItemList.getView();
            var t = e.getTarget(view.rowSelector);
            var rowIndex = t ? view.findRowIndex(t) : store.getCount();

            if(ddSource.grid.store === store) {
                // reorder in same list
                var rs = [], posProperty = 'locale.language.position';

                store.each(function(record, idx) {
                    if(records.indexOf(record) < 0) {
                        rs.push(record);
                    }
                }, this);

                Ext.each(records, function(record) {
                    rs.splice(rowIndex, 0, record);
                });

                Ext.each(rs, function(record, idx) {
                    record.set(posProperty, idx);
                });

                store.sort(posProperty, 'ASC');
            } else {
                this.insertListItems(records, rowIndex);
            }

            return true;
        },

        getCtxMenu : function() {
            if(!this.ctxMenu) {
                this.ctxMenu = new Ext.menu.Menu({
                    items : [this.actionDelete]
                });
            }

            return this.ctxMenu;
        },

        onGridItemListContextMenu : function(grid, row, e) {
            e.preventDefault();

            var selModel = grid.getSelectionModel();
            if(!selModel.isSelected(row)) {
                selModel.selectRow(row);
            }

            this.getCtxMenu().showAt(e.getXY());
        },

        onDeleteSelectedItems : function() {
            var that = this;

            Ext.Msg.show({
                title : MShop.I18n.dt('client/extjs', 'Delete items?'),
                msg : MShop.I18n.dt('client/extjs',
                    'You are going to delete one or more items. Would you like to proceed?'),
                buttons : Ext.Msg.YESNO,
                fn : function(btn) {
                    if(btn == 'yes') {
                        that.gridItemList.store.remove(that.gridItemList.getSelectionModel().getSelections());
                    }
                },
                animEl : 'elId',
                icon : Ext.MessageBox.QUESTION
            });
        },

        onListStoreRemove : function(store, record, index) {
            var refStore = this.getRefStore();
            refStore.removeAt(index);
        },

        onGridSelectionChange : function(sm) {
            var numSelected = sm.getCount();
            this.actionDelete.setDisabled(numSelected === 0);
        },

        initFbar : function() {
            this.fbar = {
                xtype : 'toolbar',
                buttonAlign : 'right',
                hideBorders : true,
                items : [{
                    xtype : 'button',
                    text : MShop.I18n.dt('client/extjs', 'Cancel'),
                    width : 120,
                    scale : 'medium',
                    handler : this.close,
                    scope : this
                }, {
                    xtype : 'button',
                    text : MShop.I18n.dt('client/extjs', 'Export'),
                    width : 120,
                    scale : 'medium',
                    handler : this.onExportItem,
                    scope : this
                }]
            };
        },

        initStore : function() {
            this.store = new Ext.data.DirectStore(Ext.apply({
                autoLoad : true,
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

        onBeforeLoad : function(store, options) {
            this.setSiteParam(store);

            if(this.domain) {
                this.setDomainFilter(store, options);
            }

            options.params = options.params || {};
        },

        onBeforeWrite : function(store, action, records, options) {
            this.setSiteParam(store);

            if(this.domain) {
                this.setDomainProperty(store, action, records, options);
            }
        },

        onDestroy : function() {
            this.store.un('beforeload', this.onBeforeLoad, this);
            this.store.un('beforewrite', this.onBeforeWrite, this);
            this.store.un('exception', this.onStoreException, this);

            MShop.elements.exportlanguage.Window.superclass.onDestroy.apply(this, arguments);
        },

        onStoreException : function(proxy, type, action, options, response) {
            var title = MShop.I18n.dt('client/extjs', 'Error');
            var errmsg = MShop.I18n.dt('client/extjs', 'No error information available');
            var msg = response && response.error ? response.error.message : errmsg;
            var code = response && response.error ? response.error.code : 0;

            Ext.Msg.alert([title, ' (', code, ')'].join(''), msg);
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

        onExportItem : function() {
            var rs = [];

            this.gridItemList.store.each(function(record, idx) {
                rs.push(record.data['locale.language.id']);
            }, this);

            this.fireEvent('save', this, rs);
            this.close();

            Ext.MessageBox.alert(
                MShop.I18n.dt('client/extjs', 'Export successful'),
                MShop.I18n.dt(
                    'client/extjs',
                    'The file with the exported texts will be available within a few minutes. It can then be downloaded from the "Job" panel of the "Overview" tab.'));
        },

        statusColumnRenderer : function(status, metaData) {
            metaData.css = 'statusicon-' + Number(status);
        },

        getRefStore : function() {
            if(!this.refStore) {
                var recordName = this.recordName, idProperty = this.idProperty, data = {
                    items : [],
                    total : 0
                };

                if(this.gridItemList.store.reader.jsonData && this.gridItemList.store.reader.jsonData.graph &&
                    this.gridItemList.store.reader.jsonData.graph[recordName]) {
                    data = this.gridItemList.store.reader.jsonData.graph[recordName];
                }

                this.refStore = new Ext.data.JsonStore({
                    autoLoad : false,
                    remoteSort : false,
                    hasMultiSort : true,
                    fields : MShop.Schema.getRecord(recordName),
                    root : 'items',
                    totalProperty : 'total',
                    idProperty : idProperty,
                    data : data
                });
            }

            return this.refStore;
        }
    });

Ext.reg('MShop.elements.language.window', MShop.elements.exportlanguage.Window);
