/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * $Id: DecimalField.js 14263 2011-12-11 16:36:17Z nsendetzky $
 */

Ext.ns('Ext.ux.form');

Ext.ux.form.FormattableDisplayField = Ext.extend(Ext.form.DisplayField, {

    constructor : function(config) {

        var conf = config || {};

        Ext.applyIf(conf, {
            renderer : null
        });

        Ext.ux.form.FormattableDisplayField.superclass.constructor.call(this, conf);
    },

    setValue : function(v) {

        if(this.renderer) {
            v = this.renderer(v);
        }

        return Ext.ux.form.FormattableDisplayField.superclass.setValue.call(this, v);
    }
});

Ext.reg('ux.formattabledisplayfield', Ext.ux.form.FormattableDisplayField);
