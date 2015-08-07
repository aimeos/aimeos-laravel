/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.media');

MShop.panel.media.ItemUi = Ext.extend(MShop.panel.AbstractListItemUi, {
    siteidProperty : 'media.siteid',

    initComponent : function() {

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.media.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.media.ItemUi.BasicPanel',
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
                            name : 'media.id'
                        }, {
                            xtype : 'MShop.elements.status.combo',
                            name : 'media.status'
                        }, {
                            xtype : 'combo',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Type'),
                            name : 'media.typeid',
                            mode : 'local',
                            store : this.listUI.itemTypeStore,
                            displayField : 'media.type.label',
                            valueField : 'media.type.id',
                            forceSelection : true,
                            triggerAction : 'all',
                            allowBlank : false,
                            typeAhead : true,
                            listeners : {
                                'render' : {
                                    fn : function() {
                                        var record, index = this.store.find('media.type.code', 'default');
                                        if((record = this.store.getAt(index))) {
                                            this.setValue(record.id);
                                        }
                                    }
                                }
                            }
                        }, {
                            xtype : 'MShop.elements.language.combo',
                            name : 'media.languageid'
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Mimetype'),
                            name : 'media.mimetype'
                        }, {
                            xtype : 'textfield',
                            name : 'media.label',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            allowBlank : false,
                            emptyText : MShop.I18n.dt('client/extjs', 'Internal name (required)')
                        }, {
                            xtype : 'textfield',
                            name : 'media.preview',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Preview URL')
                        }, {
                            xtype : 'textfield',
                            name : 'media.url',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'File URL')
                        }, {
                            // NOTE: this is not used as a field, more like a
                            // component which works on the whole record
                            xtype : 'MShop.panel.media.mediafield',
                            name : 'media.preview',
                            value : (this.record ? this.record.get('media.preview') : ''),
                            width : 360,
                            height : 360
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'media.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'media.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'media.editor'
                        }]
                    }]
                }]
            }]
        }];

        MShop.panel.media.ItemUi.superclass.initComponent.call(this);
    },


    afterRender : function() {
        var label = this.record ? this.record.data['media.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Media item panel title with media label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Media: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.media.ItemUi.superclass.afterRender.apply(this, arguments);
    }
});

Ext.reg('MShop.panel.media.itemui', MShop.panel.media.ItemUi);
