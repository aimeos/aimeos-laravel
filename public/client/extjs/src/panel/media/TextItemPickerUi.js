/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.media');

// hook text picker into the media ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.media.ItemUi', 'MShop.panel.media.TextItemPickerUi', {
    xtype : 'MShop.panel.text.itempickerui',
    itemConfig : {
        recordName : 'Media_List',
        idProperty : 'media.list.id',
        siteidProperty : 'media.list.siteid',
        listDomain : 'media',
        listNamePrefix : 'media.list.',
        listTypeIdProperty : 'media.list.type.id',
        listTypeLabelProperty : 'media.list.type.label',
        listTypeControllerName : 'Media_List_Type',
        listTypeCondition : {
            '&&' : [{
                '==' : {
                    'media.list.type.domain' : 'text'
                }
            }]
        },
        listTypeKey : 'media/list/type/text'
    },
    listConfig : {
        domain : 'media',
        prefix : 'text.'
    }
}, 10);
