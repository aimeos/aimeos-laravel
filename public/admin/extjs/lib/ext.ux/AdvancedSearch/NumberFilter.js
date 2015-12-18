/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('Ext.ux.AdvancedSearch');

Ext.ux.AdvancedSearch.NumberFilter = Ext.extend(Ext.ux.AdvancedSearch.Filter, {

    operators : ['>', '>=', '==', '!=', '<', '<='],
    defaultOperator : '==',
    defaultValue : '',

    initComponent : function() {
        Ext.ux.AdvancedSearch.NumberFilter.superclass.initComponent.call(this);
    }

});

Ext.reg('ux.numberfilter', Ext.ux.AdvancedSearch.NumberFilter);
