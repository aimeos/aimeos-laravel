/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.order.base.product.attribute');

MShop.panel.order.base.product.attribute.ListUiSmall = Ext.extend(MShop.panel.AbstractListUi, {

    title : MShop.I18n.dt('client/extjs', 'Attribute'),
    recordName : 'Order_Base_Product_Attribute',
    idProperty : 'order.base.product.attribute.id',
    siteidProperty : 'order.base.product.attribute.siteid',
    itemUiXType : 'MShop.panel.order.product.itemui',
    autoExpandColumn : 'order-base-product-attribute-name',

    sortInfo : {
        field : 'order.base.product.attribute.id',
        direction : 'ASC'
    },

    filterConfig : {
        filters : [{
            dataIndex : 'order.base.product.attribute.code',
            operator : '=~',
            value : ''
        }]
    },


    initComponent : function() {
        MShop.panel.order.base.product.attribute.ListUiSmall.superclass.initComponent.apply(this, arguments);

        this.grid.un('rowcontextmenu', this.onGridContextMenu, this);
        this.grid.un('rowdblclick', this.onOpenEditWindow.createDelegate(this, ['edit']), this);
    },


    initToolbar : function() {},


    afterRender : function() {
        MShop.panel.order.base.product.attribute.ListUiSmall.superclass.afterRender.apply(this, arguments);

        this.itemUi = this.findParentBy(function(c) {
            return c.isXType(MShop.panel.AbstractItemUi, false);
        });
    },


    onBeforeLoad : function(store, options) {
        MShop.panel.order.base.product.attribute.ListUiSmall.superclass.onBeforeLoad.apply(this, arguments);

        options.params = options.params || {};
        options.params.condition = {
            '&&' : [{
                '==' : {
                    'order.base.product.attribute.productid' : this.itemUi.record ? this.itemUi.record.id : null
                }
            }]
        };

    },

    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.attribute.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.attribute.type',
            header : MShop.I18n.dt('client/extjs', 'Type'),
            width : 150
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.attribute.name',
            header : MShop.I18n.dt('client/extjs', 'Name'),
            id : 'order-base-product-attribute-name'
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.attribute.code',
            header : MShop.I18n.dt('client/extjs', 'Code'),
            width : 150
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.attribute.value',
            header : MShop.I18n.dt('client/extjs', 'Value'),
            width : 150
        }, {
            xtype : 'datecolumn',
            dataIndex : 'order.base.product.attribute.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'order.base.product.attribute.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'order.base.product.attribute.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            width : 130,
            hidden : true
        }];
    }
});

Ext.reg('MShop.panel.order.base.product.attribute.listuismall', MShop.panel.order.base.product.attribute.ListUiSmall);
