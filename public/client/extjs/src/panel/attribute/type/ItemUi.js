/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://www.arcavias.com/license
 * @author Michael Spahn <m.spahn@metaways.de>
 */

Ext.ns('MShop.panel.attribute.type');

MShop.panel.attribute.type.ItemUi = Ext.extend(MShop.panel.AbstractTypeItemUi, {

    siteidProperty : 'attribute.type.siteid',

    typeDomain : 'attribute.type',

    initComponent : function() {
        MShop.panel.AbstractTypeItemUi.prototype.setSiteCheck(this);
        MShop.panel.attribute.type.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['attribute.type.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Attribute type item panel title with type label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Attribute type: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.attribute.type.ItemUi.superclass.afterRender.apply(this, arguments);
    }
});

Ext.reg('MShop.panel.attribute.type.itemui', MShop.panel.attribute.type.ItemUi);
