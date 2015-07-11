/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel');

MShop.panel.ListItemItemUi = Ext.extend(MShop.panel.AbstractItemUi, {

    getAdditionalFields : Ext.emptyFn,

    initComponent : function() {

        this.title = MShop.I18n.dt('client/extjs', 'List item details');

        this.items = [{
            xtype : 'form',
            border : false,
            flex : 1,
            layout : 'hbox',
            layoutConfig : {
                align : 'stretch'
            },
            ref : 'mainForm',
            autoScroll : true,
            items : [{
                xtype : 'fieldset',
                border : false,
                flex : 1,
                labelAlign : 'top',
                items : [{
                    xtype : 'MShop.elements.status.combo',
                    name : this.listUI.listNamePrefix + 'status'
                }, {
                    xtype : 'combo',
                    fieldLabel : MShop.I18n.dt('client/extjs', 'List type'),
                    name : this.listUI.listNamePrefix + 'typeid',
                    mode : 'local',
                    store : this.listUI.itemTypeStore,
                    valueField : this.listUI.listTypeIdProperty,
                    displayField : this.listUI.listTypeLabelProperty,
                    forceSelection : false,
                    triggerAction : 'all',
                    allowBlank : false,
                    typeAhead : true,
                    anchor : '100%',
                    emptyText : MShop.I18n.dt('client/extjs', 'List type')
                }, {
                    xtype : 'datefield',
                    fieldLabel : MShop.I18n.dt('client/extjs', 'Start date'),
                    name : this.listUI.listNamePrefix + 'datestart',
                    format : 'Y-m-d H:i:s',
                    anchor : '100%',
                    emptyText : MShop.I18n.dt('client/extjs', 'YYYY-MM-DD hh:mm:ss (optional)')
                }, {
                    xtype : 'datefield',
                    fieldLabel : MShop.I18n.dt('client/extjs', 'End date'),
                    name : this.listUI.listNamePrefix + 'dateend',
                    format : 'Y-m-d H:i:s',
                    anchor : '100%',
                    emptyText : MShop.I18n.dt('client/extjs', 'YYYY-MM-DD hh:mm:ss (optional)')
                }].concat(this.getAdditionalFields() || [])
            }, {
                xtype : 'MShop.panel.configui',
                layout : 'fit',
                flex : 1,
                data : (this.record ? this.record.get(this.listUI.listNamePrefix + 'config') : {})
            }]
        }];

        MShop.panel.ListItemItemUi.superclass.initComponent.call(this);
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

        this.getConfigRecords(this.store, this.record);

        if(this.fireEvent('beforesave', this, this.record) === false) {
            this.isSaveing = false;
            this.saveMask.hide();
        }

        var recordRefIdProperty = this.listUI.listNamePrefix + "refid";
        var recordTypeIdProperty = this.listUI.listNamePrefix + "typeid";

        var index = this.store.findBy(function(item, index) {
            var recordRefId = this.record.get(recordRefIdProperty);
            var recordTypeId = this.mainForm.getForm().getFieldValues()[recordTypeIdProperty];

            var itemRefId = item.get(recordRefIdProperty);
            var itemTypeId = item.get(recordTypeIdProperty);

            var recordId = this.record.id;
            var itemId = index;

            if(!recordRefId || !recordTypeId || !itemRefId || !itemTypeId)
                return false;

            return (recordRefId == itemRefId && recordTypeId == itemTypeId && recordId != itemId);
        }, this);

        if(index != -1) {
            this.isSaveing = false;
            this.saveMask.hide();
            Ext.Msg.alert(MShop.I18n.dt('client/extjs', 'Invalid data'), MShop.I18n.dt('client/extjs',
                'This combination already exists'));
            return;
        }

        this.mainForm.getForm().updateRecord(this.record);

        if(this.action == 'add' || this.action == 'copy') {
            this.store.add(this.record);
        }

        // store async action is triggered. {@see onStoreWrite/onStoreException}
        if(!this.store.autoSave) {
            this.onAfterSave();
        }
    },

    getConfigRecords : function(store, record) {
        var config = {};
        var editorGrid = this.findByType('MShop.panel.configui');
        var first = editorGrid.shift();

        if(first) {
            Ext.each(first.data, function(item, index) {
                Ext.iterate(item, function(key, value, object) {
                    if((key = key.trim()) !== '') {
                        config[key] = (typeof value === "string") ? value.trim() : value;
                    }
                }, this);
            });
        }
        record.data[this.listUI.listNamePrefix + 'config'] = config;
    }

});

Ext.reg('MShop.panel.listitemitemui', MShop.panel.ListItemItemUi);
