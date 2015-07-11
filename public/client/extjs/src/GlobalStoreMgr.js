/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop');

/**
 * a store with remote data loaded at first usage
 * 
 * @singelton
 * @class MShop.GlobalStore
 */
MShop.GlobalStoreMgr = {
    stores : {},

    /**
     * get store for given recordName
     * 
     * @param {String}
     *            recordName
     * @param {String}
     *            domain (optionl)
     * @param {Object}
     *            storeConfig (optional)
     * @return {Ext.data.DirectStore}
     */
    get : function(recordName, domain, storeConfig) {
        domain = domain || '__NODOMAIN__';
        this.stores[domain] = this.stores[domain] || {};

        if(!this.stores[domain][recordName]) {
            this.stores[domain][recordName] = this.createStore(recordName, storeConfig);

            this.stores[domain][recordName].load();
        }

        return this.stores[domain][recordName];
    },

    createStore : function(recordName, storeConfig) {
        storeConfig = storeConfig || {};

        // autodetect idProperty
        if(!storeConfig.idProperty) {
            storeConfig.idProperty = recordName.toLowerCase().replace(/_/g, '.') + '.id';
        }

        var store = new Ext.data.DirectStore(Ext.apply({
            autoLoad : false,
            remoteSort : false,
            hasMultiSort : true,
            fields : MShop.Schema.getRecord(recordName),
            api : {
                read : MShop.API[recordName].searchItems,
                create : MShop.API[recordName].saveItems,
                update : MShop.API[recordName].saveItems,
                destroy : MShop.API[recordName].deleteItems
            },
            writer : new Ext.data.JsonWriter({
                writeAllFields : true,
                encode : false
            }),
            paramsAsHash : true,
            root : 'items',
            totalProperty : 'total',
            baseParams : {
                site : MShop.config.site["locale.site.code"]
            }
        }, storeConfig));

        return store;
    }
};
