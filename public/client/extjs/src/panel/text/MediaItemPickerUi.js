/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://www.arcavias.com/en/license
 */

Ext.ns('MShop.panel.text');

// hook media picker into the text ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.text.ItemUi', 'MShop.panel.text.MediaItemPickerUi', {
    xtype : 'MShop.panel.media.itempickerui',
    itemConfig : {
        recordName : 'Text_List',
        idProperty : 'text.list.id',
        siteidProperty : 'text.list.siteid',
        listNamePrefix : 'text.list.',
        listTypeIdProperty : 'text.list.type.id',
        listTypeLabelProperty : 'text.list.type.label',
        listTypeControllerName : 'Text_List_Type',
        listTypeCondition : {
            '&&' : [{
                '==' : {
                    'text.list.type.domain' : 'media'
                }
            }]
        },
        listTypeKey : 'text/list/type/media'
    },
    listConfig : {
        domain : 'text',
        prefix : 'media.'
    }
}, 20);
