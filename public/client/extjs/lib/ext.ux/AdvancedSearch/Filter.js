/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('Ext.ux.AdvancedSearch');

/**
 * operator and value part of a search criteria
 * 
 * @namespace Ext.ux.AdvancedSearch
 * @class Ext.ux.AdvancedSearch.Filter
 * @extends Ext.Container
 */
Ext.ux.AdvancedSearch.Filter = Ext.extend(Ext.Container, {

    defaultOperator : null,

    defaultValue : null,

    operator : null,
    operatorFieldConfig : null,

    value : null,
    valueFieldConfig : null,

    layout : 'hbox',
    layoutConfig : {
        pack : 'start'
    },

    getOperator : function() {
        return this.operatorField.getValue();
    },

    getValue : function() {
        return this.valueField.getValue();
    },

    initComponent : function() {
        this.initOperatorField();
        this.initValueField();

        this.items = [Ext.applyIf(this.operatorField, {
            flex : 1
        }), Ext.applyIf(this.valueField, {
            flex : 2
        })];

        Ext.ux.AdvancedSearch.Filter.superclass.initComponent.call(this);
    },

    initOperatorField : function() {
        this.operatorStore = new Ext.data.ArrayStore({
            fields : ['operator', 'displayText']
        });

        Ext.each(this.operators, function(operator) {
            this.operatorStore.loadData([[operator, _(operator)]], true);
        }, this);

        this.operatorField = Ext.ComponentMgr.create(Ext.apply({
            xtype : 'combo',
            typeAhead : true,
            triggerAction : 'all',
            lazyRender : true,
            forceSelection : true,
            mode : 'local',
            store : this.operatorStore,
            valueField : 'operator',
            displayField : 'displayText',
            isValid : function(preventMark) {

                var val = this.getRawValue();
                var rec = this.findRecord(this.valueField, val);
                var isValid = Ext.form.ComboBox.prototype.isValid.apply(this, arguments);

                if(!isValid || !rec) {
                    if(!preventMark) {
                        this.markInvalid(this.blankText);
                    }
                    return false;
                }

                return true;
            },
            value : this.operator ? this.operator : this.defaultOperator,
            listeners : {
                scope : this,
                select : this.onOperatorSelect
            }
        }, this.operatorFieldConfig));
    },

    initValueField : function() {
        this.valueField = Ext.ComponentMgr.create(Ext.apply({
            xtype : 'textfield',
            selectOnFocus : true,
            listeners : {
                scope : this,
                specialkey : function(field, e) {
                    if(e.getKey() == e.ENTER) {
                        this.fireEvent('filtertrigger', this);
                    }
                }
            },
            isValid : function(preventMark) {
                var isValid = Ext.form.TextField.prototype.isValid.apply(this, arguments), val = this.getRawValue();

                if(!isValid || !Ext.isString(val)) {
                    if(!preventMark) {
                        this.markInvalid();
                    }
                    return false;
                }

                return true;
            }
        }, this.valueFieldConfig));
    },

    isValid : function(preventMark) {
        return this.isValidOperator(preventMark) && this.isValidValue(preventMark);
    },

    isValidOperator : function(preventMark) {
        return this.operatorField.isValid(preventMark);
    },

    isValidValue : function(preventMark) {
        return this.valueField.isValid(preventMark);
    },

    onOperatorSelect : function(combo, newRecord, newKey) {

    },

    setOperator : function(operator) {
        this.operatorField.setValue(operator);
        return this;
    },

    setValue : function(value) {
        this.valueField.setValue(value);
        return this;
    }
});
