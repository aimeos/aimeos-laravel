/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.elements.paymentstatus');

/**
 * @static
 * @return {String} label
 */
MShop.elements.paymentstatus.renderer = function(value) {

    var store = MShop.elements.paymentstatus.getStore();
    var data = store.getAt(store.find('value', value));

    if(data) {
        return data.get('label');
    }

    return value;
};

/**
 * @static
 * @return {Ext.data.ArrayStore}
 */
MShop.elements.paymentstatus.getStore = function() {

    if(!MShop.elements.paymentstatus._store) {

        MShop.elements.paymentstatus._store = new Ext.data.ArrayStore({
            idIndex : 0,
            fields : [{
                name : 'value',
                type : 'integer'
            }, {
                name : 'label',
                type : 'string'
            }],
            data : [
                [-1, MShop.I18n.dt('client/extjs', 'pay:unfinished')],
                [0, MShop.I18n.dt('client/extjs', 'pay:deleted')],
                [1, MShop.I18n.dt('client/extjs', 'pay:canceled')],
                [2, MShop.I18n.dt('client/extjs', 'pay:refused')],
                [3, MShop.I18n.dt('client/extjs', 'pay:refund')],
                [4, MShop.I18n.dt('client/extjs', 'pay:pending')],
                [5, MShop.I18n.dt('client/extjs', 'pay:authorized')],
                [6, MShop.I18n.dt('client/extjs', 'pay:received')]]
        });
    }

    return MShop.elements.paymentstatus._store;
};
