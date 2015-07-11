/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.media');

MShop.panel.media.ListUiSmall = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Media',
    idProperty : 'media.id',
    siteidProperty : 'media.siteid',
    itemUiXType : 'MShop.panel.media.itemui',

    autoExpandColumn : 'media-list-label',

    filterConfig : {
        filters : [{
            dataIndex : 'media.label',
            operator : '=~',
            value : ''
        }]
    },

    getColumns : function() {
        // make sure type store gets loaded in same batch as this grid data
        this.typeStore = MShop.GlobalStoreMgr.get('Media_Type', this.domain);

        var storeConfig = {
            baseParams : {
                site : MShop.config.site["locale.site.code"],
                condition : {
                    '&&' : [{
                        '==' : {
                            'media.type.domain' : this.domain
                        }
                    }]
                }
            }
        };
        this.itemTypeStore = MShop.GlobalStoreMgr.get('Media_Type', this.domain + '/media/type', storeConfig);

        return [{
            xtype : 'gridcolumn',
            dataIndex : 'media.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            sortable : true,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.status',
            header : MShop.I18n.dt('client/extjs', 'Status'),
            sortable : true,
            width : 50,
            align : 'center',
            renderer : this.statusColumnRenderer.createDelegate(this)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.typeid',
            header : MShop.I18n.dt('client/extjs', 'Type'),
            width : 70,
            renderer : this.typeColumnRenderer.createDelegate(this, [this.typeStore, "media.type.label"], true)
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.languageid',
            header : MShop.I18n.dt('client/extjs', 'Language'),
            sortable : true,
            width : 50,
            renderer : MShop.elements.language.renderer
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.mimetype',
            header : MShop.I18n.dt('client/extjs', 'Mimetype'),
            sortable : true,
            width : 80,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.label',
            header : MShop.I18n.dt('client/extjs', 'Label'),
            sortable : true,
            id : 'media-list-label'
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.preview',
            header : MShop.I18n.dt('client/extjs', 'Preview'),
            renderer : this.previewRenderer.createDelegate(this),
            id : 'media-list-preview',
            width : 100
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 120,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 120,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'media.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 120,
            editable : false,
            hidden : true
        }];
    },

    previewRenderer : function(preview) {
        return '<img class="arcavias-admin-media-list-preview" src="' + MShop.urlManager.getAbsoluteUrl(preview) +
            '" />';
    }
});

Ext.reg('MShop.panel.media.listuismall', MShop.panel.media.ListUiSmall);
