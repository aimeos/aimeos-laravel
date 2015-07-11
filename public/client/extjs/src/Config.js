/*!
 * Copyright (c) Metaways Infosystems GmbH, 2013
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop');

MShop.Config = {

    configuration : {},

    get : function(name, defaultName) {
        name = name.replace(/^\/|\/$/g, ''); //trim '/'
        var parts = name.split('/');

        if((value = this._get(this.configuration, parts)) !== null) {
            return value;
        }

        return defaultName;
    },

    init : function(configuration) {
        this.configuration = configuration;
    },

    set : function(name, value) {
        name = name.replace(/^\/|\/$/g, ''); //trim '/'
        var parts = name.split('/');

        this.configuration = this._set(this.configuration, parts, value);
    },

    _get : function(config, parts) {
        if((current = parts.shift()) !== undefined && config[current] !== undefined) {
            if(parts.length > 0) {
                return this._get(config[current], parts);
            }

            return config[current];
        }

        return null;
    },

    _set : function(config, path, value) {
        var current = path.shift();

        if(current !== undefined) {
            if(config[current] !== undefined) {
                config[current] = this._set(config[current], path, value);
            } else {
                config[current] = this._set({}, path, value);
            }

            return config;
        }

        return value;
    }
};
