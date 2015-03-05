/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://www.arcavias.com/license
 * @author Michael Spahn <m.spahn@metaways.de>
 */


Ext.ns('MShop.panel.media.type');

MShop.panel.media.type.ItemUi = Ext.extend(MShop.panel.AbstractTypeItemUi, {
    siteidProperty : 'media.type.siteid',
    typeDomain : 'media.type',

    initComponent : function() {
        MShop.panel.AbstractTypeItemUi.prototype.setSiteCheck(this);
        MShop.panel.media.type.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['media.type.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Media type item panel title with type label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Media type: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.media.type.ItemUi.superclass.afterRender.apply(this, arguments);
    }
});

Ext.reg('MShop.panel.media.type.itemui', MShop.panel.media.type.ItemUi);
