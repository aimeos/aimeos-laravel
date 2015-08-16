/*!
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos.org, 2015
 */

Ext.ns('MShop.panel.customer');

MShop.panel.customer.ListUiSmall = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Customer',
    idProperty : 'customer.id',
    siteidProperty : 'customer.siteid',
    itemUiXType : 'MShop.panel.customer.itemui',

    autoExpandColumn : 'customer-list-label',

    filterConfig : {
        filters : [{
            dataIndex : 'customer.code',
            operator : '=~',
            value : ''
        }]
    },

    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Available customers');

        MShop.panel.customer.ListUiSmall.superclass.initComponent.call(this);
    },

    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'customer.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            width : 50,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'customer.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 70,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'customer.code',
            header : MShop.I18n.dt('client/extjs', 'User name'),
            sortable : true,
            width : 100
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'customer.label',
            header : MShop.I18n.dt('client/extjs', 'Full name'),
            sortable : true,
            id : 'customer-list-label'
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'customer.password',
            header : MShop.I18n.dt('client/extjs', 'Password'),
            sortable : false,
            width : 100,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'customer.birthday',
            header : MShop.I18n.dt('client/extjs', 'Birthday'),
            sortable : false,
            width : 100,
            format : 'Y-m-d',
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'customer.dateverified',
            header : MShop.I18n.dt('client/extjs', 'Verification date'),
            sortable : false,
            width : 100,
            format : 'Y-m-d',
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'customer.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : false,
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'customer.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : false,
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'customer.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : false,
            width : 130,
            hidden : true
        }];
    }

});

Ext.reg('MShop.panel.customer.listuismall', MShop.panel.customer.ListUiSmall);
