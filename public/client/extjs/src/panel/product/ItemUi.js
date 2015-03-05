/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */

Ext.ns('MShop.panel.product');

MShop.panel.product.ItemUi = Ext.extend(MShop.panel.AbstractListItemUi, {

    siteidProperty : 'product.siteid',

    initComponent : function() {

        MShop.panel.AbstractListItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.product.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.product.ItemUi.BasicPanel',
                plugins : ['ux.itemregistry'],
                defaults : {
                    bodyCssClass : this.readOnlyClass
                },
                items : [{
                    xtype : 'form',
                    title : MShop.I18n.dt('client/extjs', 'Details'),
                    flex : 1,
                    ref : '../../mainForm',
                    autoScroll : true,
                    items : [{
                        xtype : 'fieldset',
                        style : 'padding-right: 25px;',
                        border : false,
                        labelAlign : 'top',
                        defaults : {
                            readOnly : this.fieldsReadOnly,
                            anchor : '100%'
                        },
                        items : [{
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'ID'),
                            name : 'product.id'
                        }, {
                            xtype : 'MShop.elements.status.combo',
                            name : 'product.status'
                        }, {
                            xtype : 'combo',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Type'),
                            name : 'product.typeid',
                            mode : 'local',
                            store : MShop.GlobalStoreMgr.get('Product_Type'),
                            displayField : 'product.type.label',
                            valueField : 'product.type.id',
                            forceSelection : true,
                            triggerAction : 'all',
                            allowBlank : false,
                            typeAhead : true,
                            listeners : {
                                'render' : {
                                    fn : function() {
                                        var record, index = this.store.find('product.type.code', 'default');
                                        if((record = this.store.getAt(index))) {
                                            this.setValue(record.id);
                                        }
                                    }
                                }
                            }
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Code'),
                            name : 'product.code',
                            allowBlank : false,
                            maxLength : 32,
                            emptyText : MShop.I18n.dt('client/extjs', 'EAN, SKU or article number (required)')
                        }, {
                            xtype : 'textarea',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            name : 'product.label',
                            allowBlank : false,
                            maxLength : 255,
                            emptyText : MShop.I18n.dt('client/extjs', 'Internal name (required)')
                        }, {
                            xtype : 'combo',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Supplier'),
                            name : 'product.suppliercode',
                            store : MShop.GlobalStoreMgr.createStore('Supplier'),
                            displayField : 'supplier.label',
                            valueField : 'supplier.label',
                            forceSelection : true,
                            triggerAction : 'all',
                            submitValue : true,
                            typeAhead : true,
                            emptyText : MShop.I18n.dt('client/extjs', 'Product supplier (optional)')
                        }, {
                            xtype : 'datefield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Start date'),
                            name : 'product.datestart',
                            format : 'Y-m-d H:i:s',
                            emptyText : MShop.I18n.dt('client/extjs', 'YYYY-MM-DD hh:mm:ss (optional)')
                        }, {
                            xtype : 'datefield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'End date'),
                            name : 'product.dateend',
                            format : 'Y-m-d H:i:s',
                            emptyText : MShop.I18n.dt('client/extjs', 'YYYY-MM-DD hh:mm:ss (optional)')
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'product.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'product.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'product.editor'
                        }]
                    }]
                }, {
                    xtype : 'MShop.panel.product.stock.listuismall',
                    layout : 'fit',
                    flex : 1
                }]
            }]
        }];

        MShop.panel.product.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['product.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Product item panel title with product label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Product: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.product.ItemUi.superclass.afterRender.apply(this, arguments);
    },

    onStoreWrite : function(store, action, result, transaction, rs) {

        var records = Ext.isArray(rs) ? rs : [rs];
        var ids = [];

        MShop.panel.product.ItemUi.superclass.onStoreWrite.apply(this, arguments);

        for( var i = 0; i < records.length; i++) {
            ids.push(records[i].id);
        }

        MShop.API.Product.finish(MShop.config.site["locale.site.code"], ids);
    }
});

Ext.reg('MShop.panel.product.itemui', MShop.panel.product.ItemUi);
