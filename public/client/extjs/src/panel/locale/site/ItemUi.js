/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.locale.site');


/**
 * @todo refactor some of these overloads to his abstracts
 */
MShop.panel.locale.site.ItemUi = Ext.extend(MShop.panel.AbstractListItemUi, {

    recordName : 'Locale_Site',
    idProperty : 'locale.site.id',
    siteidProperty : 'locale.site.id',

    initComponent : function() {

        MShop.panel.AbstractListItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.locale.site.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.locale.site.ItemUi.BasicPanel',
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
                            name : 'locale.site.id'
                        }, {
                            xtype : 'MShop.elements.status.combo',
                            name : 'locale.site.status'
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Code'),
                            name : 'locale.site.code',
                            allowBlank : false,
                            maxLength : 32,
                            regex : /^[^ \v\t\r\n\f]+$/,
                            emptyText : MShop.I18n.dt('client/extjs', 'Unique code (required)')
                        }, {
                            xtype : 'textfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            name : 'locale.site.label',
                            allowBlank : false,
                            emptyText : MShop.I18n.dt('client/extjs', 'Internal name (required)')
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'locale.site.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'locale.site.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'locale.site.editor'
                        }]
                    }]
                }, {
                    xtype : 'MShop.panel.configui',
                    layout : 'fit',
                    flex : 1,
                    data : (this.record ? this.record.get('locale.site.config') : {})
                }]
            }]
        }];

        this.store.on('beforesave', this.onBeforeSave, this);

        MShop.panel.locale.site.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['locale.site.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Locale site item panel title with site label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Locale site: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.locale.site.ItemUi.superclass.afterRender.apply(this, arguments);
    },

    onBeforeSave : function(store, data) {
        MShop.panel.locale.site.ItemUi.superclass.onBeforeSave.call(this, store, data, {
            configname : 'locale.site.config'
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
        this.record.set('locale.site.label', this.mainForm.getForm().findField('locale.site.label').getValue());
        this.record.set('locale.site.status', this.mainForm.getForm().findField('locale.site.status').getValue());
        this.record.set('locale.site.code', this.mainForm.getForm().findField('locale.site.code').getValue());
        this.record.endEdit();

        if(this.action == 'add' || this.action == 'copy') {
            this.store.add(this.record);
        }

        if(!this.store.autoSave) {
            this.onAfterSave();
        }
    }
});


Ext.reg('MShop.panel.locale.site.itemui', MShop.panel.locale.site.ItemUi);
