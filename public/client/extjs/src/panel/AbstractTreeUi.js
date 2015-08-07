/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel');

MShop.panel.AbstractTreeUi = Ext.extend(Ext.tree.TreePanel, {

    /**
     * @cfg {String} recordName (required)
     */
    recordName : null,

    /**
     * @cfg {String} idProperty (required)
     */
    idProperty : null,

    /**
     * @cfg {String} idProperty (required)
     */
    domain : null,

    /**
     * @cfg {String} exportMethod (required)
     */
    exportMethod : null,

    /**
     * @cfg {Object} importMethod (optional)
     */
    importMethod : null,

    rootVisible : true,
    useArrows : true,
    autoScroll : true,
    animate : true,
    enableDD : true,
    containerScroll : true,
    border : false,
    maskDisabled : true,

    initComponent : function() {
        // store is used for data transfer mainly
        this.initStore();

        this.on('movenode', this.onMoveNode, this);
        this.on('containercontextmenu', this.onContainerContextMenu, this);
        this.on('contextmenu', this.onContextMenu, this);
        this.on('dblclick', this.onOpenEditWindow.createDelegate(this, ['edit']), this);
        this.on('expandnode', this.onExpandNode, this);
        this.getSelectionModel().on('selectionchange', this.onSelectionChange, this, {
            buffer : 10
        });

        MShop.panel.AbstractTreeUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        MShop.panel.AbstractTreeUi.superclass.afterRender.apply(this, arguments);

        this.disable();
        this.root.expand();
    },

    getCtxMenu : MShop.panel.AbstractListUi.prototype.getCtxMenu,

    onExport : function() {
        var win = new MShop.elements.exportlanguage.Window();
        win.on('save', this.finishExport, this);
        win.show();
    },

    finishExport : function(langwin, languages) {
        var selection = this.getSelectionModel().getSelectedNode();

        var downloader = new Ext.ux.file.Downloader({
            url : MShop.config.smd.target,
            params : {
                method : this.exportMethod,
                params : Ext.encode({
                    items : selection.id,
                    lang : languages,
                    site : MShop.config.site['locale.site.code']
                })
            }
        }).start();
    },

    /**
     * If there are no children do not display expand / collapse symbols
     */
    onExpandNode : function(node) {
        var domain = this.domain;
        Ext.each(node["childNodes"], function(node) {
            if(node["attributes"].hasOwnProperty(domain + ".hasChildren") &&
                node["attributes"][domain + ".hasChildren"] === false) {
                node.ui.ecNode.style.visibility = 'hidden';
            }
        }, this);
    },

    /**
     * Init Loader
     * 
     * @param {}
     *            showRootId
     */
    initLoader : function(showRootId) {
        var domain = this.domain;
        this.loader = new Ext.tree.TreeLoader({

            nodeParameter : 'items',
            paramOrder : ['site', 'items'],
            baseParams : {
                site : MShop.config.site["locale.site.code"]
            },

            directFn : MShop.API[this.recordName].getTree,

            processResponse : function(response, node, callback, scope) {
                // reset root
                if(node.id === 'root') {
                    // we create the node to have it in the store
                    var newNode = this.createNode(response.responseText.items);
                    var text;

                    if(showRootId !== true) {
                        text = response.responseText.items[domain + '.label'];
                    } else {
                        text = response.responseText.items[domain + '.id'] + " - ";
                        text += response.responseText.items[domain + '.label'];
                    }

                    node.setId(response.responseText.items[domain + '.id']);
                    node.setText(text);
                    node.getUI().addClass(newNode.attributes.cls);
                    node.getOwnerTree().enable();
                    node.getOwnerTree().actionAdd.setDisabled(node.id !== 'root');
                }
                // cut off item itself
                response.responseData = response.responseText.items.children || {};
                return Ext.tree.TreeLoader.prototype.processResponse.apply(this, arguments);
            },

            createNode : Ext.tree.TreeLoader.prototype.createNode.createInterceptor(this.inspectCreateNode, this)
        });

        this.loader.on('loadexception', function(loader, node, response) {

            if(node.id === 'root') {
                // no root node yet
                node.getUI().hide();
                node.getOwnerTree().enable();
                return;
            }
        }, this);
    },

    // NOTE: loading is done via treeloader, records get
    // created/inserted in this store from the treeloader also
    initStore : function() {
        this.store = new Ext.data.DirectStore(Ext.apply({
            autoLoad : false,
            remoteSort : true,
            hasMultiSort : true,
            fields : MShop.Schema.getRecord(this.recordName),
            api : {
                create : MShop.API[this.recordName].insertItems,
                update : MShop.API[this.recordName].saveItems,
                destroy : MShop.API[this.recordName].deleteItems
            },
            writer : new Ext.data.JsonWriter({
                writeAllFields : true,
                encode : false
            }),
            paramsAsHash : true,
            root : 'items',
            totalProperty : 'total',
            idProperty : this.idProperty
        }, this.storeConfig));

        // make sure site param gets set for write actions
        this.store.on('exception', this.onStoreException, this);
        this.store.on('beforewrite', this.onBeforeWrite, this);
        this.store.on('write', this.onWrite, this);
    },

    onBeforeWrite : function(store, action, records, options) {
        if(action === 'create') {
            var parent = this.getSelectionModel().getSelectedNode();

            // NOTE: baseParams is the only hook we have here
            store.baseParams = store.baseParams || {};
            store.baseParams.parentid = parent ? parent.id : null;
        }

        MShop.panel.AbstractListUi.prototype.onBeforeWrite.apply(this, arguments);
    },

    onContainerContextMenu : function(tree, e) {
        e.preventDefault();

        // deselect all selections
        this.getSelectionModel().clearSelections();

        this.getCtxMenu().showAt(e.getXY());
    },

    onContextMenu : function(node, e) {
        e.preventDefault();

        // select ctx node
        this.getSelectionModel().select(node);

        this.getCtxMenu().showAt(e.getXY());
    },

    onDeleteSelectedItems : function() {
        var that = this;

        Ext.Msg.show({
            title : MShop.I18n.dt('client/extjs', 'Delete items?'),
            msg : MShop.I18n.dt('client/extjs', 'You are going to delete one or more items. Would you like to proceed?'),
            buttons : Ext.Msg.YESNO,
            fn : function(btn) {
                if(btn == 'yes') {
                    var node = that.getSelectionModel().getSelectedNode(), root = that.getRootNode();

                    if(node) {
                        that.store.remove(that.store.getById(node.id));
                        if(node === root) {
                            that.getSelectionModel().clearSelections();

                            that.setRootNode(new Ext.tree.AsyncTreeNode({
                                id : 'root'
                            }));
                            that.getRootNode().getUI().hide();
                        } else {
                            node.remove(true);
                        }
                    }
                }
            },
            animEl : 'elId',
            icon : Ext.MessageBox.QUESTION
        });
    },

    onSelectionChange : function(sm, node) {
        this.actionAdd.setDisabled(!node && this.getRootNode().id !== 'root');
        this.actionEdit.setDisabled(!node);
        this.actionDelete.setDisabled(!node);
        this.actionExport.setDisabled(!this.exportMethod || !node);
        this.actionImport.setDisabled(!this.importMethod);
    },

    onStoreException : MShop.panel.AbstractListUi.prototype.onStoreException,

    onMoveNode : function(tree, node, oldParent, newParent, index) {
        var ref = node.nextSibling ? node.nextSibling.id : null;

        MShop.API[this.recordName].moveItems(MShop.config.site["locale.site.code"], node.id, oldParent.id,
            newParent.id, ref, function(success, response) {
                if(!success) {
                    this.onStoreException(null, null, null, null, response);
                }
            }, this);
    },

    onWrite : function(store, action, result, t, rs) {
        var selectedNode = this.getSelectionModel().getSelectedNode();

        Ext.each([].concat(rs), function(r) {
            var newNode = this.getLoader().createNode(r.data);
            switch(action) {
                case 'create':
                    if(selectedNode) {
                        selectedNode.ui.ecNode.style.visibility = 'visible';
                        selectedNode.appendChild(newNode);
                    } else {
                        this.setRootNode(newNode);
                    }
                    break;
                case 'update':
                    // @TODO: rethink update vs.
                    // recreate -> affects expands
                    // of subnodes
                    var oldNode = this.getNodeById(r.id);
                    if(oldNode === this.getRootNode()) {
                        this.setRootNode(newNode);
                    } else {
                        oldNode.parentNode.replaceChild(newNode, oldNode);
                    }
                    break;
                case 'destroy':
                    break; // do nothing
                default:
                    throw new Ext.Error(String.format(MShop.I18n.dt('client/extjs', 'Invalid action "{0}"'), action));
            }
        }, this);
    },

    onOpenEditWindow : function(action) {
        var record;

        if(action !== 'add') {
            record = this.store.getById(this.getSelectionModel().getSelectedNode().id);
        }

        var itemUi = Ext.ComponentMgr.create({
            xtype : 'MShop.panel.' + this.domain + '.itemui',
            record : record,
            action : this.action,
            treeUI : this,
            store : this.store
        });

        itemUi.show();
    },

    setDomainProperty : MShop.panel.AbstractListUi.prototype.setDomainProperty,
    setSiteParam : MShop.panel.AbstractListUi.prototype.setSiteParam
});
