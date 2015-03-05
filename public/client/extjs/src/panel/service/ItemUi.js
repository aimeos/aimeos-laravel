/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */

Ext.ns('MShop.panel.service');

MShop.panel.service.ItemUi = Ext.extend(MShop.panel.AbstractListItemUi, {

    initComponent : function() {

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.service.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.service.ItemUi.BasicPanel',
                plugins : ['ux.itemregistry'],
                defaults : {
                    bodyCssClass : this.readOnlyClass
                },
                items : [{
                    xtype : 'form',
                    title : 'Details',
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
                            name : 'service.id'
                        }, {
                            xtype : 'MShop.elements.status.combo',
                            name : 'service.status'
                        }, {
                            xtype : 'combo',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Type'),
                            name : 'service.typeid',
                            mode : 'local',
                            store : MShop.GlobalStoreMgr.get('Service_Type'),
                            displayField : 'service.type.label',
                            valueField : 'service.type.id',
                            forceSelection : true,
                            triggerAction : 'all',
                            allowBlank : false,
                            typeAhead : true
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Code'),
                            name : 'service.code',
                            allowBlank : false,
                            maxLength : 32,
                            emptyText : MShop.I18n.dt('client/extjs', 'Unique code (required)')
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Provider'),
                            name : 'service.provider',
                            allowBlank : false,
                            maxLength : 255,
                            emptyText : MShop.I18n.dt('client/extjs', 'Name of the service provider class (required)')
                        }, {
                            xtype : 'textarea',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            name : 'service.label',
                            allowBlank : false,
                            maxLength : 255,
                            emptyText : MShop.I18n.dt('client/extjs', 'Internal name (required)')
                        }, {
                            xtype : 'numberfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Position'),
                            name : 'service.position',
                            allowDecimals : false,
                            allowBlank : false,
                            value : 0
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'service.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'service.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'service.editor'
                        }]
                    }]
                }, {
                    xtype : 'MShop.panel.configui',
                    layout : 'fit',
                    flex : 1,
                    data : (this.record ? this.record.get('service.config') : {})
                }]
            }]
        }];

        this.store.on('beforesave', this.onBeforeSave, this);

        MShop.panel.service.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['service.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Service item panel title with service label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Service: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.product.ItemUi.superclass.afterRender.apply(this, arguments);
    },

    onBeforeSave : function(store, data) {
        MShop.panel.service.ItemUi.superclass.onBeforeSave.call(this, store, data, {
            configname : 'service.config'
        });
    }
});

Ext.reg('MShop.panel.service.itemui', MShop.panel.service.ItemUi);
