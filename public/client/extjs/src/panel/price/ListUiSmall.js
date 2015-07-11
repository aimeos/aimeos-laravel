/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
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

    storeConfig : {
        baseParams : {
            options : {

                /** client/extjs/panel/price/listuismall/showall
                 * Display prices of all items of the same domain in the admin interface
                 *
                 * By default, only the prices for the specific product, attribute or
                 * services associated to that items are shown in the price list views.
                 * This reduces to probability to associate a price to multiple items
                 * by accident but also prevents shop owners to use this for convenience.
                 *
                 * When you set this option to "1", all prices of the same domain will
                 * be listed, e.g. all product prices. You can filter this prices in the
                 * list view and search for prices with specific properties. If a price
                 * is associated to more than one product, attribute or service, it will
                 * change for all items at once when one of the price properties is
                 * adapted.
                 *
                 * @param boolean True or "1" to show all prices, false or "0" otherwise
                 * @since 2015.05
                 * @category Developer
                 * @category User
                 */
                'showall' : MShop.Config.get('client/extjs/panel/price/listuismall/showall', false )
            }
        }
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
