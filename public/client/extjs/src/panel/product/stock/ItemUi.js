/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel.product.stock');

/**
 * Concrete ItemUi
 * 
 * @extends Mshop.panel.AbstractListItemUi
 */
MShop.panel.product.stock.ItemUi = Ext.extend(MShop.panel.AbstractItemUi, {

    siteidProperty : 'product.stock.siteid',

    initComponent : function() {

        this.title = MShop.I18n.dt('client/extjs', 'Product stock');

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.product.stock.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.product.stock.ItemUi.BasicPanel',

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
                            xtype : 'hidden',
                            name : 'product.stock.productid'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'ID'),
                            name : 'product.stock.id'
                        }, {
                            xtype : 'combo',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Warehouse'),
                            name : 'product.stock.warehouseid',
                            mode : 'local',
                            store : MShop.GlobalStoreMgr.get('Product_Stock_Warehouse', this.domain),
                            displayField : 'product.stock.warehouse.label',
                            valueField : 'product.stock.warehouse.id',
                            forceSelection : true,
                            triggerAction : 'all',
                            typeAhead : true,
                            listeners : {
                                'render' : {
                                    fn : function() {
                                        var record, index = this.store.find('product.stock.warehouse.code', 'default');
                                        if((record = this.store.getAt(index))) {
                                            this.setValue(record.id);
                                        }
                                    }
                                }
                            }
                        }, {
                            xtype : 'numberfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Stock level'),
                            name : 'product.stock.stocklevel',
                            emptyText : MShop.I18n.dt('client/extjs', 'Quantity or empty if unlimited (optional)')
                        }, {
                            xtype : 'datefield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Back in stock'),
                            name : 'product.stock.dateback',
                            format : 'Y-m-d H:i:s',
                            emptyText : MShop.I18n.dt('client/extjs', 'YYYY-MM-DD hh:mm:ss (optional)')
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'product.stock.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'product.stock.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'product.stock.editor'
                        }]
                    }]
                }]
            }]
        }];

        MShop.panel.product.stock.ItemUi.superclass.initComponent.call(this);
    },

    onSaveItem : function() {
        // validate data
        if(!this.mainForm.getForm().isValid() && this.fireEvent('validate', this) !== false) {
            Ext.Msg.alert(MShop.I18n.dt('client/extjs', 'Invalid data'), MShop.I18n.dt('client/extjs',
                'Please recheck your data'));
            return;
        }

        this.saveMask.show();
        this.isSaveing = true;

        // force record to be saved!
        this.record.dirty = true;

        if(this.fireEvent('beforesave', this, this.record) === false) {
            this.isSaveing = false;
            this.saveMask.hide();
        }

        this.mainForm.getForm().updateRecord(this.record);
        this.record.data['product.stock.productid'] = this.listUI.itemUi.record.id;

        if(this.action == 'add' || this.action == 'copy') {
            this.store.add(this.record);
        }

        // store async action is triggered. {@see onStoreWrite/onStoreException}
        if(!this.store.autoSave) {
            this.onAfterSave();
        }
    },

    onStoreException : function() {
        this.store.remove(this.record);
        MShop.panel.product.stock.ItemUi.superclass.onStoreException.apply(this, arguments);
    }
});

Ext.reg('MShop.panel.product.stock.itemui', MShop.panel.product.stock.ItemUi);
