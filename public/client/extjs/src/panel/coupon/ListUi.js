/*!
 * Copyright (c) Metaways Infosystems GmbH, 2013
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.coupon');

MShop.panel.coupon.ListUi = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Coupon',
    idProperty : 'coupon.id',
    siteidProperty : 'coupon.siteid',
    itemUiXType : 'MShop.panel.coupon.itemui',

    autoExpandColumn : 'coupon-list-label',

    filterConfig : {
        filters : [{
            dataIndex : 'coupon.label',
            operator : 'startswith',
            value : ''
        }]
    },

    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Coupon');

        MShop.panel.AbstractListUi.prototype.initActions.call(this);
        MShop.panel.AbstractListUi.prototype.initToolbar.call(this);

        MShop.panel.coupon.ListUi.superclass.initComponent.call(this);
    },

    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'coupon.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            width : 50,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'coupon.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 70,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'coupon.provider',
            header : MShop.I18n.dt('client/extjs', 'Provider'),
            sortable : true,
            editable : false
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'coupon.label',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            sortable : true,
            width : 100,
            editable : false,
            id : 'coupon-list-label'
        }, {
            xtype : 'datecolumn',
            dataIndex : 'coupon.datestart',
            header : MShop.I18n.dt('client/extjs', 'Start date'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s'
        }, {
            xtype : 'datecolumn',
            dataIndex : 'coupon.dateend',
            header : MShop.I18n.dt('client/extjs', 'End date'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s'
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'coupon.config',
            header : MShop.I18n.dt('client/extjs', 'Configuration'),
            width : 200,
            editable : false,
            renderer : function(value) {
                var s = "";
                Ext.iterate(value, function(key, value, object) {
                    if(typeof value === "object") {
                        value = Ext.util.JSON.encode(value);
                    }
                    s = s + String.format('<div>{0}: {1}</div>', key, value);
                }, this);
                return s;
            }
        }, {
            xtype : 'datecolumn',
            dataIndex : 'coupon.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'coupon.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'coupon.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 130,
            hidden : true
        }];
    }

});

Ext.reg('MShop.panel.coupon.listui', MShop.panel.coupon.ListUi);

// hook this into the main tab panel
Ext.ux.ItemRegistry.registerItem('MShop.MainTabPanel', 'MShop.panel.coupon.listui', MShop.panel.coupon.ListUi, 120);
