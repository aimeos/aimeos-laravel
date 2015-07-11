/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.order.base.product');

MShop.panel.order.base.product.ListUi = Ext.extend(MShop.panel.AbstractListUi, {

    title : MShop.I18n.dt('client/extjs', 'Products'),
    recordName : 'Order_Base_Product',
    idProperty : 'order.base.product.id',
    siteidProperty : 'order.base.product.siteid',
    itemUiXType : 'MShop.panel.order.product.itemui',
    autoExpandColumn : 'order-base-product-Label',

    sortInfo : {
        field : 'order.base.product.position',
        direction : 'ASC'
    },

    filterConfig : {
        filters : [{
            dataIndex : 'order.base.product.prodcode',
            operator : '=~',
            value : ''
        }]
    },


    initToolbar : function() {},


    afterRender : function() {
        MShop.panel.order.base.product.ListUi.superclass.afterRender.apply(this, arguments);

        this.ParentItemUi = this.findParentBy(function(c) {
            return c.isXType(MShop.panel.AbstractItemUi, false);
        });
    },


    onBeforeLoad : function(store, options) {
        MShop.panel.order.base.product.ListUi.superclass.onBeforeLoad.apply(this, arguments);

        options.params = options.params || {};
        options.params.condition = {
            '&&' : [{
                '==' : {
                    'order.base.product.baseid' : this.ParentItemUi.record.data['order.baseid']
                }
            }]
        };
    },


    onGridContextMenu : function() {},


    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.baseid',
            header : MShop.I18n.dt('client/extjs', 'Base ID'),
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.productid',
            header : MShop.I18n.dt('client/extjs', 'Product ID'),
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.orderproductid',
            header : MShop.I18n.dt('client/extjs', 'Order product ID'),
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.type',
            header : MShop.I18n.dt('client/extjs', 'Type')
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.prodcode',
            header : MShop.I18n.dt('client/extjs', 'Code')
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.name',
            header : MShop.I18n.dt('client/extjs', 'Name'),
            id : 'order-base-product-Label'
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.quantity',
            header : MShop.I18n.dt('client/extjs', 'Quantity')
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.price',
            header : MShop.I18n.dt('client/extjs', 'Price')
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.costs',
            header : MShop.I18n.dt('client/extjs', 'Costs')
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.rebate',
            header : MShop.I18n.dt('client/extjs', 'Rebate')
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.taxrate',
            header : MShop.I18n.dt('client/extjs', 'Tax rate')
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            renderer : MShop.elements.deliverystatus.renderer
        }, {
            xtype : 'datecolumn',
            dataIndex : 'order.base.product.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'order.base.product.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 130,
            hidden : true
        }];
    }
});


Ext.reg('MShop.panel.order.base.product.listui', MShop.panel.order.base.product.ListUi);

//hook order base product into the order ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.order.ItemUi', 'MShop.panel.order.base.product.ListUi',
    MShop.panel.order.base.product.ListUi, 20);
