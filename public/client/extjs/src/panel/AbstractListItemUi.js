/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel');

/**
 * Abtract List ItemUi For uses by parent listUi subclasses need to provide
 * - this.items
 * - this.mainForm reference
 * - this.listUI
 * 
 * @namespace MShop
 * @class MShop.panel.AbstractListItemUi
 * @extends MShop.panel.AbstractItemUi
 */
MShop.panel.AbstractListItemUi = Ext.extend(MShop.panel.AbstractItemUi, {
    /**
     * Reference to his parent listUi, a itemUi can not be opened without any parent reference
     * 
     * @required
     */
    listUI : null,

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

        /**
         * @todo this could be more generic or at least configurable actually
         *       this code works only with itemUis, maybe it would be better to
         *       move it there
         */
        var recordRefIdProperty = this.listUI.listNamePrefix + "refid";
        var recordTypeIdProperty = this.listUI.listNamePrefix + "typeid";

        var index = this.store.findBy(function(item, index) {
            var recordRefId = this.record.get(recordRefIdProperty);
            var recordTypeId = this.mainForm.getForm().getFieldValues()[recordTypeIdProperty];

            var itemRefId = item.get(recordRefIdProperty);
            var itemTypeId = item.get(recordTypeIdProperty);

            var recordId = this.record.id;
            var itemId = index;

            if(!recordRefId || !recordTypeId || !itemRefId || !itemTypeId)
                return false;

            return (recordRefId == itemRefId && recordTypeId == itemTypeId && recordId != itemId);
        }, this);

        if(index != -1) {
            this.isSaveing = false;
            this.saveMask.hide();
            Ext.Msg.alert(MShop.I18n.dt('client/extjs', 'Invalid data'), MShop.I18n.dt('client/extjs',
                'This combination already exists'));
            return;
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
    }

});

// NOTE: we need to register this abstract class so getByXtype can find decedents
// This may be not required to a abstract class due to ExtJS.extends
Ext.reg('MShop.panel.abstractlistitemui', MShop.panel.AbstractListItemUi);
