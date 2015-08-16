/*!
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos.org, 2015
 */

Ext.ns('MShop.panel.customer.group');

MShop.panel.customer.group.ListUiSmall = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Customer_Group',
    idProperty : 'customer.group.id',
    siteidProperty : 'customer.group.siteid',
    itemUiXType : 'MShop.panel.customer.group.itemui',

    autoExpandColumn : 'customer-group-label',

    filterConfig : {
        filters : [{
            dataIndex : 'customer.group.label',
            operator : '=~',
            value : ''
        }]
    },

    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Available customer groups');

        MShop.panel.customer.group.ListUiSmall.superclass.initComponent.call(this);
    },

    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'customer.group.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'customer.group.code',
            header : MShop.I18n.dt('client/extjs', 'Code'),
            width : 100
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'customer.group.label',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            id : 'customer-group-label'
        }, {
            xtype : 'datecolumn',
            dataIndex : 'customer.group.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'customer.group.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'customer.group.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            width : 130,
            hidden : true
        }];
    }
});

Ext.reg('MShop.panel.customer.group.listuismall', MShop.panel.customer.group.ListUiSmall);
