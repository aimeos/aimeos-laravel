/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */


Ext.ns('MShop.elements.site');

MShop.elements.site.ComboBox = function(config) {
    Ext.applyIf(config, {
        recordName : 'Locale_Site',
        idProperty : 'locale.site.id',
        displayField : 'locale.site.label',
        valueField : 'locale.site.code',
        forceSelection : true,
        triggerAction : 'all',
        typeAhead : true,
        width : 250,
        pageSize : 20
    });

    MShop.elements.site.ComboBox.superclass.constructor.call(this, config);
};

Ext.extend(MShop.elements.site.ComboBox, Ext.form.ComboBox, {

    initComponent : function() {
        this.store = MShop.elements.site.getStore();
        this.on('select', this.onSiteSelect, this);
        MShop.elements.site.ComboBox.superclass.initComponent.call(this);
        this.setValue(MShop.config.site["locale.site.label"]);
    },

    onSiteSelect : function(ComboBox, site) {
        var mainTabPanel = Ext.getCmp('MShop.MainTabPanel');
        var activeTabPanel = mainTabPanel.getActiveTab();
        var domainTabIdx = mainTabPanel.items.indexOf(activeTabPanel);
        var siteCode = site ? site.get('locale.site.code') : 'default';

        new Ext.LoadMask(Ext.getBody(), {
            msg : MShop.I18n.dt('client/extjs', 'Switching site ...')
        }).show();

        MShop.urlManager.redirect({
            site : siteCode,
            tab : domainTabIdx,
            locale : MShop.urlManager.getLanguageCode() || null
        });
    }
});

Ext.reg('MShop.elements.site.combo', MShop.elements.site.ComboBox);


/**
 * @static
 * @return {Ext.data.DirectStore}
 */
MShop.elements.site.getStore = function() {
    if(!MShop.elements.site._store) {
        MShop.elements.site._store = MShop.GlobalStoreMgr.createStore('Locale_Site', {
            remoteSort : true,
            sortInfo : {
                field : 'locale.site.label',
                direction : 'ASC'
            }
        });
    }

    return MShop.elements.site._store;
};


//preload
Ext.onReady(function() {
    MShop.elements.site.getStore().load();
});
