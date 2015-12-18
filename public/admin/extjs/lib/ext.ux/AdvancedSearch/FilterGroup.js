/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('Ext.ux.AdvancedSearch');

Ext.ux.AdvancedSearch.FilterGroup = Ext.extend(Ext.Container, {
    /**
     * @cfg {Array} filterModel (required)
     */
    filterModel : null,

    /**
     * @cfg {String} defaultFilter dataIndex of default filter
     */
    defaultFilter : null,

    combineOperator : 'AND',

    layout : 'vbox',
    border : false,

    layoutConfig : {
        align : 'stretch',
        pack : 'start'
    },

    defaults : {
        border : false
    },

    getHeight : function() {
        var height = 0;

        this.items.each(function(item) {
            height += item.getHeight();
        }, this);
        return height;
    },

    getFilterData : function() {
        var filters = [];
        this.items.each(function(item) {
            if(item.criteria) {
                filters.push(item.criteria.filter.getFilterData());
            }
        }, this);

        return {
            condition : this.combineOperator,
            filters : filters
        };
    },

    addFilter : function(filter) {
        var criteria = {};

        criteria.filter = Ext.ComponentMgr.create({
            xtype : 'ux.filtercriteria',
            flex : 1,
            filterModel : this.filterModel,
            filter : filter
        });
        criteria.addBtn = new Ext.Button({
            iconCls : 'ux-advancedsearch-action-addcriteria',
            handler : this.onAddBtnClick.createDelegate(this, [criteria])
        });
        criteria.delBtn = new Ext.Button({
            iconCls : 'ux-advancedsearch-action-delcriteria',
            handler : this.onDelBtnClick.createDelegate(this, [criteria])
        });

        criteria.cmp = Ext.ComponentMgr.create({
            xtype : 'container',
            layout : 'hbox',
            layoutConfig : {
                align : 'stretchmax'
            },
            items : [criteria.addBtn, criteria.delBtn, criteria.filter],
            criteria : criteria
        });

        this.add(criteria.cmp);

        // relayout
        this.doLayout();
        if(this.ownerCt) {
            this.ownerCt.doLayout();
        }

        this.relayEvents(criteria.filter, ['filtertrigger']);
    },

    afterRender : function() {
        Ext.ux.AdvancedSearch.FilterGroup.superclass.afterRender.apply(this, arguments);
        this.getEl().on('contextmenu', this.onContextMenu, this);
    },

    doLayout : function() {
        // arrange buttons
        var lastIdx = this.items.getCount() - 1;
        this.items.each(function(item, idx) {
            item.criteria.addBtn.setDisabled(idx !== lastIdx);
            item.criteria.delBtn.setDisabled(lastIdx === 0);
        }, this);

        Ext.ux.AdvancedSearch.FilterGroup.superclass.doLayout.apply(this, arguments);
    },

    initComponent : function() {
        Ext.ux.AdvancedSearch.FilterGroup.superclass.initComponent.call(this);

        // init fieldStore
        var data = [];
        Ext.each(this.filterModel, function(filter) {
            data.push([filter.dataIndex, filter.label, filter]);
        }, this);
        this.filterModel = new Ext.data.ArrayStore({
            idIndex : 0,
            fields : ['dataIndex', 'label', 'definition'],
            data : data
        });

        // init default filter
        if(!this.defaultFilter) {
            this.defaultFilter = this.filterModel.getAt(0).get('dataIndex');
        }
        if(Ext.isString(this.defaultFilter)) {
            this.defaultFilter = {
                dataIndex : this.defaultFilter
            };
        }

        // init filters
        if(!Ext.isArray(this.filters) || Ext.isEmpty(this.filters)) {
            this.filters = [this.defaultFilter];
        }

        // add filters to this group
        Ext.each(this.filters, function(filter) {
            this.addFilter(filter);
        }, this);

        this.action_reset = new Ext.Action({
            iconCls : 'ux-advancedsearch-action-resetgroup',
            handler : this.resetFilters,
            scope : this
        });
    },

    onAddBtnClick : function(criteria) {
        this.addFilter(this.defaultFilter);
    },

    onContextMenu : function(e) {
        e.preventDefault();
        if(!this.menu) {
            this.menu = new Ext.menu.Menu({
                items : this.action_reset
            });
        }

        this.menu.showAt(e.getXY());
    },

    onDelBtnClick : function(criteria) {
        this.remove(criteria.cmp, true);

        this.doLayout();
        if(this.ownerCt) {
            this.ownerCt.doLayout();
        }

        this.fireEvent('filtertrigger', this);
    },

    resetFilters : function() {
        this.items.each(function(item, idx) {
            this.remove(item.criteria.cmp, true);
        }, this);

        Ext.each(this.filters, function(filter) {
            this.addFilter(filter);
        }, this);

        this.doLayout();
        if(this.ownerCt) {
            this.ownerCt.doLayout();
        }

        this.fireEvent('filtertrigger', this);
    },

    setFilterData : function(critera, operator) {

        this.items.each(function(item, idx) {
            this.remove(item.criteria.cmp, true);
        }, this);

        critera = Ext.isArray(critera) ? critera : [critera];
        Ext.each(critera, function(criterium) {
            this.addFilter(criterium);
        }, this);

        this.combineOperator = operator || 'AND';

        this.doLayout();
        if(this.ownerCt) {
            this.ownerCt.doLayout();
        }

        this.fireEvent('filtertrigger', this);
    }

});

Ext.reg('ux.filtergroup', Ext.ux.AdvancedSearch.FilterGroup);
