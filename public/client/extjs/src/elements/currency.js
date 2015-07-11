/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.elements.currency');

MShop.elements.currency.ComboBox = function(config) {

    Ext.applyIf(config, {
        fieldLabel : MShop.I18n.dt('client/extjs', 'Currency'),
        anchor : '100%',
        store : MShop.elements.currency.getStore(),
        mode : 'local',
        displayField : 'locale.currency.label',
        valueField : 'locale.currency.id',
        statusField : 'locale.currency.status',
        triggerAction : 'all',
        pageSize : 20,
        typeAhead : true,
        allowBlank : false
    });

    MShop.elements.currency.ComboBox.superclass.constructor.call(this, config);
};

Ext.extend(MShop.elements.currency.ComboBox, Ext.form.ComboBox);

Ext.reg('MShop.elements.currency.combo', MShop.elements.currency.ComboBox);

/**
 * @static
 * @param {String}
 *            langId
 * @return {String} label
 */
MShop.elements.currency.renderer = function(currencyId, metaData, record, rowIndex, colIndex, store) {

    var currency = MShop.elements.currency.getStore().getById(currencyId);

    if(currency) {
        metaData.css = 'statustext-' + Number(currency.get('locale.currency.status'));
        return currency.get('locale.currency.label');
    }

    metaData.css = 'statustext-1';
    return currencyId;
};

/**
 * @static
 * @return {Ext.data.DirectStore}
 */
MShop.elements.currency.getStore = function() {

    if(!MShop.elements.currency._store) {
        MShop.elements.currency._store = MShop.GlobalStoreMgr.createStore('Locale_Currency', {
            remoteSort : true,
            sortInfo : {
                field : 'locale.currency.status',
                direction : 'DESC'
            }
        });
    }

    return MShop.elements.currency._store;
};

// preload
Ext.onReady(function() {
    MShop.elements.currency.getStore().load();
});
