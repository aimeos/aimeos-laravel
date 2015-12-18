/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * $Id: Uploader.js 14263 2011-12-11 16:36:17Z nsendetzky $
 */

Ext.ns('Ext.ux.file');

/**
 * a simple file uploader objects of this class represent a single file uplaod
 * 
 * @namespace Ext.ux.file
 * @class Ext.ux.file.Uploader
 * @extends Ext.util.Observable
 * @autor Cornelius Weiss <c.weiss@metaways.de>
 * @license BSD, MIT and GPL
 * @verstion $Id: Uploader.js 14263 2011-12-11 16:36:17Z nsendetzky $
 */
Ext.ux.file.Uploader = function(config) {
    Ext.apply(this, config);

    Ext.ux.file.Uploader.superclass.constructor.apply(this, arguments);

    this.addEvents(
    /**
     * @event uploadcomplete Fires when the upload was done successfully
     * @param {Ext.ux.file.Uploader}
     *            this
     * @param {Ext.Record}
     *            Ext.ux.file.Uploader.file
     * @param {Object}
     *            raw response
     */
    'uploadcomplete',
    /**
     * @event uploadfailure Fires when the upload failed
     * @param {Ext.ux.file.Uploader}
     *            this
     * @param {Ext.Record}
     *            Ext.ux.file.Uploader.file
     */
    'uploadfailure',
    /**
     * @event uploadprogress Fires on upload progress (html5 only)
     * @param {Ext.ux.file.Uploader}
     *            this
     * @param {Ext.Record}
     *            Ext.ux.file.Uploader.file
     * @param {XMLHttpRequestProgressEvent}
     */
    'uploadprogress');
};

