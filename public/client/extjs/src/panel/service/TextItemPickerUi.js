/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */

Ext.ns('MShop.panel.service');

//hook text picker into the product ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.service.ItemUi', 'MShop.panel.service.TextItemPickerUi', {
    xtype : 'MShop.panel.text.itempickerui',
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
                    'service.list.type.domain' : 'text'
                }
            }]
        },
        listTypeKey : 'service/list/type/text'
    },
    listConfig : {
        domain : 'service',
        prefix : 'text.'
    }
}, 10);
