/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://www.arcavias.com/en/license
 */


Ext.ns('MShop.panel.cache');

MShop.panel.cache.ListUiSmall = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Admin_Cache',
    idProperty : 'cache.id',
    siteidProperty : 'cache.siteid',
    itemUiXType : 'MShop.panel.cache.itemui',
    autoExpandColumn : 'cache-list-value',

    filterConfig : {
        filters : [{
            dataIndex : 'cache.id',
            operator : '=~',
            value : ''
        }]
    },


    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Cache');

        MShop.panel.AbstractListUi.prototype.initActions.call(this);
        MShop.panel.AbstractListUi.prototype.initToolbar.call(this);

        MShop.panel.cache.ListUiSmall.superclass.initComponent.call(this);
    },


    initActions : function() {

        this.actionEdit = new Ext.Action({
            text : MShop.I18n.dt('client/extjs', 'Edit'),
            disabled : true,
            handler : this.onOpenEditWindow.createDelegate(this, ['edit'])
        });

        this.actionDelete = new Ext.Action({
            text : MShop.I18n.dt('client/extjs', 'Delete'),
            disabled : true,
            handler : this.onDeleteSelectedItems.createDelegate(this)
        });

        this.actionFlush = new Ext.Action({
            text : MShop.I18n.dt('client/extjs', 'Flush'),
            handler : this.onFlush.createDelegate(this)
        });
    },


    initToolbar : function() {
        this.tbar = [this.actionEdit, this.actionDelete, this.actionFlush];
    },


    getCtxMenu : function() {
        if(!this.ctxMenu) {
            this.ctxMenu = new Ext.menu.Menu({
                items : [this.actionEdit, this.actionDelete]
            });
        }

        return this.ctxMenu;
    },


    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'cache.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            width : 400
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'cache.value',
            header : MShop.I18n.dt('client/extjs', 'Value'),
            id : 'cache-list-value',
            renderer : function(data) {
                return Ext.util.Format.htmlEncode(data);
            }
        }, {
            xtype : 'datecolumn',
            dataIndex : 'cache.expire',
            header : MShop.I18n.dt('client/extjs', 'Expires'),
            format : 'Y-m-d H:i:s',
            width : 130
        }];
    },


    onFlush : function() {
        var that = this;

        Ext.Msg.show({
            title : MShop.I18n.dt('client/extjs', 'Flush cache?'),
            msg : MShop.I18n.dt('client/extjs',
                'You are going to flush the complete cache for the current site. Would you like to proceed?'),
            buttons : Ext.Msg.YESNO,
            fn : function(btn) {
                if(btn == 'yes') {
                    MShop.API.Admin_Cache.flush(MShop.config.site["locale.site.code"]);
                    that.store.reload();
                }
            },
            animEl : 'elId',
            icon : Ext.MessageBox.QUESTION
        });
    }

});

Ext.reg('MShop.panel.cache.listuismall', MShop.panel.cache.ListUiSmall);
