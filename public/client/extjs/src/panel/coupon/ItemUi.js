/*!
 * Copyright (c) Metaways Infosystems GmbH, 2013
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.coupon');

MShop.panel.coupon.ItemUi = Ext.extend(MShop.panel.AbstractItemUi, {

    siteidProperty : 'coupon.siteid',


    initComponent : function() {

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.coupon.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.coupon.ItemUi.BasicPanel',
                plugins : ['ux.itemregistry'],
                defaults : {
                    bodyCssClass : this.readOnlyClass
                },
                items : [{
                    xtype : 'form',
                    title : MShop.I18n.dt('client/extjs', 'Details'),
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
                            anchor : '100%'
                        },
                        items : [{
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'ID'),
                            name : 'coupon.id'
                        }, {
                            xtype : 'MShop.elements.status.combo',
                            name : 'coupon.status'
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Provider'),
                            name : 'coupon.provider',
                            allowBlank : false,
                            maxLength : 255,
                            emptyText : MShop.I18n.dt('client/extjs', 'Name of the coupon provider class (required)')
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            name : 'coupon.label',
                            allowBlank : false,
                            maxLength : 255,
                            emptyText : MShop.I18n.dt('client/extjs', 'Internal name (required)')
                        }, {
                            xtype : 'datefield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Start date'),
                            name : 'coupon.datestart',
                            format : 'Y-m-d H:i:s',
                            emptyText : MShop.I18n.dt('client/extjs', 'YYYY-MM-DD hh:mm:ss (optional)')
                        }, {
                            xtype : 'datefield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'End date'),
                            name : 'coupon.dateend',
                            format : 'Y-m-d H:i:s',
                            emptyText : MShop.I18n.dt('client/extjs', 'YYYY-MM-DD hh:mm:ss (optional)')
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'coupon.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'coupon.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'coupon.editor'
                        }]
                    }]
                }, {
                    xtype : 'MShop.panel.configui',
                    layout : 'fit',
                    flex : 1,
                    data : (this.record ? this.record.get('coupon.config') : {})
                }]
            }]
        }];

        this.store.on('beforesave', this.onBeforeSave, this);

        MShop.panel.coupon.ItemUi.superclass.initComponent.call(this);
    },


    afterRender : function() {
        var label = this.record ? this.record.data['coupon.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Coupon item panel title with coupon label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Coupon: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.coupon.ItemUi.superclass.afterRender.apply(this, arguments);
    },


    onBeforeSave : function(store, data) {
        MShop.panel.coupon.ItemUi.superclass.onBeforeSave.call(this, store, data, {
            configname : 'coupon.config'
        });
    }
});

Ext.reg('MShop.panel.coupon.itemui', MShop.panel.coupon.ItemUi);
