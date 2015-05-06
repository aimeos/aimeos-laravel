/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://www.arcavias.com/en/license
 */


Ext.ns('MShop.panel.coupon.code');

MShop.panel.coupon.code.ItemUi = Ext.extend(MShop.panel.AbstractItemUi, {

    siteidProperty : 'coupon.code.siteid',


    initComponent : function() {

        this.title = MShop.I18n.dt('client/extjs', 'Coupon code item details');

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.coupon.code.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.coupon.code.ItemUi.BasicPanel',
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
                            anchor : '100%'
                        },
                        items : [{
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'ID'),
                            name : 'coupon.code.id'
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Code'),
                            name : 'coupon.code.code',
                            allowBlank : false,
                            maxLength : 32,
                            regex : /^[^ \v\t\r\n\f]+$/,
                            emptyText : MShop.I18n.dt('client/extjs', 'Unique code (required)')
                        }, {
                            xtype : 'numberfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Count'),
                            name : 'coupon.code.count',
                            allowDecimals : false,
                            allowBlank : false,
                            value : 1
                        }, {
                            xtype : 'datefield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Start date'),
                            name : 'coupon.code.datestart',
                            format : 'Y-m-d H:i:s',
                            emptyText : MShop.I18n.dt('client/extjs', 'YYYY-MM-DD hh:mm:ss (optional)')
                        }, {
                            xtype : 'datefield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'End date'),
                            name : 'coupon.code.dateend',
                            format : 'Y-m-d H:i:s',
                            emptyText : MShop.I18n.dt('client/extjs', 'YYYY-MM-DD hh:mm:ss (optional)')
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'coupon.code.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'coupon.code.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'coupon.code.editor'
                        }]
                    }]
                }]
            }]
        }];

        this.store.on('beforesave', this.onBeforeSave, this);

        MShop.panel.coupon.code.ItemUi.superclass.initComponent.call(this);
    },


    afterRender : function() {

        var label = this.record ? this.record.data['coupon.code.code'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Coupon code item panel title with coupon code ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Coupon code: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.coupon.code.ItemUi.superclass.afterRender.apply(this, arguments);
    },


    onBeforeSave : function(store, data) {

        if(data.create && data.create[0]) {
            data.create[0].data['coupon.code.couponid'] = this.listUI.ParentItemUi.record.id;
        }
    }

});

Ext.reg('MShop.panel.coupon.code.itemui', MShop.panel.coupon.code.ItemUi);
