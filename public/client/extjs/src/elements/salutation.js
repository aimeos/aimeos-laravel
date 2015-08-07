/*!
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos.org, 2015
 */

Ext.ns('MShop.elements.salutation');

MShop.elements.salutation.ComboBox = function(config) {
    Ext.applyIf(config, {
        fieldLabel : MShop.I18n.dt('client/extjs', 'Salutation'),
        anchor : '100%',
        store : MShop.elements.salutation.getStore(),
        mode : 'local',
        displayField : 'label',
        valueField : 'value',
        triggerAction : 'all',
        typeAhead : true,
        value : ''
    });

    MShop.elements.salutation.ComboBox.superclass.constructor.call(this, config);
};

Ext.extend(MShop.elements.salutation.ComboBox, Ext.form.ComboBox);

Ext.reg('MShop.elements.salutation.combo', MShop.elements.salutation.ComboBox);


/**
 * @static
 * @param {String} id
 * @return {String} salutation
 */
MShop.elements.salutation.renderer = function(value) {

	var store = MShop.elements.salutation.getStore();
    var data = store.getAt(store.find('value', value));

    if(data) {
        return data.get('label');
    }

    return value;
};


/**
 * @static
 * @return {Ext.data.DirectStore}
 */
MShop.elements.salutation.getStore = function() {

    if(!MShop.elements.salutation._store) {

        MShop.elements.salutation._store = new Ext.data.ArrayStore({
            idIndex : 0,
            fields : [{
                name : 'value',
                type : 'string'
            }, {
                name : 'label',
                type : 'string'
            }],
            data : [
                ['', MShop.I18n.dt('client/extjs', 'unknown')],
                ['company', MShop.I18n.dt('client/extjs', 'Company')],
                ['mr', MShop.I18n.dt('client/extjs', 'Mr')],
                ['mrs', MShop.I18n.dt('client/extjs', 'Mrs')],
                ['miss', MShop.I18n.dt('client/extjs', 'Miss')]
            ]
        });
    }

    return MShop.elements.salutation._store;
};
