/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */


Ext.ns('MShop.panel.catalog');

/**
 * move some parts to AbstractTreeItemUI and parametresize
 */
MShop.panel.catalog.ItemUi = Ext.extend(MShop.panel.AbstractTreeItemUi, {
    idProperty : 'id',
    siteidProperty : 'catalog.siteid',

    initComponent : function() {

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.catalog.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.catalog.ItemUi.BasicPanel',
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
                            name : 'id'
                        }, {
                            xtype : 'MShop.elements.status.combo',
                            name : 'status'
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Code'),
                            name : 'code',
                            allowBlank : false,
                            maxLength : 32,
                            regex : /^[^ \v\t\r\n\f]+$/,
                            emptyText : MShop.I18n.dt('client/extjs', 'Unique code (required)')
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            name : 'label',
                            allowBlank : false,
                            emptyText : MShop.I18n.dt('client/extjs', 'Internal name (required)')
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'catalog.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'catalog.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'catalog.editor'
                        }]
                    }]
                }, {
                    xtype : 'MShop.panel.configui',
                    layout : 'fit',
                    flex : 1,
                    data : (this.record ? this.record.get('catalog.config') : {})
                }]
            }]
        }];

        this.store.on('beforesave', this.onBeforeSave, this);

        MShop.panel.catalog.ItemUi.superclass.initComponent.call(this);
    },


    afterRender : function() {
        var label = this.record ? this.record.data['label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Catalog item panel title with catalog label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Catalog: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.catalog.ItemUi.superclass.afterRender.apply(this, arguments);
    },


    onBeforeSave : function(store, data) {
        MShop.panel.catalog.ItemUi.superclass.onBeforeSave.call(this, store, data, {
            configname : 'catalog.config'
        });
    },


    onSaveItem : function() {
        if(!this.mainForm.getForm().isValid() && this.fireEvent('validate', this) !== false) {
            Ext.Msg.alert(MShop.I18n.dt('client/extjs', 'Invalid data'), MShop.I18n.dt('client/extjs',
                'Please recheck your data'));
            return;
        }

        this.saveMask.show();
        this.isSaveing = true;

        this.record.dirty = true;

        if(this.fireEvent('beforesave', this, this.record) === false) {
            this.isSaveing = false;
            this.saveMask.hide();
        }

        this.record.beginEdit();
        this.record.set('catalog.label', this.mainForm.getForm().findField('label').getValue());
        this.record.set('catalog.status', this.mainForm.getForm().findField('status').getValue());
        this.record.set('catalog.code', this.mainForm.getForm().findField('code').getValue());
        this.record.endEdit();

        if(this.action == 'add' || this.action == 'copy') {
            this.store.add(this.record);
        }

        if(!this.store.autoSave) {
            this.onAfterSave();
        }
    }
});

Ext.reg('MShop.panel.catalog.itemui', MShop.panel.catalog.ItemUi);
