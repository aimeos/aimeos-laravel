/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.elements');

MShop.elements.PagingToolbar = function(config) {
    Ext.applyIf(config, {
        /**
         * @cfg {Number} page size (defaults to 50)
         */
        pageSize : 50
    });

    MShop.elements.PagingToolbar.superclass.constructor.call(this, config);
};

/**
 * MShop paging adoption - set default page size - removes the extjs need to
 * define paging in the stores initial load
 * 
 * @namespace MShop
 * @class MShop.elements.PagingToolbar
 * @extends Ext.PagingToolbar
 */
Ext.extend(MShop.elements.PagingToolbar, Ext.PagingToolbar, {

    // private
    beforeLoad : function(store, options) {
        options.params = options.params || {};
        var o = options.params, pn = this.getParams();
        o[pn.start] = o.hasOwnProperty(pn.start) ? o[pn.start] : 0;
        o[pn.limit] = o.hasOwnProperty(pn.limit) ? o[pn.limit] : this.pageSize;

        return MShop.elements.PagingToolbar.superclass.beforeLoad.apply(this, arguments);
    },

    // private
    doLoad : function(start) {
        var o = {}, pn = this.getParams();
        o[pn.start] = start;
        o[pn.limit] = this.pageSize;
        if(this.fireEvent('beforechange', this, o) !== false) {
            this.nextCursor = start;
            this.store.load({
                params : o
            });
        }
    },

    // private
    onLoad : function(store, r, o) {
        var pn = this.getParams();

        o.params = o.params || {};
        o.params[pn.start] = o.params.hasOwnProperty(pn.start) ? o.params[pn.start] : this.nextCursor || 0;

        MShop.elements.PagingToolbar.superclass.onLoad.apply(this, arguments);
    }
});

Ext.reg('MShop.elements.pagingtoolbar', MShop.elements.PagingToolbar);
