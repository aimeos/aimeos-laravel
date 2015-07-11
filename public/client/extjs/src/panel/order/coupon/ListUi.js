/*!
 * Copyright (c) Metaways Infosystems GmbH, 2013
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.order.base.coupon');

MShop.panel.order.base.coupon.ListUi = Ext.extend(MShop.panel.AbstractListUi, {

    title : MShop.I18n.dt('client/extjs', 'Coupons'),
    recordName : 'Order_Base_Coupon',
    idProperty : 'order.base.coupon.id',
    siteidProperty : 'order.base.coupon.siteid',
    itemUiXType : 'MShop.panel.order.product.itemui',
    autoExpandColumn : 'order-base-coupon-name',

    sortInfo : {
        field : 'order.base.coupon.code',
        direction : 'ASC'
    },

    filterConfig : {
        filters : [{
            dataIndex : 'order.base.coupon.code',
            operator : 'contains',
            value : ''
        }]
    },


    initToolbar : function() {},


    afterRender : function() {
        MShop.panel.order.base.coupon.ListUi.superclass.afterRender.apply(this, arguments);

        this.ParentItemUi = this.findParentBy(function(c) {
            return c.isXType(MShop.panel.AbstractItemUi, false);
        });
    },


    onBeforeLoad : function(store, options) {
        MShop.panel.order.base.coupon.ListUi.superclass.onBeforeLoad.apply(this, arguments);

        options.params = options.params || {};
        options.params.condition = {
            '&&' : [{
                '==' : {
                    'order.base.coupon.baseid' : this.ParentItemUi.record.data['order.baseid']
                }
            }]
        };
    },


    onGridContextMenu : function() {},


    onOpenEditWindow : function(action) {
        var selectedData = this.grid.getSelectionModel().getSelected();

        if(selectedData.data['order.base.coupon.productid'] !== null) {

            var orderProductStore = MShop.GlobalStoreMgr.get('Order_Base_Product');
            var orderProduct = orderProductStore.getById(selectedData.data['order.base.coupon.productid']);

            var itemUi = Ext.ComponentMgr.create({
                xtype : this.itemUiXType,
                domain : this.domain,
                record : orderProduct,
                store : orderProductStore,
                listUI : MShop.panel.order.base.product.ListUi,
                action : action
            });

            itemUi.show();
        }
    },


    getColumns : function() {
        this.productStore = MShop.GlobalStoreMgr.get('Order_Base_Product');

        return [
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.id',
                header : MShop.I18n.dt('client/extjs', 'ID'),
                width : 50,
                hidden : true
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.baseid',
                header : MShop.I18n.dt('client/extjs', 'Base ID'),
                width : 50,
                hidden : true
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.code',
                header : MShop.I18n.dt('client/extjs', 'Coupon code')
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.productid',
                header : MShop.I18n.dt('client/extjs', 'Product ID'),
                width : 50,
                hidden : true
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.productid',
                header : MShop.I18n.dt('client/extjs', 'Product code'),
                renderer : this.typeColumnRenderer.createDelegate(this, [
                    this.productStore,
                    "order.base.product.prodcode"], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.productid',
                header : MShop.I18n.dt('client/extjs', 'Product name'),
                renderer : this.typeColumnRenderer.createDelegate(this, [this.productStore, "order.base.product.name"],
                    true),
                id : 'order-base-coupon-name'
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.productid',
                header : MShop.I18n.dt('client/extjs', 'Product quantity'),
                renderer : this.typeColumnRenderer.createDelegate(this, [
                    this.productStore,
                    "order.base.product.quantity"], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.productid',
                header : MShop.I18n.dt('client/extjs', 'Product price'),
                renderer : this.typeColumnRenderer.createDelegate(this,
                    [this.productStore, "order.base.product.price"], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.productid',
                header : MShop.I18n.dt('client/extjs', 'Product costs'),
                renderer : this.typeColumnRenderer.createDelegate(this,
                    [this.productStore, "order.base.product.costs"], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.productid',
                header : MShop.I18n.dt('client/extjs', 'Product rebate'),
                renderer : this.typeColumnRenderer.createDelegate(this,
                    [this.productStore, "order.base.product.rebate"], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.productid',
                header : MShop.I18n.dt('client/extjs', 'Product tax rate'),
                renderer : this.typeColumnRenderer.createDelegate(this, [
                    this.productStore,
                    "order.base.product.taxrate"], true)
            },
            {
                xtype : 'datecolumn',
                dataIndex : 'order.base.coupon.ctime',
                header : MShop.I18n.dt('client/extjs', 'Created'),
                sortable : true,
                width : 130,
                format : 'Y-m-d H:i:s',
                editable : false,
                hidden : true
            },
            {
                xtype : 'datecolumn',
                dataIndex : 'order.base.coupon.mtime',
                header : MShop.I18n.dt('client/extjs', 'Last modified'),
                sortable : true,
                width : 130,
                format : 'Y-m-d H:i:s',
                editable : false,
                hidden : true
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'order.base.coupon.editor',
                header : MShop.I18n.dt('client/extjs', 'Editor'),
                sortable : true,
                width : 130,
                editable : false,
                hidden : true
            }];
    }
});


Ext.reg('MShop.panel.order.base.coupon.listui', MShop.panel.order.base.coupon.ListUi);

//hook order base product into the order ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.order.ItemUi', 'MShop.panel.order.base.coupon.ListUi',
    MShop.panel.order.base.coupon.ListUi, 50);
