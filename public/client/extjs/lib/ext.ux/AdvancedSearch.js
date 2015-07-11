/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * $Id: AdvancedSearch.js 14263 2011-12-11 16:36:17Z nsendetzky $
 */

Ext.ns('Ext.ux');

Ext.ux.AdvancedSearchPanel = Ext.extend(Ext.Panel, {

    /**
     * @cfg {String} searchParam search parameter name (defaults to 'condition')
     */
    searchParam : 'condition',

    /**
     * @cfg {Ext.data.Store} store The {@link Ext.data.Store} the advancedSearch
     *      should use as its data source (required).
     */

    boxMaxWidth : 700,

    cls : 'ux-advancedsearch ux-advancedsearch-panel x-toolbar',
    layout : 'hbox',
    layoutConfig : {
        align : 'stretch',
        pack : 'start'
    },

    border : false,

    initComponent : function() {
        this.bindStore(this.store, true);

        this.searchBtn = new Ext.Button({
            flex : 0,
            text : _('Search'),
            scope : this,
            handler : this.doLoad
        });

        this.resetBtn = new Ext.Button({
            flex : 0,
            iconCls : 'ux-advancedsearch-action-resetall',
            scope : this,
            handler : this.doReset
        });

        this.filterGroup = Ext.ComponentMgr.create({
            xtype : 'ux.filtergroup',
            flex : 1,
            filterModel : this.filterModel,
            filters : this.filters,
            listeners : {
                filtertrigger : this.doLoad.createDelegate(this)
            }
        });

        this.items = [this.filterGroup, {
            border : false,
            layout : 'vbox',
            flex : 0,
            layoutConfig : {
                pack : 'end'
            },
            items : {
                flex : 0,
                border : false,
                width : 100,
                layout : 'hbox',
                layoutConfig : {
                    align : 'stretchmax',
                    pack : 'start'
                },
                items : [this.searchBtn, this.resetBtn]
            }
        }];

        Ext.ux.AdvancedSearchPanel.superclass.initComponent.call(this);
    },

    // @todo generalize
    beforeLoad : function(store, options) {
        options.params = options.params || {};
        options.params[this.searchParam] = options.params[this.searchParam] || {};
        options.params[this.searchParam]['&&'] = options.params[this.searchParam]['&&'] || [];

        var filterData = this.filterGroup.getFilterData(), pn = this.getPolishNotation(filterData);

        options.params[this.searchParam]['&&'] = options.params[this.searchParam]['&&'].concat(pn['&&']);

        if(this.rendered && this.refresh) {
            this.searchBtn.disable();
        }
    },

    doLayout : function() {
        if(this.filterGroup && this.filterGroup.rendered) {
            this.setHeight(this.filterGroup.getHeight());
        }

        Ext.ux.AdvancedSearchPanel.superclass.doLayout.apply(this, arguments);
    },

    // private
    doLoad : function() {
        if(this.fireEvent('beforechange', this) !== false) {
            this.store.load();
        }
    },

    doReset : function() {
        this.filterGroup.resetFilters();
    },

    // TODO move this to some sort of `serializer`
    getPolishNotation : function(filterData) {
        var pnGroup = {}, pnFilters = [];

        Ext.each(filterData.filters, function(filter) {
            if(filter.hasOwnProperty('condition')) {
                pnFilters.push(this.getPolishNotation(filter));
            } else {
                var pnCrit = {}, pnVal = {};

                pnVal[filter.dataIndex] = filter.value;
                pnCrit[filter.operator] = pnVal;

                pnFilters.push(pnCrit);
            }
        }, this);

        pnGroup[filterData.condition == 'AND' ? '&&' : '||'] = pnFilters;

        return pnGroup;
    },

    // private
    onLoad : function(store, r, o) {
        if(!this.rendered) {
            this.dsLoaded = [store, r, o];
            return;
        }

        this.searchBtn.enable();
    },

    // private
    onLoadError : function() {
        if(!this.rendered) {
            return;
        }
        this.searchBtn.enable();
    },

    /**
     * Binds the paging toolbar to the specified {@link Ext.data.Store}
     * 
     * @param {Store}
     *            store The store to bind to this toolbar
     * @param {Boolean}
     *            initial (Optional) true to not remove listeners
     */
    bindStore : function(store, initial) {
        var doLoad;
        if(!initial && this.store) {
            if(store !== this.store && this.store.autoDestroy) {
                this.store.destroy();
            } else {
                this.store.un('beforeload', this.beforeLoad, this);
                this.store.un('load', this.onLoad, this);
                this.store.un('exception', this.onLoadError, this);
            }
            if(!store) {
                this.store = null;
            }
        }
        if(store) {
            store = Ext.StoreMgr.lookup(store);
            store.on({
                scope : this,
                beforeload : this.beforeLoad,
                load : this.onLoad,
                exception : this.onLoadError
            });
            doLoad = true;
        }
        this.store = store;
        if(doLoad) {
            this.onLoad(store, null, {});
        }
    },

    // private
    onDestroy : function() {
        this.bindStore(null);
        Ext.ux.AdvancedSearchPanel.superclass.onDestroy.call(this);
    }
});

Ext.reg('ux.advancedsearch', Ext.ux.AdvancedSearchPanel);
