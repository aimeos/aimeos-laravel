/*!
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos.org, 2015
 */


Ext.ns('MShop.panel.customer.group');

MShop.panel.customer.group.ItemPickerUi = Ext.extend(MShop.panel.AbstractListItemPickerUi, {

    title : MShop.I18n.dt('client/extjs', 'Group'),

    initComponent : function() {

        Ext.apply(this.itemConfig, {
            title : MShop.I18n.dt('client/extjs', 'Associated customer groups'),
            xtype : 'MShop.panel.listitemlistui',
            domain : 'customer/group',
            getAdditionalColumns : this.getAdditionalColumns.createDelegate(this)
        });

        Ext.apply(this.listConfig, {
            title : MShop.I18n.dt('client/extjs', 'Available customer groups'),
            xtype : 'MShop.panel.customer.group.listuismall'
        });

        MShop.panel.customer.group.ItemPickerUi.superclass.initComponent.call(this);
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
            header : MShop.I18n.dt('client/extjs', 'Code'),
            id : 'refcode',
            renderer : this.refColumnRenderer.createDelegate(this, ['customer.group.code'], true)
        }, {
            xtype : 'gridcolumn',
            dataIndex : conf.listNamePrefix + 'refid',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            id : 'refcontent',
            renderer : this.refColumnRenderer.createDelegate(this, ['customer.group.label'], true)
        }];
    }
});

Ext.reg('MShop.panel.customer.group.itempickerui', MShop.panel.customer.group.ItemPickerUi);
