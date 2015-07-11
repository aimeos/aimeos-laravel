/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @author Michael Spahn <m.spahn@metaways.de>
 */


Ext.ns('MShop.panel.plugin.type');

MShop.panel.plugin.type.ItemUi = Ext.extend(MShop.panel.AbstractTypeItemUi, {
    siteidProperty : 'plugin.type.siteid',
    typeDomain : 'plugin.type',

    initComponent : function() {
        MShop.panel.AbstractTypeItemUi.prototype.setSiteCheck(this);
        MShop.panel.plugin.type.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['plugin.type.label'] : MShop.I18n.dt('client/extjs', 'new');
        //#: Plugin type item panel title with type label ({0}) and site code ({1)}
        var string = MShop.I18n.dt('client/extjs', 'Plugin type: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.plugin.type.ItemUi.superclass.afterRender.apply(this, arguments);
    }
});

Ext.reg('MShop.panel.plugin.type.itemui', MShop.panel.plugin.type.ItemUi);
