/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.locale.currency');


/**
 * @todo refactor some of these overloads to his abstracts
 */
MShop.panel.locale.currency.ItemUi = Ext.extend(MShop.panel.AbstractListItemUi, {

    recordName : 'Locale_Currency',
    idProperty : 'locale.currency.id',
    siteidProperty : 'locale.currency.siteid',

    initComponent : function() {

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.locale.currency.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.locale.currency.ItemUi.BasicPanel',
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
                            name : 'locale.currency.id'
                        }, {
                            xtype : 'MShop.elements.status.combo',
                            name : 'locale.currency.status'
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Code'),
                            name : 'locale.currency.code',
                            allowBlank : false,
                            maxLength : 3,
                            regex : /[a-zA-Z]+/,
                            emptyText : MShop.I18n.dt('client/extjs', 'Unique code (required)')
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            name : 'locale.currency.label',
                            allowBlank : false,
                            emptyText : MShop.I18n.dt('client/extjs', 'Internal name (required)')
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'locale.currency.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'locale.currency.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'locale.currency.editor'
                        }]
                    }]
                }]
            }]
        }];

        MShop.panel.locale.currency.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['locale.currency.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Locale currency item panel title with currency label ({0}) and currency code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Locale currency: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.locale.currency.ItemUi.superclass.afterRender.apply(this, arguments);
    }

});

Ext.reg('MShop.panel.locale.currency.itemui', MShop.panel.locale.currency.ItemUi);
