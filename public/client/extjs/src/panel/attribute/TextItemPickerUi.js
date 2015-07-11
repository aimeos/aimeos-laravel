/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.attribute');

// hook text picker into the attribute ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.attribute.ItemUi', 'MShop.panel.attribute.TextItemPickerUi', {
    xtype : 'MShop.panel.text.itempickerui',
    itemConfig : {
        recordName : 'Attribute_List',
        idProperty : 'attribute.list.id',
        siteidProperty : 'attribute.list.siteid',
        listNamePrefix : 'attribute.list.',
        listTypeIdProperty : 'attribute.list.type.id',
        listTypeLabelProperty : 'attribute.list.type.label',
        listTypeControllerName : 'Attribute_List_Type',
        listTypeCondition : {
            '&&' : [{
                '==' : {
                    'attribute.list.type.domain' : 'text'
                }
            }]
        },
        listTypeKey : 'attribute/list/type/text'
    },
    listConfig : {
        domain : 'attribute',
        prefix : 'text.'
    }
}, 10);
