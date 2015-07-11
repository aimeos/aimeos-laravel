/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.elements.status');

MShop.elements.status.ComboBox = function(config) {
    Ext.applyIf(config, {
        fieldLabel : MShop.I18n.dt('client/extjs', 'Status'),
        anchor : '100%',
        store : MShop.elements.status.getStore(),
        mode : 'local',
        displayField : 'label',
        valueField : 'value',
        triggerAction : 'all',
        typeAhead : true,
        value : 1
    });

    MShop.elements.status.ComboBox.superclass.constructor.call(this, config);
};

Ext.extend(MShop.elements.status.ComboBox, Ext.form.ComboBox);

Ext.reg('MShop.elements.status.combo', MShop.elements.status.ComboBox);

/**
 * @static
 * @return {Ext.data.DirectStore}
 */
MShop.elements.status.getStore = function() {

    if(!MShop.elements.status._store) {

        MShop.elements.status._store = new Ext.data.ArrayStore({
            idIndex : 0,
            fields : [{
                name : 'value',
                type : 'integer'
            }, {
                name : 'label',
                type : 'string'
            }],
            data : [
                [-2, MShop.I18n.dt('client/extjs', 'status:archive')],
                [-1, MShop.I18n.dt('client/extjs', 'status:review')],
                [0, MShop.I18n.dt('client/extjs', 'status:disabled')],
                [1, MShop.I18n.dt('client/extjs', 'status:enabled')]]
        });
    }

    return MShop.elements.status._store;
};
