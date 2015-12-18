/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('Ext.ux.AdvancedSearch');

/**
 * dataIndex chooser + filter
 * 
 * @namespace Ext.ux.AdvancedSearch
 * @class Ext.ux.AdvancedSearch.FilterCriteria
 * @extends Ext.Container
 */
Ext.ux.AdvancedSearch.FilterCriteria = Ext.extend(Ext.Container, {

    layout : 'hbox',
    layoutConfig : {
        pack : 'start'
    },
    filterLayoutConfig : {
        flex : 3
    },

    createFilter : function(r) {
        var def = r.get('definition');
        var filter = Ext.ComponentMgr.create(def);
        var defValue = filter.getValue();
        var defOp = filter.getOperator();

        filter.setOperator(this.initialConfig.filter.operator);
        if(!filter.isValidOperator(true)) {
            filter.setOperator(defOp);
        }

        filter.setValue(this.initialConfig.filter.value);
        if(!filter.isValidValue(true)) {
            filter.setValue(defValue);
        }

        this.relayEvents(filter, ['filtertrigger']);

        Ext.apply(filter, this.filterLayoutConfig);
        return filter;
    },

    getFilterData : function() {
        return {
            dataIndex : this.CriteriaCombo.getValue(),
            operator : this.filter.getOperator(),
            value : this.filter.getValue() || ''
        };
    },

    initComponent : function() {
        this.CriteriaCombo = new Ext.form.ComboBox({
            typeAhead : true,
            triggerAction : 'all',
            lazyRender : true,
            forceSelection : true,
            mode : 'local',
            store : this.filterModel,
            valueField : 'dataIndex',
            displayField : 'label',
            value : this.filter.dataIndex,
            listeners : {
                scope : this,
                select : this.onCriteriaSelect
            }
        });

        this.filter = this.createFilter(this.filterModel.getById(this.filter.dataIndex));

        this.items = [Ext.applyIf(this.CriteriaCombo, {
            flex : 2
        }), Ext.applyIf(this.filter, {
            flex : 3
        })];

        Ext.ux.AdvancedSearch.FilterCriteria.superclass.initComponent.call(this);
    },

    onCriteriaSelect : function(combo, newRecord, newKey) {
        var newFilter = this.createFilter(newRecord);
        var defValue = newFilter.getValue();
        var defOp = newFilter.getOperator();
        var oldValue = this.filter.getValue();
        var oldOp = this.filter.getOperator();

        // probe the old operator / value
        newFilter.setOperator(oldOp);
        if(!newFilter.isValidOperator(true)) {
            newFilter.setOperator(defOp);
        }

        newFilter.setValue(oldValue);
        if(!newFilter.isValidValue(true)) {
            newFilter.setValue(defValue);
        }

        // replace filter
        this.add(newFilter);
        this.remove(this.filter, true);
        this.doLayout();

        this.filter = newFilter;
    },

    setFilterData : function(value) {
        if(value.hasOwnProperty('dataIndex')) {
            this.CriteriaCombo.setValue(value.dataIndex);
        }
        if(value.hasOwnProperty('operator')) {
            this.filter.setOperator(value.operator);
        }
        if(value.hasOwnProperty('value')) {
            this.filter.setValue(value.value);
        }

        return this;
    }
});

Ext.reg('ux.filtercriteria', Ext.ux.AdvancedSearch.FilterCriteria);
