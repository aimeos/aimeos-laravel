/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * $Id: Downloader.js 14263 2011-12-11 16:36:17Z nsendetzky $
 */

Ext.ns('Ext.ux.file');

/**
 * @namespace Ext.ux.file
 * @class Ext.ux.file.Downloader
 * @extends Ext.util.Observable
 */
Ext.ux.file.Downloader = function(config) {
    config = config || {};
    Ext.apply(this, config);

    Ext.ux.file.Downloader.superclass.constructor.call(this);

    this.addEvents({
        'success' : true,
        'fail' : true,
        'abort' : true
    });
};

Ext.extend(Ext.ux.file.Downloader, Ext.util.Observable, {
    url : null,
    method : 'POST',
    params : null,
    timeout : 1800000, // 30 minutes

    /**
     * @private
     */
    form : null,
    transactionId : null,

    /**
     * start download
     */
    start : function() {
        this.form = Ext.getBody().createChild({
            tag : 'form',
            method : this.method,
            cls : 'x-hidden'
        });

        var con = new Ext.data.Connection({
            // firefox specific problem -> see http://www.extjs.com/forum/archive/index.php/t-44862.html
            //  It appears that this is because the "load" is completing once the initial download dialog is displayed, 
            //  but the frame is then destroyed before the "save as" dialog is shown.
            //
            // TODO check if we can handle firefox event 'onSaveAsSubmit' (or something like that)
            //
            debugUploads : Ext.isGecko
        });

        this.transactionId = con.request({
            isUpload : true,
            form : this.form,
            params : this.params,
            scope : this,
            success : this.onSuccess,
            failure : this.onFailure,
            url : this.url,
            timeout : this.timeout
        });
    },

    /**
     * abort download
     */
    abort : function() {
        Ext.Ajax.abort(this.transactionId);
        this.form.remove();
        this.fireEvent('abort', this);
    },

    /**
     * @private
     */
    onSuccess : function() {
        this.form.remove();
        this.fireEvent('success', this);
    },

    /**
     * @private
     */
    onFailure : function() {
        this.form.remove();
        this.fireEvent('fail', this);
    }

});
