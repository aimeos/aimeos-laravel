/*!
 * Ext JS Library 3.2.1
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.ux.Portal = Ext.extend(Ext.Panel, {
    layout : 'column',
    autoScroll : true,
    cls : 'x-portal',
    defaultType : 'portalcolumn',

    initComponent : function() {
        Ext.ux.Portal.superclass.initComponent.call(this);
        this.addEvents({
            validatedrop : true,
            beforedragover : true,
            dragover : true,
            beforedrop : true,
            drop : true
        });
    },

    initEvents : function() {
        Ext.ux.Portal.superclass.initEvents.call(this);
        this.dd = new Ext.ux.Portal.DropZone(this, this.dropConfig);
    },

    beforeDestroy : function() {
        if(this.dd) {
            this.dd.unreg();
        }
        Ext.ux.Portal.superclass.beforeDestroy.call(this);
    }
});

Ext.reg('portal', Ext.ux.Portal);

Ext.ux.Portal.DropZone = Ext.extend(Ext.dd.DropTarget, {

    constructor : function(portal, cfg) {
        this.portal = portal;
        Ext.dd.ScrollManager.register(portal.body);
        Ext.ux.Portal.DropZone.superclass.constructor.call(this, portal.bwrap.dom, cfg);
        portal.body.ddScrollConfig = this.ddScrollConfig;
    },

    ddScrollConfig : {
        vthresh : 50,
        hthresh : -1,
        animate : true,
        increment : 200
    },

    createEvent : function(dd, e, data, col, c, pos) {
        return {
            portal : this.portal,
            panel : data.panel,
            columnIndex : col,
            column : c,
            position : pos,
            data : data,
            source : dd,
            rawEvent : e,
            status : this.dropAllowed
        };
    },

    notifyOver : function(dd, e, data) {
        var xy = e.getXY(), portal = this.portal, px = dd.proxy;

        // case column widths
        if(!this.grid) {
            this.grid = this.getGrid();
        }

        // handle case scroll where scrollbars appear during drag
        var cw = portal.body.dom.clientWidth;
        if(!this.lastCW) {
            this.lastCW = cw;
        } else if(this.lastCW != cw) {
            this.lastCW = cw;
            portal.doLayout();
            this.grid = this.getGrid();
        }

        // determine column
        var col = 0, xs = this.grid.columnX, cmatch = false;
        for( var len = xs.length; col < len; col++) {
            if(xy[0] < (xs[col].x + xs[col].w)) {
                cmatch = true;
                break;
            }
        }
        // no match, fix last index
        if(!cmatch) {
            col--;
        }

        // find insert position
        var p, match = false, pos = 0, c = portal.items.itemAt(col), items = c.items.items, overSelf = false;

        for( var length = items.length; pos < length; pos++) {
            p = items[pos];
            var h = p.el.getHeight();
            if(h === 0) {
                overSelf = true;
            } else if((p.el.getY() + (h / 2)) > xy[1]) {
                match = true;
                break;
            }
        }

        pos = (match && p ? pos : c.items.getCount()) + (overSelf ? -1 : 0);
        var overEvent = this.createEvent(dd, e, data, col, c, pos);

        if(portal.fireEvent('validatedrop', overEvent) !== false &&
            portal.fireEvent('beforedragover', overEvent) !== false) {

            // make sure proxy width is fluid
            px.getProxy().setWidth('auto');

            if(p) {
                px.moveProxy(p.el.dom.parentNode, match ? p.el.dom : null);
            } else {
                px.moveProxy(c.el.dom, null);
            }

            this.lastPos = {
                c : c,
                col : col,
                p : overSelf || (match && p) ? pos : false
            };
            this.scrollPos = portal.body.getScroll();

            portal.fireEvent('dragover', overEvent);

            return overEvent.status;
        } else {
            return overEvent.status;
        }

    },

    notifyOut : function() {
        delete this.grid;
    },

    notifyDrop : function(dd, e, data) {
        delete this.grid;
        if(!this.lastPos) {
            return;
        }
        var c = this.lastPos.c;
        var col = this.lastPos.col;
        var pos = this.lastPos.p;
        var panel = dd.panel;
        var dropEvent = this.createEvent(dd, e, data, col, c, pos !== false ? pos : c.items.getCount());

        if(this.portal.fireEvent('validatedrop', dropEvent) !== false &&
            this.portal.fireEvent('beforedrop', dropEvent) !== false) {

            dd.proxy.getProxy().remove();
            panel.el.dom.parentNode.removeChild(dd.panel.el.dom);

            if(pos !== false) {
                c.insert(pos, panel);
            } else {
                c.add(panel);
            }

            c.doLayout();

            this.portal.fireEvent('drop', dropEvent);

            // scroll position is lost on drop, fix it
            var st = this.scrollPos.top;
            if(st) {
                var d = this.portal.body.dom;
                setTimeout(function() {
                    d.scrollTop = st;
                }, 10);
            }

        }
        delete this.lastPos;
    },

    // internal cache of body and column coords
    getGrid : function() {
        var box = this.portal.bwrap.getBox();
        box.columnX = [];
        this.portal.items.each(function(c) {
            box.columnX.push({
                x : c.el.getX(),
                w : c.el.getWidth()
            });
        });
        return box;
    },

    // unregister the dropzone from ScrollManager
    unreg : function() {
        Ext.dd.ScrollManager.unregister(this.portal.body);
        Ext.ux.Portal.DropZone.superclass.unreg.call(this);
    }
});
