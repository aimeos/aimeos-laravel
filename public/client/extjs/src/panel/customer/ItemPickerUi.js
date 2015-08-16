/*!
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos.org, 2015
 */


Ext.ns('MShop.panel.customer');

MShop.panel.customer.ItemPickerUi = Ext.extend(MShop.panel.AbstractListItemPickerUi, {

    title : MShop.I18n.dt('client/extjs', 'Customer'),

    initComponent : function() {

        Ext.apply(this.itemConfig, {
            title : MShop.I18n.dt('client/extjs', 'Associated customers'),
            xtype : 'MShop.panel.listitemlistui',
            domain : 'customer',
            getAdditionalColumns : this.getAdditionalColumns.createDelegate(this)
        });

        Ext.apply(this.listConfig, {
            title : MShop.I18n.dt('client/extjs', 'Available customers'),
            xtype : 'MShop.panel.customer.listuismall'
        });

        MShop.panel.customer.ItemPickerUi.superclass.initComponent.call(this);
    },


    getAdditionalColumns : function() {

        var conf = this.itemConfig;
        this.listTypeStore = MShop.GlobalStoreMgr.get(conf.listTypeControllerName, conf.domain);

        return [{
            xtype : 'gridcolumn',
            dataIndex : conf.listNamePrefix + 'typeid',
            header : MShop.I18n.dt('client/extjs', 'List type'),
            id : 'listtype',
            width : 70,
            renderer : this.typeColumnRenderer.createDelegate(this,
                [this.listTypeStore, conf.listTypeLabelProperty], true)
        }, {
            xtype : 'gridcolumn',
            dataIndex : conf.listNamePrefix + 'refid',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            id : 'refstatus',
            width : 50,
            renderer : this.refStatusColumnRenderer.createDelegate(this, ['customer.status'], true)
        }, {
            xtype : 'gridcolumn',
            dataIndex : conf.listNamePrefix + 'refid',
            header : MShop.I18n.dt('client/extjs', 'User name'),
            id : 'refcode',
            width : 150,
            renderer : this.refColumnRenderer.createDelegate(this, ['customer.code'], true)
        }, {
            xtype : 'gridcolumn',
            dataIndex : conf.listNamePrefix + 'refid',
            header : MShop.I18n.dt('client/extjs', 'Full name'),
            id : 'refcontent',
            renderer : this.refColumnRenderer.createDelegate(this, ['customer.label'], true)
        }];
    }
});

Ext.reg('MShop.panel.customer.itempickerui', MShop.panel.customer.ItemPickerUi);
