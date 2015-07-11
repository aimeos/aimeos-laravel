/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.elements');

MShop.elements.ImportButton = Ext.extend(Ext.Button, {

        /**
         * @cfg {String} importMethod (required)
         */
        importMethod : null,

        initComponent : function() {
            this.scope = this;
            this.handler = this.handler || this.onFileSelect;

            this.plugins = this.plugins || [];
            this.browsePlugin = new Ext.ux.file.BrowsePlugin();
            this.plugins.push(this.browsePlugin);

            this.loadMask = new Ext.LoadMask(Ext.getBody(), {
                msg : MShop.I18n.dt('client/extjs', 'Loading'),
                msgCls : 'x-mask-loading'
            });

            MShop.elements.ImportButton.superclass.initComponent.call(this);
        },

        /**
         * @private
         */
        onFileSelect : function(fileSelector, params) {
            this.loadMask.show();

            var list = params || {};
            list['site'] = MShop.config.site['locale.site.code'];

            var uploader = new Ext.ux.file.Uploader({
                fileSelector : fileSelector,
                url : MShop.config.smd.target,
                methodName : this.importMethod,
                allowHTML5Uploads : false,
                HTML4params : {
                    'params' : Ext.encode(list)
                }
            });

            uploader.on('uploadcomplete', this.onUploadSucess, this);
            uploader.on('uploadfailure', this.onUploadFail, this);

            uploader.upload(fileSelector.getFileList()[0]);
        },

        /**
         * @private
         */
        onUploadFail : function() {
            this.loadMask.hide();

            Ext.MessageBox.alert(MShop.I18n.dt('client/extjs', 'Upload failed'),
                MShop.I18n.dt('client/extjs', 'Could not upload file. Please notify your administrator')).setIcon(
                Ext.MessageBox.ERROR);
        },

        /**
         * @private
         */
        onUploadSucess : function(uploader, record, response) {
            this.loadMask.hide();

            Ext.MessageBox.alert(
                MShop.I18n.dt('client/extjs', 'Upload successful'),
                MShop.I18n.dt(
                    'client/extjs',
                    'The texts of your uploaded file will be imported within a few minutes. You can check the status of the import in the "Job" panel of the "Overview" tab'));
        }
    });

Ext.reg('MShop.elements.importbutton', MShop.elements.ImportButton);
