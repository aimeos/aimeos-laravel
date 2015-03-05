/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */

Ext.ns('MShop.panel.price');

MShop.panel.price.ListUiSmall = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Price',
    idProperty : 'price.id',
    siteidProperty : 'price.siteid',
    itemUiXType : 'MShop.panel.price.itemui',

    autoExpandColumn : 'price-label',

    filterConfig : {
        filters : [{
            dataIndex : 'price.currencyid',
            operator : '=~',
            value : ''
        }]
    },

    getColumns : function() {

        // make sure type store gets loaded in same batch as this grid data
        this.typeStore = MShop.GlobalStoreMgr.get('Price_Type', this.domain);

        var storeConfig = {
            baseParams : {
                site : MShop.config.site["locale.site.code"],
                condition : {
                    '&&' : [{
                        '==' : {
                            'price.type.domain' : this.domain
                        }
                    }]
                }
            }
        };
        this.ItemTypeStore = MShop.GlobalStoreMgr.get('Price_Type', this.domain + '/price/type', storeConfig);

        return [
            {
                xtype : 'gridcolumn',
                dataIndex : 'price.id',
                header : MShop.I18n.dt('client/extjs', 'ID'),
                sortable : true,
                editable : false,
                hidden : true
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'price.label',
                header : MShop.I18n.dt('client/extjs', 'Label'),
                sortable : true,
                align : 'left',
                id : 'price-label'
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'price.status',
                header : MShop.I18n.dt('client/extjs', 'Status'),
                sortable : true,
                width : 50,
                align : 'center',
                renderer : this.statusColumnRenderer.createDelegate(this)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'price.typeid',
                header : MShop.I18n.dt('client/extjs', 'Type'),
                width : 70,
                renderer : this.typeColumnRenderer.createDelegate(this, [this.typeStore, "price.type.label"], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'price.currencyid',
                header : MShop.I18n.dt('client/extjs', 'Currency'),
                sortable : true,
                width : 50
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'price.quantity',
                header : MShop.I18n.dt('client/extjs', 'Quantity'),
                sortable : true,
                width : 70,
                align : 'right'
            },
            {
                xtype : 'numbercolumn',
                dataIndex : 'price.value',
                header : MShop.I18n.dt('client/extjs', 'Price'),
                sortable : true,
                width : 100,
                id : 'price-list-price',
                align : 'right'
            },
            {
                xtype : 'numbercolumn',
                dataIndex : 'price.rebate',
                header : MShop.I18n.dt('client/extjs', 'Rebate'),
                sortable : true,
                width : 70,
                hidden : true,
                align : 'right'
            },
            {
                xtype : 'numbercolumn',
                dataIndex : 'price.costs',
                header : MShop.I18n.dt('client/extjs', 'Costs'),
                sortable : true,
                width : 70,
                hidden : true,
                align : 'right'
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'price.taxrate',
                header : MShop.I18n.dt('client/extjs', 'Tax rate'),
                sortable : true,
                width : 70,
                align : 'right',
                hidden : !MShop.Config.get('client/extjs/panel/price/listuismall/taxrate', MShop.Config.get(
                    'client/extjs/panel/price/taxrate', false))
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'price.ctime',
                header : MShop.I18n.dt('client/extjs', 'Created'),
                sortable : true,
                width : 120,
                editable : false,
                hidden : true
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'price.mtime',
                header : MShop.I18n.dt('client/extjs', 'Last modified'),
                sortable : true,
                width : 120,
                editable : false,
                hidden : true
            },
            {
                xtype : 'gridcolumn',
                dataIndex : 'price.editor',
                header : MShop.I18n.dt('client/extjs', 'Editor'),
                sortable : true,
                width : 120,
                editable : false,
                hidden : true
            }];
    }
});

Ext.reg('MShop.panel.price.listuismall', MShop.panel.price.ListUiSmall);
