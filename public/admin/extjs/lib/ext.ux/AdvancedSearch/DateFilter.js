/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('Ext.ux.AdvancedSearch');

Ext.ux.AdvancedSearch.DateFilter = Ext.extend(Ext.ux.AdvancedSearch.Filter, {

    operators : ['>', '>=', '==', '!=', '<', '<='],
    defaultOperator : '==',
    defaultValue : '',

    initComponent : function() {

        this.valueFieldConfig = {
            xtype : 'datefield',
            format : 'Y-m-d H:i:s'
        };

        Ext.ux.AdvancedSearch.DateFilter.superclass.initComponent.call(this);
    },

    getValue : function() {

        v = Ext.ux.AdvancedSearch.DateFilter.superclass.getValue.call(this);

        if(v) {
            return new Date(v).format('Y-m-d H:i:s');
        }

        return v;
    }
});

Ext.reg('ux.datefilter', Ext.ux.AdvancedSearch.DateFilter);
