/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop');

/**
 * @singleton
 */
MShop.Schema = {
    recordCache : {},
    filterModelCache : {},

    schemaMap : {},
    searchSchemaMap : {},

    getRecord : function(schemaName) {
        if(!this.recordCache.hasOwnProperty(schemaName)) {
            var fields = [], schema = this.getSchema(schemaName);

            for( var fieldName in schema.properties) {

                fields.push({
                    name : fieldName,
                    type : this.getType(schema.properties[fieldName]),
                    dateFormat : 'Y-m-d H:i:s'
                });
            }

            this.recordCache[schemaName] = Ext.data.Record.create(fields);
        }

        return this.recordCache[schemaName];
    },

    getFilterModel : function(schemaName) {
        if(!this.filterModelCache.hasOwnProperty(schemaName)) {
            var fields = [], schema = this.getSearchSchema(schemaName);

            for( var dataIndex in schema.criteria) {
                fields.push({
                    label : schema.criteria[dataIndex].description,
                    dataIndex : dataIndex,
                    xtype : this.getFilterXType(schema.criteria[dataIndex])
                });
            }

            this.filterModelCache[schemaName] = fields;
        }

        return this.filterModelCache[schemaName];
    },

    getFilterXType : function(criteriaModel) {
        switch(criteriaModel.type) {
            case 'string':
                return 'ux.textfilter';
            case 'boolean':
                return 'ux.booleanfilter';
            case 'integer':
                return 'ux.numberfilter';
            case 'decimal':
                return 'ux.numberfilter';
            case 'datetime':
                return 'ux.datefilter';
            default:
                return 'ux.textfilter';
        }
    },

    getType : function(field) {
        switch(field.type) {
            case 'datetime':
                return 'date';
            case 'integer':
                return 'auto'; // we convert to auto to support NULLs
            default:
                return 'auto';
        }
    },

    getSchema : function(schemaName) {
        if(!this.schemaMap.hasOwnProperty(schemaName)) {
            /// Schema error message with schema name ({0})
            var msg = MShop.I18n.dt('client/extjs', 'Schema {0} is  not registered');
            throw new Ext.Error(String.format(msg, schemaName));
        }

        return this.schemaMap[schemaName];
    },

    getSearchSchema : function(schemaName) {
        if(!this.searchSchemaMap.hasOwnProperty(schemaName)) {
            /// Search schema error message with search schema name ({0})
            var msg = MShop.I18n.dt('client/extjs', 'Search schema {0} is  not registered');
            throw new Ext.Error(String.format(msg, schemaName));
        }

        return this.searchSchemaMap[schemaName];
    },

    // MShop specific
    register : function(itemschema, searchschema) {
        this.schemaMap = itemschema;
        this.searchSchemaMap = searchschema;
    }

};
