/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://www.arcavias.com/en/license
 */

Ext.ns('MShop.elements.siteLanguage');

MShop.elements.siteLanguage.ComboBox = function(config) {
    Ext.applyIf(config, {
        fieldLabel : MShop.I18n.dt('client/extjs', 'Language'),
        anchor : '100%',
        store : MShop.elements.siteLanguage.getStore(),
        mode : 'local',
        displayField : 'label',
        valueField : 'label',
        triggerAction : 'all',
        emptyText : MShop.I18n.dt('client/extjs', 'Language')
    });

    MShop.elements.siteLanguage.ComboBox.superclass.constructor.call(this, config);
};

Ext.extend(MShop.elements.siteLanguage.ComboBox, Ext.form.ComboBox, {

    initComponent : function() {
        this.store = MShop.elements.siteLanguage.getStore();
        this.on('select', this.onSiteLanguageSelect, this);

        var index;
        if((index = this.store.findExact('id', MShop.urlManager.getLanguageCode())) >= 0) {
            this.setValue(this.store.getAt(index).get('label'));
        } else {
            this.setValue(this.store.getAt(this.store.findExact('id', 'en')).get('label'));
        }

        MShop.elements.siteLanguage.ComboBox.superclass.initComponent.call(this);
    },

    onSiteLanguageSelect : function(ComboBox, language) {
        var mainTabPanel = Ext.getCmp('MShop.MainTabPanel');
        var activeTabPanel = mainTabPanel.getActiveTab();
        var domainTabIdx = mainTabPanel.items.indexOf(activeTabPanel);
        var languageCode = language ? language.get('id') : 'en';

        new Ext.LoadMask(Ext.getBody(), {
            msg : MShop.I18n.dt('client/extjs', 'Switching language ...')
        }).show();

        MShop.urlManager.redirect({
            site : MShop.urlManager.data.site,
            lang : languageCode,
            tab : domainTabIdx
        });
    }
});

Ext.reg('MShop.elements.siteLanguage.combo', MShop.elements.siteLanguage.ComboBox);

/**
 * @static
 * @return {Ext.data.DirectStore}
 */
MShop.elements.siteLanguage.getStore = function() {
    if(!MShop.elements.siteLanguage.store) {
        MShop.elements.siteLanguage.store = new Ext.data.JsonStore({
            fields : ['id', 'label'],
            data : MShop.i18n.available
        });
    }

    return MShop.elements.siteLanguage.store;
};
