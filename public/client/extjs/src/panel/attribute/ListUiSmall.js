/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.attribute');

MShop.panel.attribute.ListUiSmall = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Attribute',
    idProperty : 'attribute.id',
    siteidProperty : 'attribute.siteid',
    itemUiXType : 'MShop.panel.attribute.itemui',
    exportMethod : 'Attribute_Export_Text.createJob',
    importMethod : 'Attribute_Import_Text.uploadFile',

    autoExpandColumn : 'attribute-list-label',

    filterConfig : {
        filters : [{
            dataIndex : 'attribute.label',
            operator : '=~',
            value : ''
        }]
    },


    getColumns : function() {
        // make sure type store gets loaded in same batch as this grid data
        this.typeStore = MShop.GlobalStoreMgr.get('Attribute_Type');

        var storeConfig = {
            baseParams : {
                site : MShop.config.site["locale.site.code"],
                condition : {
                    '&&' : [{
                        '==' : {
                            'attribute.type.domain' : this.domain
                        }
                    }]
                }
            }
        };
        this.itemTypeStore = MShop.GlobalStoreMgr.get('Attribute_Type', this.domain + '/attribute/type', storeConfig);

        return [{
            xtype : 'gridcolumn',
            dataIndex : 'attribute.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'attribute.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 50,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'attribute.typeid',
            header : MShop.I18n.dt('client/extjs', 'Type'),
            width : 80,
            renderer : this.typeColumnRenderer.createDelegate(this, [this.typeStore, "attribute.type.label"], true)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'attribute.code',
            header : MShop.I18n.dt('client/extjs', 'Code'),
            sortable : true,
            width : 80
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'attribute.label',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            sortable : true,
            editable : false,
            id : 'attribute-list-label'
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'attribute.position',
            header : MShop.I18n.dt('client/extjs', 'Position'),
            sortable : true,
            width : 50,
            editable : false
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'attribute.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 120,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'attribute.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 120,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'attribute.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 120,
            editable : false,
            hidden : true
        }];
    }
});

Ext.reg('MShop.panel.attribute.listuismall', MShop.panel.attribute.ListUiSmall);
