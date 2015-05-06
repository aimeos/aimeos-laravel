/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://www.arcavias.com/license
 * @author Michael Spahn <m.spahn@metaways.de>
 */

Ext.ns('MShop.panel');

MShop.panel.AbstractTypeItemUi = Ext.extend(MShop.panel.AbstractItemUi, {
    /**
     * Domain to configure fields E.g. attribute.type
     */
    typeDomain : null,

    initComponent : function() {
        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);
        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.' + this.typeDomain + '.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                xtype : 'panel',
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                border : false,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretch'
                },
                itemId : 'MShop.panel.' + this.typeDomain + '.ItemUi.BasicPanel',
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
                            anchor : '100%',
                            readOnly : this.fieldsReadOnly
                        },
                        items : [{
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'ID'),
                            name : this.typeDomain + '.id'
                        }, {
                            xtype : 'MShop.elements.status.combo',
                            name : this.typeDomain + '.status',
                            allowBlank : false
                        }, {
                            xtype : 'MShop.elements.domain.combo',
                            name : this.typeDomain + '.domain',
                            allowBlank : false
                        }, {
                            xtype : 'textfield',
                            name : this.typeDomain + '.code',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Code'),
                            allowBlank : false,
                            maxLength : 32,
                            regex : /^[^ \v\t\r\n\f]+$/,
                            emptyText : MShop.I18n.dt('client/extjs', 'Unique code (required)')
                        }, {
                            xtype : 'textfield',
                            name : this.typeDomain + '.label',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            allowBlank : false,
                            maxLength : 255,
                            emptyText : MShop.I18n.dt('client/extjs', 'Internal name (required)')
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : this.typeDomain + '.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : this.typeDomain + '.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : this.typeDomain + '.editor'
                        }]
                    }]
                }]
            }]
        }];

        MShop.panel.AbstractTypeItemUi.superclass.initComponent.call(this);
    }
});

Ext.reg('MShop.panel.abstracttypeitemui', MShop.panel.AbstractTypeItemUi);
