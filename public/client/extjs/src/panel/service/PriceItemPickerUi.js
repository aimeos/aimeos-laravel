/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop.panel.service');

// hook price picker into the product ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.service.ItemUi', 'MShop.panel.service.PriceItemPickerUi', {
    xtype : 'MShop.panel.price.itempickerui',
    itemConfig : {
        recordName : 'Service_List',
        idProperty : 'service.list.id',
        siteidProperty : 'service.list.siteid',
        listNamePrefix : 'service.list.',
        listTypeIdProperty : 'service.list.type.id',
        listTypeLabelProperty : 'service.list.type.label',
        listTypeControllerName : 'Service_List_Type',
        listTypeCondition : {
            '&&' : [{
                '==' : {
                    'service.list.type.domain' : 'price'
                }
            }]
        },
        listTypeKey : 'service/list/type/price'
    },
    listConfig : {
        domain : 'service',
        prefix : 'price.'
    }
}, 30);
