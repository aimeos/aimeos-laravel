/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel.text');

MShop.panel.text.ItemUi = Ext.extend(MShop.panel.AbstractListItemUi, {
    siteidProperty : 'text.siteid',

    initComponent : function() {

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.text.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.text.ItemUi.BasicPanel',
                plugins : ['ux.itemregistry'],
                defaults : {
                    bodyCssClass : this.readOnlyClass
                },
                items : [{
                    title : MShop.I18n.dt('client/extjs', 'Details'),
                    xtype : 'form',
                    border : false,
                    layout : 'fit',
                    flex : 1,
                    ref : '../../mainForm',
                    items : [{
                        xtype : 'fieldset',
                        style : 'padding-right: 25px;',
                        border : false,
                        flex : 1,
                        autoScroll : true,
                        labelAlign : 'top',
                        defaults : {
                            readOnly : this.fieldsReadOnly,
                            anchor : '100%'
                        },
                        items : [{
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'ID'),
                            name : 'text.id'
                        }, {
                            xtype : 'MShop.elements.status.combo',
                            name : 'text.status'
                        }, {
                            xtype : 'combo',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Type'),
                            name : 'text.typeid',
                            mode : 'local',
                            store : this.listUI.ItemTypeStore,
                            displayField : 'text.type.label',
                            valueField : 'text.type.id',
                            forceSelection : true,
                            triggerAction : 'all',
                            allowBlank : false,
                            typeAhead : true
                        }, {
                            xtype : 'MShop.elements.language.combo',
                            name : 'text.languageid'
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            name : 'text.label',
                            allowBlank : true,
                            maxLength : 255,
                            emptyText : MShop.I18n.dt('client/extjs', 'Internal name')
                        }, {
                            xtype : MShop.Config.get('client/extjs/common/editor', 'htmleditor'),
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Content'),
                            name : 'text.content',
                            enableFont : false
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'text.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'text.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'text.editor'
                        }]
                    }]
                }]
            }]
        }];

        MShop.panel.text.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['text.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Text item panel title with text label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Text: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.text.ItemUi.superclass.afterRender.apply(this, arguments);
    }
});

Ext.reg('MShop.panel.text.itemui', MShop.panel.text.ItemUi);
