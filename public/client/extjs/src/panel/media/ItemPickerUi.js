/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.media');

MShop.panel.media.ItemPickerUi = Ext.extend(MShop.panel.AbstractListItemPickerUi, {

    title : MShop.I18n.dt('client/extjs', 'Media'),

    initComponent : function() {

        Ext.apply(this.itemConfig, {
            title : MShop.I18n.dt('client/extjs', 'Associated media'),
            xtype : 'MShop.panel.listitemlistui',
            domain : 'media',
            getAdditionalColumns : this.getAdditionalColumns.createDelegate(this)
        });

        Ext.apply(this.listConfig, {
            title : MShop.I18n.dt('client/extjs', 'Available media'),
            xtype : 'MShop.panel.media.listuismall'
        });

        MShop.panel.media.ItemPickerUi.superclass.initComponent.call(this);
    },

    getAdditionalColumns : function() {

        var conf = this.itemConfig;
        this.typeStore = MShop.GlobalStoreMgr.get('Media_Type', conf.domain);
        this.listTypeStore = MShop.GlobalStoreMgr.get(conf.listTypeControllerName, conf.domain);

        return [
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'typeid',
                header : MShop.I18n.dt('client/extjs', 'List type'),
                id : 'listtype',
                width : 70,
                renderer : this.typeColumnRenderer.createDelegate(this,
                    [this.listTypeStore, conf.listTypeLabelProperty], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'refid',
                header : MShop.I18n.dt('client/extjs', 'Status'),
                id : 'refstatus',
                width : 50,
                align : 'center',
                renderer : this.refStatusColumnRenderer.createDelegate(this, ['media.status'], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'refid',
                header : MShop.I18n.dt('client/extjs', 'Type'),
                id : 'reftype',
                width : 70,
                renderer : this.refTypeColumnRenderer.createDelegate(this, [
                    this.typeStore,
                    'media.typeid',
                    'media.type.label'], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'refid',
                header : MShop.I18n.dt('client/extjs', 'Mimetype'),
                id : 'refmimetype',
                width : 80,
                hidden : true,
                sortable : true,
                renderer : this.refColumnRenderer.createDelegate(this, ['media.mimetype'], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'refid',
                header : MShop.I18n.dt('client/extjs', 'Language'),
                id : 'reflang',
                width : 50,
                renderer : this.refLangColumnRenderer.createDelegate(this, ['media.languageid'], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'refid',
                header : MShop.I18n.dt('client/extjs', 'Label'),
                id : 'refcontent',
                renderer : this.refColumnRenderer.createDelegate(this, ['media.label'], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'refid',
                header : MShop.I18n.dt('client/extjs', 'Preview'),
                id : 'refpreview',
                width : 100,
                renderer : this.refPreviewRenderer.createDelegate(this)
            }];
    },

    refPreviewRenderer : function(refId, metaData, record, rowIndex, colIndex, store) {
        var refItem = this.getRefStore().getById(refId);
        return (refItem ? '<img class="arcavias-admin-media-list-preview" src="' +
            MShop.urlManager.getAbsoluteUrl(refItem.get('media.preview')) + '" />' : '');
    }
});

Ext.reg('MShop.panel.media.itempickerui', MShop.panel.media.ItemPickerUi);
