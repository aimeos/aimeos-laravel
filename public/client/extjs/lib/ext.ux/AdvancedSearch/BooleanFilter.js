/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */

Ext.ns('Ext.ux.AdvancedSearch');

Ext.ux.AdvancedSearch.BooleanFilter = Ext.extend(Ext.ux.AdvancedSearch.Filter, {

    operators : ['==', '!='],
    defaultOperator : '==',
    defaultValue : '',

    initComponent : function() {
        Ext.ux.AdvancedSearch.BooleanFilter.superclass.initComponent.call(this);
    }

});

Ext.reg('ux.booleanfilter', Ext.ux.AdvancedSearch.BooleanFilter);
