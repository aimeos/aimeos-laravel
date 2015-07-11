/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

/**
 * do not evaluate to dot (.) as obj seperator when creating accessors, to
 * support dots in fieldnames
 */
Ext.apply(Ext.data.JsonReader.prototype, {
    createAccessor : function() {
        var re = /[\[]/;
        return function(expr) {
            if(Ext.isEmpty(expr)) {
                return Ext.emptyFn;
            }
            if(Ext.isFunction(expr)) {
                return expr;
            }
            return function(obj) {
                return obj[expr];
            };
        };
    }()
});

/**
 * - support dots in fieldnames - generic status renderer
 */
Ext.form.ComboBox.prototype.initList = Ext.form.ComboBox.prototype.initList.createInterceptor(function() {
    // autodetect status fieldname
    if(!this.statusField) {
        this.store.fields.each(function(field) {
            if(field.name.match(/\.status$/)) {
                this.statusField = field.name;
            }
        }, this);
    }

    this.tpl = '<tpl for="."><div class="x-combo-list-item statustext-{[values["' + this.statusField +
        '"]]}">{[values["' + this.displayField + '"]]}</div></tpl>';
});

Ext.util.JSON.encodeDate = function(o) {

    pad = function(n) {
        return n < 10 ? "0" + n : n;
    };

    return '"' + o.getFullYear() + "-" + pad(o.getMonth() + 1) + "-" + pad(o.getDate()) + " " + pad(o.getHours()) +
        ":" + pad(o.getMinutes()) + ":" + pad(o.getSeconds()) + '"';
};

/*
 * Fix for wrong width calculations
 * 
 * Thanks to uwolfer:
 * http://www.sencha.com/forum/showthread.php?198124-Grids-are-rendered-differently-in-upcoming-versions-of-Google-Chrome/page6
 */
if(Ext.isWebKit && Ext.webKitVersion >= 535.2) { // probably not the exact version, but the issues started appearing in chromium 19
    Ext.override(Ext.grid.ColumnModel, {
        getTotalWidth : function(includeHidden) {
            if(!this.totalWidth) {
                var boxsizeadj = 2;
                this.totalWidth = 0;
                for( var i = 0, len = this.config.length; i < len; i++) {
                    if(includeHidden || !this.isHidden(i)) {
                        this.totalWidth += (this.getColumnWidth(i) + boxsizeadj);
                    }
                }
            }
            return this.totalWidth;
        }
    });
}

/*
 * Fix for broken drag&drop groups in ExtJS 3.*
 * 
 * Thanks to berniesaurus:
 * http://www.sencha.com/forum/showthread.php?264400-Ext-JS-3.4.4.1-Drag-amp-Drop-broken
 */
Ext.dd.DragDropMgr.getZIndex = function(element) {
    var body = document.body, z, zIndex = -1;
    var overTargetEl = element;

    element = Ext.getDom(element);
    while(element !== body) {

        // this fixes the problem
        if(!element) {
            this._remove(overTargetEl); // remove the drop target from the manager
            break;
        }
        // fix end

        if(!isNaN(z = Number(Ext.fly(element).getStyle('zIndex')))) {
            zIndex = z;
        }
        element = element.parentNode;
    }
    return zIndex;
};
