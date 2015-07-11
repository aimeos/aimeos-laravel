/*!
 * Copyright (c) Metaways Infosystems GmbH, 2013
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel.type');

/**
 * Nest all types in a types tab
 * 
 * @class MShop.panel.type.TabUi
 * @extends Ext.Panel
 */
MShop.panel.type.TabUi = Ext.extend(Ext.Panel, {

    maximized : true,
    layout : 'fit',
    modal : true,

    initComponent : function() {

        this.title = MShop.I18n.dt('client/extjs', 'Types');

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.type.tabUi',
            plugins : ['ux.itemregistry']
        }];

        MShop.panel.type.TabUi.superclass.initComponent.call(this);
    }
});

Ext.reg('MShop.panel.type.tabui', MShop.panel.type.TabUi);

Ext.ux.ItemRegistry.registerItem('MShop.MainTabPanel', 'MShop.panel.type.tabui', MShop.panel.type.TabUi, 120);
