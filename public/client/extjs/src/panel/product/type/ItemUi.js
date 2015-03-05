/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://www.arcavias.com/license
 */

Ext.ns('MShop.panel.product.type');

MShop.panel.product.type.ItemUi = Ext.extend(MShop.panel.AbstractTypeItemUi, {
    siteidProperty : 'product.type.siteid',
    typeDomain : 'product.type',

    initComponent : function() {
        MShop.panel.AbstractTypeItemUi.prototype.setSiteCheck(this);
        MShop.panel.product.type.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['product.type.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Product type item panel title with type label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Product type: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.product.type.ItemUi.superclass.afterRender.apply(this, arguments);
    }
});

Ext.reg('MShop.panel.product.type.itemui', MShop.panel.product.type.ItemUi);
