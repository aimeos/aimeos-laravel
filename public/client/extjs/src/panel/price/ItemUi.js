/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.price');

MShop.panel.price.ItemUi = Ext.extend(MShop.panel.AbstractListItemUi, {
    siteidProperty : 'price.siteid',

    initComponent : function() {

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.price.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.price.ItemUi.BasicPanel',
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
                            name : 'price.id'
                        }, {
                            xtype : 'MShop.elements.status.combo',
                            name : 'price.status'
                        }, {
                            xtype : 'combo',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Type'),
                            name : 'price.typeid',
                            mode : 'local',
                            store : this.listUI.ItemTypeStore,
                            displayField : 'price.type.label',
                            valueField : 'price.type.id',
                            forceSelection : true,
                            triggerAction : 'all',
                            allowBlank : false,
                            typeAhead : true,
                            listeners : {
                                'render' : {
                                    fn : function() {
                                        var record, index = this.store.find('price.type.code', 'default');
                                        if((record = this.store.getAt(index))) {
                                            this.setValue(record.id);
                                        }
                                    }
                                }
                            }
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            name : 'price.label',
                            allowBlank : false,
                            emptyText : MShop.I18n.dt('client/extjs', 'Internal name (required)')
                        }, {
                            xtype : 'MShop.elements.currency.combo',
                            name : 'price.currencyid',
                            emptyText : MShop.I18n.dt('client/extjs', 'Currency (required)')
                        }, {
                            xtype : 'numberfield',
                            name : 'price.quantity',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Minimum quantity'),
                            allowNegative : false,
                            allowDecimals : false,
                            allowBlank : false,
                            value : 1
                        }, {
                            xtype : 'ux.decimalfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Actual current price'),
                            name : 'price.value',
                            allowBlank : false,
                            value : '0.00'
                        }, {
                            xtype : 'ux.decimalfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Substracted rebate amount'),
                            name : 'price.rebate',
                            allowBlank : false,
                            value : '0.00'
                        }, {
                            xtype : 'ux.decimalfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Costs per item'),
                            name : 'price.costs',
                            allowBlank : false,
                            value : '0.00'
                        }, {
                            xtype : 'ux.decimalfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Tax rate in %'),
                            name : 'price.taxrate',
                            allowBlank : false,
                            value : '0.00'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'price.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'price.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'price.editor'
                        }]
                    }]
                }]
            }]
        }];

        MShop.panel.price.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['price.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Price item panel title with price label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Price: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.price.ItemUi.superclass.afterRender.apply(this, arguments);
    }
});

Ext.reg('MShop.panel.price.itemui', MShop.panel.price.ItemUi);
