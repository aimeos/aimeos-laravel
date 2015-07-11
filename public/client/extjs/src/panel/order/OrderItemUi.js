/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.order');

MShop.panel.order.OrderUi = Ext.extend(Ext.FormPanel, {

    recordName : 'Order_Base',
    idProperty : 'order.base.id',
    siteidProperty : 'order.base.siteid',

    title : MShop.I18n.dt('client/extjs', 'Order'),
    layout : 'fit',
    flex : 1,

    initComponent : function() {

        this.initStore();

        // get items
        this.items = [{
            xtype : 'fieldset',
            style : 'padding-right: 25px;',
            border : false,
            labelAlign : 'left',
            defaults : {
                readOnly : this.fieldsReadOnly,
                anchor : '100%'
            },
            items : [{
                xtype : 'displayfield',
                fieldLabel : MShop.I18n.dt('client/extjs', 'Base ID'),
                name : 'order.base.id'
            }, {
                xtype : 'displayfield',
                fieldLabel : MShop.I18n.dt('client/extjs', 'Site'),
                name : 'order.base.sitecode'
            }, {
                xtype : 'displayfield',
                fieldLabel : MShop.I18n.dt('client/extjs', 'Customer'),
                name : 'order.base.customerid'
            }, {
                xtype : 'displayfield',
                fieldLabel : MShop.I18n.dt('client/extjs', 'Currency'),
                name : 'order.base.currencyid'
            }, {
                xtype : 'displayfield',
                fieldLabel : MShop.I18n.dt('client/extjs', 'Total'),
                name : 'order.base.price'
            }, {
                xtype : 'displayfield',
                fieldLabel : MShop.I18n.dt('client/extjs', 'Costs'),
                name : 'order.base.costs'
            }, {
                xtype : 'displayfield',
                fieldLabel : MShop.I18n.dt('client/extjs', 'Comment'),
                name : 'order.base.comment'
            }]
        }];

        MShop.panel.order.OrderUi.superclass.initComponent.call(this);
    },

    initStore : MShop.panel.ListItemListUi.prototype.initStore,
    onStoreException : MShop.panel.AbstractListUi.prototype.onStoreException,
    onBeforeLoad : MShop.panel.AbstractListUi.prototype.setSiteParam,
    onBeforeWrite : Ext.emptyFn,

    onDestroy : function() {
        this.store.un('beforeload', this.setFilters, this);
        this.store.un('beforeload', this.onBeforeLoad, this);
        this.store.un('load', this.onStoreLoad, this);
        this.store.un('beforewrite', this.onBeforeWrite, this);
        this.store.un('write', this.onStoreWrite, this);
        this.store.un('exception', this.onStoreException, this);

        MShop.panel.order.OrderUi.superclass.onDestroy.apply(this, arguments);
    },

    afterRender : function() {
        // fetch ItemUI
        this.itemUi = this.findParentBy(function(c) {
            return c.isXType(MShop.panel.AbstractItemUi, false);
        });

        this.store.load({});

        MShop.panel.order.OrderUi.superclass.afterRender.apply(this, arguments);
    },

    onStoreLoad : function() {
        if(this.store.getCount() === 0) {
            var recordType = MShop.Schema.getRecord(this.recordName);
            this.record = new recordType({});

            this.store.add(this.record);
        } else {
            this.record = this.store.getAt(0);
        }

        this.getForm().loadRecord(this.record);
    },


    setFilters : function(store, options) {
        if(!this.itemUi.record || this.itemUi.record.phantom) {
            // nothing to load
            this.onStoreLoad();
            return false;
        }

        // filter for refid
        options.params = options.params || {};
        options.params.condition = {
            '&&' : [{
                '==' : {
                    'order.base.id' : this.itemUi.record.data['order.baseid']
                }
            }]
        };

        return true;
    }
});

// hook this into the product ItemUi Basic Panel
Ext.ux.ItemRegistry.registerItem('MShop.panel.order.ItemUi.BasicPanel', 'MShop.panel.order.OrderUi',
    MShop.panel.order.OrderUi, 20);
