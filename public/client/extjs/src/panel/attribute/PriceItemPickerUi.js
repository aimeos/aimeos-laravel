/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */


Ext.ns('MShop.panel.attribute');

// hook price picker into the attribute ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.attribute.ItemUi', 'MShop.panel.attribute.PriceItemPickerUi', {
    xtype : 'MShop.panel.price.itempickerui',
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
                    'attribute.list.type.domain' : 'media'
                }
            }]
        },
        listTypeKey : 'attribute/list/type/media'
    },
    listConfig : {
        domain : 'attribute',
        prefix : 'price.'
    }
}, 30);
