/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */

Ext.ns('MShop.panel');

MShop.panel.AbstractListItemPickerUi = Ext.extend(Ext.Panel, {

    /**
     * @cfg {Object} itemConfig (required)
     */
    itemConfig : {},

    /**
     * @cfg {Object} rowCssClass (inherited)
     */
    rowCssClass : 'site-mismatch',

    layout : 'hbox',

    layoutConfig : {
        align : 'stretch'
    },

    initComponent : function() {
        this.items = [Ext.apply({
            border : true,
            flex : 1,
            ref : 'itemListUi',
            gridConfig : {
                enableDragDrop : true,
                ddGroup : 'listItemsDDGroup'
            }
        }, this.itemConfig), Ext.apply({
            border : true,
            ref : 'listUi',
            flex : 1,
            gridConfig : {
                enableDragDrop : true,
                ddGroup : 'listItemsDDGroup'
            }
        }, this.listConfig)];

        MShop.panel.AbstractListItemPickerUi.superclass.initComponent.call(this);

        Ext.apply(this.itemListUi.grid, {
            viewConfig : {
                emptyText : MShop.I18n.dt('client/extjs', 'No items'),
                getRowClass : function(record, index) {

                    siteid = MShop.config.site['locale.site.id'];
                    if(record.phantom === false && record.get(this.itemListUi.siteidProperty) != siteid) {
                        return this.rowCssClass;
                    }
                    return '';

                }.createDelegate(this)
            }
        });
    },

    afterRender : function() {

        MShop.panel.AbstractListItemPickerUi.superclass.afterRender.apply(this, arguments);
        this.initDropZone();

        this.listUi.store.on('write', this.onListStoreWrite, this);
        this.listUi.store.on('beforeload', this.onListBeforeLoad, this);
        this.itemListUi.store.on('remove', this.onListStoreRemove, this);
    },

    initDropZone : function() {

        var availview = this.listUi.grid.getView();
        var assocview = this.itemListUi.grid.getView();

        if(!availview.scroller || !assocview.scroller) {
            return this.initDropZone.defer(10, this);
        }

        var assocDropTarget = new Ext.dd.DropTarget(assocview.scroller.dom, {
            ddGroup : 'listItemsDDGroup',
            notifyDrop : this.onListItemDrop.createDelegate(this)
        });

        var availDropTarget = new Ext.dd.DropTarget(availview.scroller.dom, {
            ddGroup : 'listItemsDDGroup',
            notifyDrop : this.onAvailableListDrop.createDelegate(this)
        });

        return null;
    },

    insertListItems : function(records, rowIndex) {
        var refStore = this.getRefStore();
        var clones = [];

        this.listTypeStore.filter([{
            property : this.itemConfig.listNamePrefix + 'type.domain',
            value : this.itemListUi.domain
        }, {
            property : this.itemConfig.listNamePrefix + 'type.code',
            value : 'default'
        }]);

        var typeId = this.listTypeStore.getCount() ? this.listTypeStore.getAt(0).id : null;

        this.listTypeStore.clearFilter();

        Ext.each([].concat(records), function(record, id) {
            var refIdProperty = this.itemConfig.listNamePrefix + "refid";
            var typeIdPropery = this.itemConfig.listNamePrefix + "typeid";
            var recordTypeIdProperty = this.itemConfig.domain + ".typeid";

            if(refStore.getById(record.id)) {
                records.remove(record);

                // Get index of duplicated entry.
                var index = this.itemListUi.store.findBy(function(item) {
                    return (record.id == item.get(refIdProperty) && typeId == item.get(typeIdPropery));
                }, this);

                if(index != -1) {
                    // If entry is duplicated highlight it.
                    Ext.fly(this.itemListUi.grid.getView().getRow(index)).highlight();
                } else {
                    clones.push(record.copy());
                }
            } else {
                clones.push(record.copy());
            }
        }, this);

        records = clones;
        if(Ext.isEmpty(records)) {
            return;
        }

        // insert self in refStore
        refStore.add(records);

        // insert new list item records at the right position
        var rs = [], recordType = MShop.Schema.getRecord(this.itemListUi.recordName);

        Ext.each(records, function(record) {
            var data = {};
            data[this.itemConfig.listNamePrefix + 'refid'] = record.id;
            data[this.itemConfig.listNamePrefix + 'domain'] = this.itemListUi.domain;
            data[this.itemConfig.listNamePrefix + 'typeid'] = typeId;
            data[this.itemConfig.listNamePrefix + 'status'] = 1;
            rs.push(new recordType(data));
        }, this);

        this.itemListUi.store.insert(rowIndex !== false ? rowIndex : this.itemListUi.store.getCount(), rs);

        this.itemListUi.store.each(function(record, idx) {
            record.set(this.itemConfig.listNamePrefix + 'position', idx);
        }, this);
    },

    onAvailableListDrop : function(ddSource, e, ddElement) {

        if(!Ext.isArray(ddElement.selections)) {
            return;
        }

        var criteria = [];
        for( var i = 0; i < 1 /* ddElement.selections.length */; i++) {
            criteria.push({
                dataIndex : this.listUi.prefix + 'id',
                operator : '==',
                value : ddElement.selections[i].data[this.itemConfig.listNamePrefix + 'refid']
            });
        }

        if(this.listUi.grid && this.listUi.grid.topToolbar && this.listUi.grid.topToolbar.filterGroup) {
            this.listUi.grid.topToolbar.filterGroup.setFilterData(criteria/*
                                                                             * ,
                                                                             * 'OR'
                                                                             */);
        }
    },

    onListItemDrop : function(ddSource, e, data) {

        var records = ddSource.dragData.selections;
        var store = this.itemListUi.store;
        var view = this.itemListUi.grid.getView();
        var t = e.getTarget(view.rowSelector);
        var rowIndex = t ? view.findRowIndex(t) : store.getCount();

        if(ddSource.grid.store === store) {
            // reorder in same list
            var rs = [], posProperty = this.itemConfig.listNamePrefix + 'position';

            store.each(function(record, idx) {
                if(records.indexOf(record) < 0) {
                    rs.push(record);
                }
            }, this);

            // records.reverse();
            Ext.each(records, function(record) {
                rs.splice(rowIndex, 0, record);
            });

            Ext.each(rs, function(record, idx) {
                record.set(posProperty, idx);
            });

            store.sort(posProperty, 'ASC');
        } else {
            // insert new records
            this.insertListItems(records, rowIndex);
        }

        return true;
    },

    onListStoreWrite : function(store, action, result, transaction, rs) {
        if(action === 'create') {
            // autoinsert in itemList
            this.insertListItems([].concat(rs), 0);
        }
    },

    onListBeforeLoad : function(store, options) {

        options.params = options.params || {};
        options.params.domain = this.listConfig.domain;
        options.params.parentid = null;

        var itemUi = this.findParentBy(function(c) {
            return c.isXType(MShop.panel.AbstractItemUi, false);
        });

        if(!itemUi.record.isPhantom) {
            options.params.parentid = itemUi.record.id;
        }
    },

    onListStoreRemove : function(store, record, index) {
        var refStore = this.getRefStore();
        refStore.removeAt(index);
    },

    getRefStore : function() {
        if(!this.refStore) {
            var recordName = this.listUi.recordName, idProperty = this.listUi.idProperty, data = {
                items : [],
                total : 0
            };

            if(this.itemListUi.store.reader.jsonData && this.itemListUi.store.reader.jsonData.graph &&
                this.itemListUi.store.reader.jsonData.graph[recordName]) {
                data = this.itemListUi.store.reader.jsonData.graph[recordName];
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
    },

    onDestroy : function() {
        if(this.refStore) {
            this.refStore.destroy();
        }

        MShop.panel.AbstractListItemPickerUi.superclass.onDestroy.apply(this, arguments);
    },

    typeColumnRenderer : function(refId, metaData, record, rowIndex, colIndex, store, typeStore, displayField) {
        if(Ext.isEmpty(displayField)) {
            throw new Ext.Error(MShop.I18n.dt('client/extjs', 'Display field is empty'));
        }

        if(!Ext.isEmpty(refId)) {
            var refItem = typeStore.getById(refId);
            return (refItem ? refItem.get(displayField) : '');
        }

        var value = '', typeId = record.get(this.itemConfig.listNamePrefix + 'typeid');

        if(typeId) {
            value = typeStore.getById(typeId).get(displayField);
        }

        return value;
    },

    refColumnRenderer : function(refId, metaData, record, rowIndex, colIndex, store, displayField) {

        var refItem = this.getRefStore().getById(refId);
        return (refItem ? refItem.get(displayField) : '');
    },

    refDateColumnRenderer : function(refId, metaData, record, rowIndex, colIndex, store, displayField) {

        var refItem = this.getRefStore().getById(refId);
        renderer = Ext.util.Format.dateRenderer('Y-m-d H:i:s');

        return (refItem ? renderer(refItem.get(displayField)) : '');
    },

    refDecimalColumnRenderer : function(refId, metaData, record, rowIndex, colIndex, store, displayField) {

        var refItem = this.getRefStore().getById(refId);
        var renderer = Ext.util.Format.numberRenderer(Ext.grid.NumberColumn.prototype.format);

        return (refItem ? renderer(refItem.get(displayField)) : '');
    },

    refTypeColumnRenderer : function(refId, metaData, record, rowIndex, colIndex, store, typeStore, idField, displayField) {

        var refItem = this.getRefStore().getById(refId);

        if(refItem && typeStore) {
            var type = typeStore.getById(refItem.get(idField));
            return type ? type.get(displayField) : '';
        }

        return '';
    },

    refLangColumnRenderer : function(refId, metaData, record, rowIndex, colIndex, store, displayField) {

        var refItem = this.getRefStore().getById(refId);

        if(refItem) {
            return refItem.get(displayField) || MShop.I18n.dt('client/extjs', 'All');
        }

        return '';
    },

    refStatusColumnRenderer : function(refId, metaData, record, rowIndex, colIndex, store, displayField) {

        var refItem = this.getRefStore().getById(refId);
        var value, status = 0;

        if(refItem && (value = refItem.get(displayField))) {
            status = Number(value);
        }

        metaData.css = 'statusicon-' + status;
    }

});

Ext.reg('MShop.panel.abstractlistitempickerui', MShop.panel.AbstractListItemPickerUi);
