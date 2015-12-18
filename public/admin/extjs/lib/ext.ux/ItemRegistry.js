/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * $Id: ItemRegistry.js 14263 2011-12-11 16:36:17Z nsendetzky $
 */

Ext.ns('Ext.ux');

/**
 * plugin to insert additional registered items into a container
 * 
 * @namespace Ext.ux
 * @class Ext.ux.ItemRegistry
 * @autor Cornelius Weiss <c.weiss@metaways.de>
 * @license BSD, MIT and GPL
 * @verstion $Id: ItemRegistry.js 14263 2011-12-11 16:36:17Z nsendetzky $
 * @example // register 'additional item' for myDialog
 *          Ext.ux.ItemRegistry.registerItem('myDialog', 'add-item-xtype', 20); //
 *          in myDialog use itemRegistyPlugin myDialog =
 *          Ext.extend(Ext.Container, { ... plugins: [{ ptype:
 *          'ux.itemregistry', key: 'myDialog' }] })
 */
Ext.ux.ItemRegistry = function() {};

/**
 * @static
 * @private
 */
Ext.ux.ItemRegistry.itemMap = {};

/**
 * registers an item for a given key
 * 
 * @static
 * @param {String}
 *            key
 * @param {String/Constructor/Object}
 *            item
 * @param {Number}
 *            pos (optional)
 */
Ext.ux.ItemRegistry.registerItem = function(key, itemkey, item, pos) {
    if(!Ext.ux.ItemRegistry.itemMap.hasOwnProperty(key)) {
        Ext.ux.ItemRegistry.itemMap[key] = {};
    }

    Ext.ux.ItemRegistry.itemMap[key][itemkey] = {
        item : item,
        pos : pos
    };
};

Ext.ux.ItemRegistry.prototype = {
    /**
     * @cfg {String} key key the items are registered under. If no key is given,
     *      the itemId of the component will be used
     */
    key : null,

    init : function(cmp) {
        this.cmp = cmp;

        if(!this.key) {
            this.key = cmp.getItemId();
        }

        // give static item pos to existing items
        this.cmp.items.each(function(item, idx) {
            if(!item.hasOwnProperty('registerdItemPos')) {
                item.registerdItemPos = idx * 10;
            }
        }, this);

        var regItems = Ext.ux.ItemRegistry.itemMap[this.key] || [];

        Ext.iterate(regItems, function(key, value) {
            var addItem = this.getItem(value), addPos = null;

            this.cmp.items.each(function(item, idx) {
                if(addItem.registerdItemPos < item.registerdItemPos) {
                    this.cmp.insert(idx, addItem);
                    addPos = idx;
                    return false;
                }
                return true;
            }, this);

            if(!Ext.isNumber(addPos)) {
                this.cmp.add(addItem);
            }
        }, this);
    },

    getItem : function(reg) {
        var def = reg.item, item;

        if(typeof def === 'function') {
            item = new def();
        } else {
            if(Ext.isString(def)) {
                def = {
                    xtype : def
                };
            }

            item = this.cmp.lookupComponent(def);
        }

        item.registerdItemPos = reg.pos ? reg.pos : this.cmp.items.length * 10;

        return item;
    }

};
Ext.ComponentMgr.registerPlugin('ux.itemregistry', Ext.ux.ItemRegistry);

/*
 * test
 * 
 * Ext.onReady(function() { var testWin = new Ext.Window({ width: 640, height:
 * 480, layout: 'fit', title: 'ux.itemregistry test', items: [{ xtype:
 * 'tabpanel', activeTab: 0, border: false, defaults: {border: false}, itemId:
 * 'testWin', plugins: ['ux.itemregistry'], items: [{ title: 'basepanel', html:
 * 'basepanel' }, { title: 'no pos', html: 'no pos' }, { title: 'pos 50', html:
 * 'pos 50', registerdItemPos: 50 }] }] }); testWin.show(); });
 * 
 * itemRegTestPanel20 = Ext.extend(Ext.Panel, { title: 'add panel pos 20', html:
 * 'add panel pos 20',
 * 
 * initComponent: function() { // example how to hook in owner this.on('added',
 * function(me, owner, pos) { owner.on('tabchange', function() {
 * console.log('tabchange'); }) }),
 * 
 * itemRegTestPanel20.superclass.initComponent.call(this); } });
 * Ext.ux.ItemRegistry.registerItem('testWin', itemRegTestPanel20, 20);
 * 
 * itemRegTestPanel60 = { xtype: 'panel', title: 'add panel pos 60', html:
 * 'add panel pos 60' }; Ext.ux.ItemRegistry.registerItem('testWin',
 * itemRegTestPanel60, 60);
 */
