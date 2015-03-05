/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */


Ext.ns('MShop.panel.locale');

MShop.panel.locale.ItemUi = Ext.extend(MShop.panel.AbstractListItemUi, {

    recordName : 'Locale',
    idProperty : 'locale.id',
    siteidProperty : 'locale.siteid',


    initComponent : function() {

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.locale.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.locale.ItemUi.BasicPanel',
                plugins : ['ux.itemregistry'],
                defaults : {
                    bodyCssClass : this.readOnlyClass
                },
                items : [{
                    xtype : 'form',
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
                            name : 'locale.id'
                        }, {
                            xtype : 'MShop.elements.status.combo',
                            name : 'locale.status'
                        }, {
                            xtype : 'MShop.elements.language.combo',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Language'),
                            name : 'locale.languageid',
                            allowBlank : false,
                            emptyText : MShop.I18n.dt('client/extjs', 'Language (required)')
                        }, {
                            xtype : 'MShop.elements.currency.combo',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Currency'),
                            name : 'locale.currencyid',
                            allowBlank : false,
                            emptyText : MShop.I18n.dt('client/extjs', 'Currency (required)')
                        }, {
                            xtype : 'numberfield',
                            name : 'locale.position',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Position'),
                            allowNegative : false,
                            allowDecimals : false,
                            allowBlank : false,
                            value : 0
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'locale.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'locale.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'locale.editor'
                        }]
                    }]
                }]
            }]
        }];

        MShop.panel.locale.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        //#: Locale item panel title with site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Locale item details ({1})');
        this.setTitle(String.format(string, MShop.config.site["locale.site.label"]));

        MShop.panel.product.ItemUi.superclass.afterRender.apply(this, arguments);
    }
});

Ext.reg('MShop.panel.locale.itemui', MShop.panel.locale.ItemUi);
