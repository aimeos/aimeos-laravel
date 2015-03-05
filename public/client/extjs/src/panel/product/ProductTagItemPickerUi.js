/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */

Ext.ns('MShop.panel.product');

// hook product tag picker into the product ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.product.ItemUi', 'MShop.panel.product.ProductTagItemPickerUi', {
    xtype : 'MShop.panel.product.tag.itempickerui',
    itemConfig : {
        recordName : 'Product_List',
        idProperty : 'product.list.id',
        siteidProperty : 'product.list.siteid',
        listNamePrefix : 'product.list.',
        listTypeIdProperty : 'product.list.type.id',
        listTypeLabelProperty : 'product.list.type.label',
        listTypeControllerName : 'Product_List_Type',
        listTypeCondition : {
            '&&' : [{
                '==' : {
                    'product.list.type.domain' : 'product/tag'
                }
            }]
        },
        listTypeKey : 'product/list/type/product/tag'
    },
    listConfig : {
        prefix : 'product.tag.'
    }
}, 100);
