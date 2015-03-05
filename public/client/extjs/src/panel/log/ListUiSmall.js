/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */


Ext.ns('MShop.panel.log');

MShop.panel.log.ListUiSmall = Ext.extend(MShop.panel.AbstractListUi, {

    recordName : 'Admin_Log',
    idProperty : 'log.id',
    siteidProperty : 'log.siteid',
    itemUiXType : null,

    sortInfo : {
        field : 'log.timestamp',
        direction : 'DESC'
    },

    autoExpandColumn : 'list-log-message',

    filterConfig : {
        filters : [{
            dataIndex : 'log.timestamp',
            operator : '>',
            value : Ext.util.Format.date(new Date(new Date().valueOf() - 86400 * 1000), 'Y-m-d H:i:s')
        }]
    },

    initComponent : function() {
        this.title = MShop.I18n.dt('client/extjs', 'Logs');

        MShop.panel.AbstractListUi.prototype.initActions.call(this);
        MShop.panel.AbstractListUi.prototype.initToolbar.call(this);

        MShop.panel.log.ListUiSmall.superclass.initComponent.call(this);

        this.grid.un('rowcontextmenu', this.onGridContextMenu, this);
        this.grid.un('rowdblclick', this.onOpenEditWindow.createDelegate(this, ['edit']), this);
        this.grid.getSelectionModel().un('selectionchange', this.onGridSelectionChange, this, {
            buffer : 10
        });
        this.actionAdd.setDisabled(1);
    },

    onOpenEditWindow : function(action) {},

    getColumns : function() {
        return [{
            xtype : 'gridcolumn',
            dataIndex : 'log.id',
            header : MShop.I18n.dt('client/extjs', 'ID'),
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'log.facility',
            header : MShop.I18n.dt('client/extjs', 'Facility'),
            width : 50,
            hidden : true
        }, {
            xtype : 'datecolumn',
            dataIndex : 'log.timestamp',
            header : MShop.I18n.dt('client/extjs', 'Date'),
            width : 130,
            format : 'Y-m-d H:i:s'
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'log.priority',
            header : MShop.I18n.dt('client/extjs', 'Priority'),
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'log.message',
            header : MShop.I18n.dt('client/extjs', 'Message'),
            id : 'list-log-message',
            renderer : function(data) {
                try {
                    var result = '';
                    var object = Ext.decode(data);

                    for( var name in object) {
                        result += name + ': ' + object[name] + '<br/>';
                    }
                    return '<div style="white-space:normal !important;">' + result + '</div>';
                } catch(e) {
                    return '<div style="white-space:normal !important;">' + data + '</div>';
                }
            }
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'log.request',
            header : MShop.I18n.dt('client/extjs', 'Request'),
            width : 50,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'log.ctime',
            header : MShop.I18n.dt('client/extjs', 'Created'),
            sortable : true,
            width : 120,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'log.mtime',
            header : MShop.I18n.dt('client/extjs', 'Last modified'),
            sortable : true,
            width : 120,
            editable : false,
            hidden : true
        }, {
            xtype : 'gridcolumn',
            dataIndex : 'log.editor',
            header : MShop.I18n.dt('client/extjs', 'Editor'),
            sortable : true,
            width : 120,
            editable : false,
            hidden : true
        }];
    }
});

Ext.reg('MShop.panel.log.listuismall', MShop.panel.log.ListUiSmall);
