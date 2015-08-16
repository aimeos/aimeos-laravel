/*!
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos.org, 2015
 */


Ext.ns('MShop.panel.customer.address');

MShop.panel.customer.address.ItemUi = Ext.extend(MShop.panel.AbstractListItemUi, {

    siteidProperty : 'customer.address.siteid',


    initComponent : function() {

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.customer.address.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                title : MShop.I18n.dt('client/extjs', 'Basic'),
                xtype : 'panel',
                layout : 'fit',
                border : false,
                itemId : 'MShop.panel.customer.address.ItemUi.BasicPanel',
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
                            xtype : 'textfield',
                            name : 'customer.address.company',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Company'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Company name'),
                            maxLength : 100
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.vatid',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Vat ID'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Vat ID, e.g. "GB999999999"'),
                            maxLength : 32
                        }, {
                            xtype : 'MShop.elements.salutation.combo',
                            name : 'customer.address.salutation'
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.title',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Title'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Honorary title'),
                            maxLength : 64
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.firstname',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'First name'),
                            emptyText : MShop.I18n.dt('client/extjs', 'First name'),
                            maxLength : 64
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.lastname',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last name'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Last name (required)'),
                            allowBlank : false,
                            maxLength : 64
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.address1',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Address 1'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Street (required)'),
                            allowBlank : false,
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.address2',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Address 2'),
                            emptyText : MShop.I18n.dt('client/extjs', 'House number'),
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.address3',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Address 3'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Additional information, e.g. flat number'),
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.postal',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Postal code'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Postal code'),
                            maxLength : 16
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.city',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'City'),
                            emptyText : MShop.I18n.dt('client/extjs', 'City name (required)'),
                            allowBlank : false,
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.state',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'State'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Country state, e.g. "NY"'),
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.countryid',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Country code'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Two letter country code, e.g. "US" (required)'),
                            regex : /[A-Za-z]{2}/,
                            allowBlank : false,
                            maxLength : 2
                        }, {
                            xtype : 'MShop.elements.language.combo',
                            name : 'customer.address.languageid'
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.telephone',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Telephone'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Telephone number, e.g. +155512345'),
                            maxLength : 32
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.telefax',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Telefax'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Facsimile number, e.g. +155512345'),
                            maxLength : 32
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.email',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'E-Mail'),
                            emptyText : MShop.I18n.dt('client/extjs', 'E-Mail, e.g. me@example.com (required)'),
                            allowBlank : false,
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'customer.address.website',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Website'),
                            emptyText : MShop.I18n.dt('client/extjs', 'Web site, e.g. www.example.com'),
                            maxLength : 255
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Created'),
                            name : 'customer.address.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Last modified'),
                            name : 'customer.address.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('client/extjs', 'Editor'),
                            name : 'customer.address.editor'
                        }]
                    }]
                }]
            }]
        }];

        this.store.on('beforesave', this.onBeforeSave, this);

        MShop.panel.customer.address.ItemUi.superclass.initComponent.call(this);
    },


    afterRender : function() {

        var label = this.record ? this.record.data['customer.address.lastname'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Customer address item panel title with customer name ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Customer address: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.customer.address.ItemUi.superclass.afterRender.apply(this, arguments);
    },


    onBeforeSave : function(store, data) {

        if(data.create && data.create[0]) {
            data.create[0].data['customer.address.refid'] = this.listUI.ParentItemUi.record.id;
        }
    }

});

Ext.reg('MShop.panel.customer.address.itemui', MShop.panel.customer.address.ItemUi);
