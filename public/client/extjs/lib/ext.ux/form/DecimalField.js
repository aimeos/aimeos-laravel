/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * $Id: DecimalField.js 14263 2011-12-11 16:36:17Z nsendetzky $
 */

Ext.ns('Ext.ux.form');

Ext.ux.form.DecimalField = Ext.extend(Ext.form.NumberField, {

    setValue : function(v) {

        v = Ext.isNumber(v) ? v : parseFloat(String(v).replace(this.decimalSeparator, "."));

        if(isNaN(v)) {
            v = 0.0;
        }

        v = v.toFixed(this.decimalPrecision).replace(".", this.decimalSeparator);

        return Ext.form.NumberField.superclass.setValue.call(this, v);
    }
});

Ext.reg('ux.decimalfield', Ext.ux.form.DecimalField);