Ext.extend(Ext.ux.file.Uploader, Ext.util.Observable, {

    /**
     * @cfg {String} url the url we upload to
     */
    url : 'index.php',

    /**
     * @cfg {String} methodName name of method to call for uploads
     */
    methodName : '',

    /**
     * @cfg {String} methodParam server side method param (defaults to 'method')
     */
    methodParam : 'method',

    /**
     * @cfg {Number} timeout
     */
    timeout : 30000,

    /**
     * @cfg {Boolean} allowHTML5Uploads
     */
    allowHTML5Uploads : true,

    /**
     * @cfg {Object} HTML4params additional request params for html4 uploads
     */
    HTML4params : null,

    /**
     * @cfg {Int} maxFileSize the maximum file size in bytes
     */
    maxFileSize : 20971520, // 20 MB

    /**
     * @cfg {Ext.ux.file.BrowsePlugin} fileSelector a file selector
     */
    fileSelector : null,

    /**
     * creates a form where the upload takes place in
     * 
     * @private
     */
    createForm : function() {
        var form = Ext.getBody().createChild({
            tag : 'form',
            action : this.url,
            method : 'post',
            cls : 'x-hidden',
            id : Ext.id(),
            cn : [{
                tag : 'input',
                type : 'hidden',
                name : 'MAX_FILE_SIZE',
                value : this.maxFileSize
            }]
        });
        return form;
    },

    /**
     * perform the upload
     * 
     * @param {FILE}
     *            file to upload (optional for html5 uploads)
     * @return {Ext.Record} Ext.ux.file.Uploader.file
     */
    upload : function(file) {
        if(this.allowHTML5Uploads && ((!Ext.isGecko && window.XMLHttpRequest && window.File && window.FileList) || // safari, chrome, ...?
        (Ext.isGecko && window.FileReader)) && file) {
            return this.html5upload(file);
        } else {
            return this.html4upload();
        }
    },

    /**
     * 2010-01-26 Current Browsers implemetation state of:
     * http://www.w3.org/TR/FileAPI Interface: File | Blob | FileReader |
     * FileReaderSync | FileError FF : yes | no | no | no | no safari : yes | no |
     * no | no | no chrome : yes | no | no | no | no => no json rpc style upload
     * possible => no chunked uploads posible But all of them implement
     * XMLHttpRequest Level 2: http://www.w3.org/TR/XMLHttpRequest2/ => the only
     * way of uploading is using the XMLHttpRequest Level 2.
     */
    html5upload : function(file) {
        var fileRecord = new Ext.ux.file.Uploader.file({
            name : file.name ? file.name : file.fileName, // safari and chrome use the non std. fileX props
            type : (file.type ? file.type : file.fileType) || this.fileSelector.getFileCls(), // missing if safari and chrome
            size : (file.size ? file.size : file.fileSize) || 0, // non standard but all have it ;-)
            status : 'uploading',
            progress : 0,
            input : this.getInput()
        });

        var conn = new Ext.data.Connection({
            disableCaching : true,
            method : 'POST',
            url : this.url + '?' + this.methodParam + '=' + this.methodName,
            timeout : this.timeout,
            defaultHeaders : {
                "Content-Type" : "application/x-www-form-urlencoded",
                "X-Requested-With" : "XMLHttpRequest"
            }
        });

        var transaction = conn.request({
            headers : {
                "X-File-Name" : fileRecord.get('name'),
                "X-File-Type" : fileRecord.get('type'),
                "X-File-Size" : fileRecord.get('size')
            },
            xmlData : file,
            success : this.onUploadSuccess.createDelegate(this, [fileRecord], true),
            failure : this.onUploadFail.createDelegate(this, [fileRecord], true),
            fileRecord : fileRecord
        });

        var upload = transaction.conn.upload;

        upload['onprogress'] = this.onUploadProgress.createDelegate(this, [fileRecord], true);

        return fileRecord;
    },

    /**
     * uploads in a html4 fashion
     * 
     * @return {Ext.data.Connection}
     */
    html4upload : function() {
        var form = this.createForm();
        var input = this.getInput();
        form.appendChild(input);

        var fileRecord = new Ext.ux.file.Uploader.file({
            name : this.fileSelector.getFileName(),
            size : 0,
            type : this.fileSelector.getFileCls(),
            input : input,
            form : form,
            status : 'uploading',
            progress : 0
        });

        var params = {};
        params[this.methodParam] = this.methodName;
        Ext.apply(params, this.HTML4params);

        Ext.Ajax.request({
            fileRecord : fileRecord,
            isUpload : true,
            method : 'post',
            form : form,
            timeout : this.timeout,
            success : this.onUploadSuccess.createDelegate(this, [fileRecord], true),
            failure : this.onUploadFail.createDelegate(this, [fileRecord], true),
            params : params
        });

        return fileRecord;
    },

    /*
     * onLoadStart: function(e, fileRecord) { this.fireEvent('loadstart', this,
     * fileRecord, e); },
     */

    onUploadProgress : function(e, fileRecord) {
        var percent = Math.round(e.loaded / e.total * 100);
        fileRecord.set('progress', percent);
        this.fireEvent('uploadprogress', this, fileRecord, e);
    },

    /**
     * executed if a file got uploaded successfully
     */
    onUploadSuccess : function(response, options, fileRecord) {
        try {
            response = Ext.util.JSON.decode(response.responseText);
        } catch(e) {
            return this.onUploadFail(response, options, fileRecord);
        }

        if(response.status && response.status !== 'success') {
            this.onUploadFail(response, options, fileRecord);
        } else {
            fileRecord.beginEdit();
            fileRecord.set('status', 'complete');
            fileRecord.set('tempFile', response.tempFile);
            if(response.tempFile) {
                fileRecord.set('name', response.tempFile.name);
                fileRecord.set('size', response.tempFile.size);
                fileRecord.set('type', response.tempFile.type);
                fileRecord.set('path', response.tempFile.path);
            }
            fileRecord.commit(false);

            this.fireEvent('uploadcomplete', this, fileRecord, response);
        }

        /** @todo Is this correct? */
        return true;
    },

    /**
     * executed if a file upload failed
     */
    onUploadFail : function(response, options, fileRecord) {
        fileRecord.set('status', 'failure');

        if(response.error) {
            fileRecord.set('error', response.error);
        }

        this.fireEvent('uploadfailure', this, fileRecord);
    },

    // private
    getInput : function() {
        if(!this.input) {
            this.input = this.fileSelector.detachInputFile();
        }

        return this.input;
    }
});

Ext.ux.file.Uploader.file = Ext.data.Record.create([{
    name : 'id',
    type : 'text',
    system : true
}, {
    name : 'name',
    type : 'text',
    system : true
}, {
    name : 'size',
    type : 'number',
    system : true
}, {
    name : 'type',
    type : 'text',
    system : true
}, {
    name : 'status',
    type : 'text',
    system : true
}, {
    name : 'progress',
    type : 'number',
    system : true
}, {
    name : 'form',
    system : true
}, {
    name : 'input',
    system : true
}, {
    name : 'request',
    system : true
}, {
    name : 'path',
    system : true
}, {
    name : 'tempFile',
    system : true
}]);
