/*!
 * Copyright (c) Metaways Infosystems GmbH, 2013
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel');

/**
 * Abtract ItemUi subclasses need to provide - this.items - this.mainForm
 * reference
 * 
 * @namespace MShop
 * @class MShop.panel.AbstractItemUi
 * @extends Ext.Window
 */
MShop.panel.AbstractItemUi = Ext.extend(Ext.Window, {

    /**
     * @cfg {Ext.data.Store} store (required)
     */
    store : null,

    /**
     * @cfg {Ext.data.Record} record (optional)
     */
    record : null,

    /**
     * @cfg {Ext.from.FormPanel} mainForm
     */
    mainForm : null,

    /**
     * Viewport height
     */
    height : null,

    /**
     * Viewport width
     */
    width : null,

    /**
     * Disable drag and drop of modal window
     */
    draggable : true,

    /**
     * Action from listUi default is "add": creating new entry as phantom
     */
    action : 'add',

    /**
     * @type Boolean isSaveing
     */
    isSaveing : false,

    /**
     * Start window maximized if screen is smaller than 800px
     */
    maximized : null,

    /**
     * @cfg {String} siteCssClass (inherited)
     */
    siteCssClass : 'site-mismatch',

    layout : 'fit',
    modal : true,


    initComponent : function() {

        this.addEvents(
        /**
         * @event beforesave Fired before record gets saved
         * @param {MShop.panel.AbstractItemUi}
         *            this
         * @param {Ext.data.Record}
         *            record
         */
        'beforesave',
        /**
         * @event save Fired after record got saved
         * @param {MShop.panel.AbstractItemUi}
         *            this
         * @param {Ext.data.Record}
         *            record
         * @param {Function}
         *            ticketFn
         */
        'save',
        /**
         * @event validate Fired when validating user data. return false to
         *        signal invalid data
         * @param {MShop.panel.AbstractItemUi}
         *            this
         * @param {Ext.data.Record}
         *            record
         */
        'validate');

        this.recordType = this.store.recordType;
        this.idProperty = this.idProperty || this.store.reader.meta.idProperty;

        this.initFbar();
        this.initRecord();

        this.store.on('beforewrite', this.onStoreBeforeWrite, this);
        this.store.on('exception', this.onStoreException, this);
        this.store.on('write', this.onStoreWrite, this);

        if(this.action == 'copy') {
            this.items[0].deferredRender = false;
        }

        this.height = Ext.getBody().getViewSize().height * 0.95;
        this.width = Ext.getBody().getViewSize().width * 0.80;
        this.maximized = this.width <= 800 ? true : false;

        MShop.panel.AbstractItemUi.superclass.initComponent.call(this);
    },

    setSiteCheck : function(itemUi) {
        itemUi.fieldsReadOnly = false;
        itemUi.readOnlyClass = '';

        if(itemUi.record && itemUi.record.get(itemUi.siteidProperty) &&
            itemUi.record.get(itemUi.siteidProperty) != MShop.config.site['locale.site.id']) {

            itemUi.fieldsReadOnly = true;
            itemUi.readOnlyClass = this.siteCssClass;
        }
    },

    initFbar : function() {
        this.fbar = {
            xtype : 'toolbar',
            buttonAlign : 'right',
            hideBorders : true,
            items : [{
                xtype : 'button',
                text : MShop.I18n.dt('client/extjs', 'Cancel'),
                width : 120,
                scale : 'medium',
                handler : this.close,
                scope : this
            }, {
                xtype : 'button',
                text : MShop.I18n.dt('client/extjs', 'Save'),
                width : 120,
                scale : 'medium',
                handler : this.onSaveItem,
                scope : this
            }]
        };
    },

    initRecord : function() {
        if(!this.mainForm) {
            // wait till ref if here
            return this.initRecord.defer(50, this, arguments);
        }

        if(!this.record || this.action == 'add') {
            this.record = new this.recordType();
            this.action = 'add';
        } else if(this.action == 'copy') {
            this.action = 'copy';

            // Copy selected record
            var edit = this.record.copy();

            var codeProperty = this.listUI.recordName.toLowerCase() + ".code";

            // Remove ID because it should be a copy of the original record
            edit.data[this.idProperty] = null;

            if(edit.data.hasOwnProperty(codeProperty)) {
                edit.set(codeProperty, edit.data[codeProperty] + "_copy");
            }

            this.record = edit;
        }

        this.mainForm.getForm().loadRecord(this.record);

        /** @todo Is this correct? */
        return true;
    },

    afterRender : function() {
        MShop.panel.AbstractItemUi.superclass.afterRender.apply(this, arguments);

        // kill x scrollers
        this.getEl().select('form').applyStyles({
            'overflow-x' : 'hidden'
        });

        this.saveMask = new Ext.LoadMask(this.el, {
            msg : MShop.I18n.dt('client/extjs', 'Saving')
        });
    },

    onDestroy : function() {
        this.store.un('beforewrite', this.onStoreBeforeWrite, this);
        this.store.un('exception', this.onStoreException, this);
        this.store.un('write', this.onStoreWrite, this);

        MShop.panel.AbstractItemUi.superclass.onDestroy.apply(this, arguments);
    },

    onBeforeSave : function(store, data, options) {
        var first = this.findByType('MShop.panel.configui').shift();

        if(first && options && options.configname) {
            var config = {};

            Ext.each(first.data, function(item, index) {
                Ext.iterate(item, function(key, value, object) {
                    if((key = key.trim()) !== '') {
                        config[key] = (typeof value === "string") ? value.trim() : value;
                    }
                }, this);
            });

            if(data.create && data.create[0]) {
                data.create[0].data[options.configname] = config;
            } else if(data.update && data.update[0]) {
                data.update[0].data[options.configname] = config;
            }
        }
    },

    /**
     * if it is not us who is saving, cancel the save request
     */
    onStoreBeforeWrite : function(store, action, rs, options) {
        var records = Ext.isArray(rs) ? rs : [rs];

        if(records.indexOf(this.record) !== -1) {
            return this.isSaveing;
        }
    },

    onSaveItem : function() {
        // validate data
        if(!this.mainForm.getForm().isValid() && this.fireEvent('validate', this) !== false) {
            Ext.Msg.alert(MShop.I18n.dt('client/extjs', 'Invalid data'), MShop.I18n.dt('client/extjs',
                'Please recheck your data'));
            return;
        }

        this.saveMask.show();
        this.isSaveing = true;

        // force record to be saved!
        this.record.dirty = true;

        if(this.fireEvent('beforesave', this, this.record) === false) {
            this.isSaveing = false;
            this.saveMask.hide();
        }

        this.mainForm.getForm().updateRecord(this.record);

        if(this.action == 'copy') {
            this.record.id = null;
            this.record.phantom = true;
        }

        if(this.action == 'copy' || this.action == 'add') {
            this.store.add(this.record);
        }

        // store async action is triggered. {@see onStoreWrite/onStoreException}
        if(!this.store.autoSave) {
            this.onAfterSave();
        }
    },

    onStoreException : function(proxy, type, action, options, response) {
        if(this.isSaveing) {
            this.isSaveing = false;
            this.saveMask.hide();
        }
    },

    onStoreWrite : function(store, action, result, transaction, rs) {

        var records = Ext.isArray(rs) ? rs : [rs];

        if(records.indexOf(this.record) !== -1 && this.isSaveing) {
            var ticketFn = this.onAfterSave.deferByTickets(this), wrapTicket = ticketFn();

            this.fireEvent('save', this, this.record, ticketFn);
            wrapTicket();
        }
    },

    onAfterSave : function() {
        this.isSaveing = false;
        this.saveMask.hide();

        this.close();
    }
});

// NOTE: we need to register this abstract class so getByXtype can find decedents
Ext.reg('MShop.panel.abstractitemui', MShop.panel.AbstractItemUi);
