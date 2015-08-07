/*!
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */

Ext.ns('MShop.panel.product.property');

/**
 * Concrete ItemUi
 * 
 * @extends Mshop.panel.AbstractListItemUi
 */
MShop.panel.product.property.ItemUi = Ext.extend(MShop.panel.AbstractItemUi, {

    siteidProperty : 'product.property.siteid',

    initComponent : function() {

        this.title = MShop.I18n.dt('client/extjs', 'Properties');
        this.typeStore = MShop.GlobalStoreMgr.get('Product_Property_Type');

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.product.property.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.product.property.ItemUi.BasicPanel',

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
                            name : 'product.property.parentid'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'ID'),
                            name : 'product.property.id'
                        }, {
                            xtype : 'combo',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Type'),
                            name : 'product.property.typeid',
                            mode : 'local',
                            store : this.typeStore,
                            displayField : 'product.property.type.label',
                            valueField : 'product.property.type.id',
                            forceSelection : true,
                            triggerAction : 'all',
                            allowBlank : false,
                            typeAhead : true
                        }, {
                            xtype : 'MShop.elements.language.combo',
                            name : 'product.property.languageid'
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Value'),
                            name : 'product.property.value',
                            allowBlank : false,
                            emptyText : MShop.I18n.dt('client/extjs', 'Property value (required)')
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'product.property.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'product.property.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'product.property.editor'
                        }]
                    }]
                }]
            }]
        }];

        MShop.panel.product.property.ItemUi.superclass.initComponent.call(this);
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
        this.record.data['product.property.parentid'] = this.listUI.itemUi.record.id;

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
        MShop.panel.product.property.ItemUi.superclass.onStoreException.apply(this, arguments);
    }
});

Ext.reg('MShop.panel.product.property.itemui', MShop.panel.product.property.ItemUi);
