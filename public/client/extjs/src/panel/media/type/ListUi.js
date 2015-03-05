/*!
 * Copyright (c) Metaways Infosystems GmbH, 2013
 * LGPLv3, http://www.arcavias.com/license
 */


Ext.ns('MShop.panel.media.type');

MShop.panel.media.type.ListUi = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Media_Type',
    idProperty : 'media.type.id',
    siteidProperty : 'media.type.siteid',

    itemUiXType : 'MShop.panel.media.type.itemui',

    // Sort by id ASC
    sortInfo : {
        field : 'media.type.id',
        direction : 'ASC'
    },

    // Create filter
    filterConfig : {
        filters : [{
            dataIndex : 'media.type.label',
            operator : '=~',
            value : ''
        }]
    },

    // Override initComponent to set Label of tab.
    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Media type');

        MShop.panel.AbstractListUi.prototype.initActions.call(this);
        MShop.panel.AbstractListUi.prototype.initToolbar.call(this);

        MShop.panel.media.type.ListUi.superclass.initComponent.call(this);
    },


    autoExpandColumn : 'media-type-label',

    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'media.type.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.type.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 50,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.type.domain',
            header : MShop.I18n.dt('client/extjs', 'Domain'),
            sortable : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.type.code',
            header : MShop.I18n.dt('client/extjs', 'Code'),
            sortable : true,
            width : 150,
            align : 'center',
            editable : false
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.type.label',
            id : 'media-type-label',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            sortable : true,
            editable : false
        }, {
            xtype : 'datecolumn',
            dataIndex : 'media.type.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'media.type.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 130,
            format : 'Y-m-d H:i:s',
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.type.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 130,
            editable : false,
            hidden : true
        }];
    }
});

Ext.reg('MShop.panel.media.type.listui', MShop.panel.media.type.ListUi);

Ext.ux.ItemRegistry.registerItem('MShop.panel.type.tabUi', 'MShop.panel.media.type.listui',
    MShop.panel.media.type.ListUi, 20);
