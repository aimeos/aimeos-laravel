/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel.product.tag');

MShop.panel.product.tag.ItemUi = Ext.extend(MShop.panel.AbstractItemUi, {
    siteidProperty : 'product.tag.siteid',

    initComponent : function() {

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.product.tag.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.product.tag.ItemUi.BasicPanel',
                plugins : ['ux.itemregistry'],
                defaults : {
                    bodyCssClass : this.readOnlyClass
                },
                items : [{
                    title : MShop.I18n.dt('client/extjs', 'Details'),
                    xtype : 'form',
                    border : false,
                    flex : 1,
                    ref : '../../mainForm',
                    autoScroll : true,
                    items : [{
                        xtype : 'fieldset',
                        style : 'padding-right: 25px;',
                        border : false,
                        flex : 1,
                        labelAlign : 'top',
                        defaults : {
                            readOnly : this.fieldsReadOnly,
                            anchor : '100%'
                        },
                        items : [{
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'ID'),
                            name : 'product.tag.id'
                        }, {
                            xtype : 'combo',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Type'),
                            name : 'product.tag.typeid',
                            mode : 'local',
                            store : this.listUI.typeStore,
                            displayField : 'product.tag.type.label',
                            valueField : 'product.tag.type.id',
                            forceSelection : true,
                            triggerAction : 'all',
                            allowBlank : false,
                            typeAhead : true
                        }, {
                            xtype : 'MShop.elements.language.combo',
                            name : 'product.tag.languageid'
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            name : 'product.tag.label',
                            allowBlank : false,
                            emptyText : MShop.I18n.dt('client/extjs', 'Tag value (required)')
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'product.tag.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'product.tag.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'product.tag.editor'
                        }]
                    }]
                }]
            }]
        }];

        MShop.panel.product.tag.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['product.tag.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Product tag item panel title with product label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Product tag: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.product.tag.ItemUi.superclass.afterRender.apply(this, arguments);
    }
});

Ext.reg('MShop.panel.product.tag.itemui', MShop.panel.product.tag.ItemUi);
