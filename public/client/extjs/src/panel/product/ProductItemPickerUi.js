/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel.product');

// hook product picker into the product ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.product.ItemUi', 'MShop.panel.product.ProductItemPickerUi', {
    xtype : 'MShop.panel.product.itempickerui',
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
                    'product.list.type.domain' : 'product'
                }
            }]
        },
        listTypeKey : 'product/list/type/product'
    },
    listConfig : {
        prefix : 'product.'
    }
}, 40);
