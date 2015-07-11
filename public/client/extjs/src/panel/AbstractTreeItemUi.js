/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel');

/**
 * Abtract Tree ItemUi subclasses need to provide - this.items - this.mainForm
 * reference - this.treeUi
 * 
 * @namespace MShop
 * @class MShop.panel.AbstractTreeItemUi
 * @extends Ext.Window
 */
MShop.panel.AbstractTreeItemUi = Ext.extend(MShop.panel.AbstractItemUi, {
    /**
     * Reference to the parent treeUi Where this itemUi is opened from
     */
    treeUI : null,

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
    }
});

// NOTE: we need to register this abstract class so getByXtype can find decedents
// do we rly need to get this abstract this way? i think this is not used yet and we should think about keeping this register as small as possible
Ext.reg('MShop.panel.abstracttreeitemui', MShop.panel.AbstractTreeItemUi);
