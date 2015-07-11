/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.catalog');

// hook text picker into the catalog ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.catalog.ItemUi', 'MShop.panel.catalog.TextItemPickerUi', {
    xtype : 'MShop.panel.text.itempickerui',
    itemConfig : {
        recordName : 'Catalog_List',
        idProperty : 'catalog.list.id',
        siteidProperty : 'catalog.list.siteid',
        listNamePrefix : 'catalog.list.',
        listTypeIdProperty : 'catalog.list.type.id',
        listTypeLabelProperty : 'catalog.list.type.label',
        listTypeControllerName : 'Catalog_List_Type',
        listTypeCondition : {
            '&&' : [{
                '==' : {
                    'catalog.list.type.domain' : 'text'
                }
            }]
        },
        listTypeKey : 'catalog/list/type/text'
    },
    listConfig : {
        domain : 'catalog',
        prefix : 'text.'
    }
}, 10);
