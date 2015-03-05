/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */


Ext.ns('MShop.panel.portal');

/**
 * @todo this class is misnamed, it's actually not a itemUi'
 */
MShop.panel.portal.ItemUi = Ext.extend(Ext.Panel, {

    idProperty : 'id',
    autoScroll : true,

    initComponent : function() {

        this.title = MShop.I18n.dt('client/extjs', 'Overview');

        this.items = [{
            xtype : 'portal',
            region : 'center',
            items : [{
                columnWidth : 1,
                items : [{
                    xtype : 'MShop.panel.job.listuismall',
                    style : 'margin:5px',
                    layout : 'fit',
                    height : 400,
                    border : true,
                    draggable : true,
                    collapsible : true,
                    collapsed : false
                }, {
                    xtype : 'MShop.panel.log.listuismall',
                    style : 'margin:5px',
                    layout : 'fit',
                    height : 400,
                    border : true,
                    draggable : true,
                    collapsible : true,
                    collapsed : false
                }, {
                    xtype : 'MShop.panel.cache.listuismall',
                    style : 'margin:5px',
                    layout : 'fit',
                    height : 400,
                    border : true,
                    draggable : true,
                    collapsible : true,
                    collapsed : false
                }]
            }]
        }];

        MShop.panel.portal.ItemUi.superclass.initComponent.call(this);
    }
});

Ext.reg('MShop.panel.portal.itemui', MShop.panel.portal.ItemUi);

//hook this into the main tab panel
Ext.ux.ItemRegistry.registerItem('MShop.MainTabPanel', 'MShop.panel.portal.itemui', MShop.panel.portal.ItemUi, 10);
