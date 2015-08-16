/*!
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos.org, 2015
 */


Ext.ns('MShop.panel.customer.group');

MShop.panel.customer.group.ItemUi = Ext.extend(MShop.panel.AbstractListItemUi, {

    siteidProperty : 'customer.group.siteid',


    initComponent : function() {

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.customer.group.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                xtype : 'panel',
                layout : 'fit',
                border : false,
                itemId : 'MShop.panel.customer.group.ItemUi.BasicPanel',
                plugins : ['ux.itemregistry'],
                defaults : {
                    bodyCssClass : this.readOnlyClass
                },
                items : [{
                    title : MShop.I18n.dt('client/extjs', 'Details'),
                    xtype : 'form',
                    ref : '../../mainForm',
                    autoScroll : true,
                    items : [{
                        xtype : 'fieldset',
                        labelAlign : 'top',
                        border : false,
                        defaults : {
                            readOnly : this.fieldsReadOnly,
                            anchor : '-25'
                        },
                        items : [{
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'ID'),
                            name : 'customer.group.id'
                        }, {
                            xtype : 'textfield',
                            name : 'customer.group.code',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Code'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Unique code (required)'),
                            maxLength : 32
                        }, {
                            xtype : 'textfield',
                            name : 'customer.group.label',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Label'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Group label (required)'),
                            maxLength : 255
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'customer.group.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'customer.group.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'customer.group.editor'
                        }]
                    }]
                }]
            }]
        }];

        MShop.panel.customer.group.ItemUi.superclass.initComponent.call(this);
    },


    afterRender : function() {

        var label = this.record ? this.record.data['customer.group.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Customer group item panel title with customer name ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Customer group: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.customer.group.ItemUi.superclass.afterRender.apply(this, arguments);
    }

});

Ext.reg('MShop.panel.customer.group.itemui', MShop.panel.customer.group.ItemUi);
