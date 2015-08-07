/*!
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos.org, 2015
 */


Ext.ns('MShop.panel.customer');

// hook media picker into the customer ItemUi
Ext.ux.ItemRegistry.registerItem('MShop.panel.customer.ItemUi', 'MShop.panel.customer.MediaItemPickerUi', {

	xtype : 'MShop.panel.media.itempickerui',
    itemConfig : {
        recordName : 'Customer_List',
        idProperty : 'customer.list.id',
        siteidProperty : 'customer.list.siteid',
        listDomain : 'customer',
        listNamePrefix : 'customer.list.',
        listTypeIdProperty : 'customer.list.type.id',
        listTypeLabelProperty : 'customer.list.type.label',
        listTypeControllerName : 'Customer_List_Type',
        listTypeCondition : {
            '&&' : [{
                '==' : {
                    'customer.list.type.domain' : 'media'
                }
            }]
        },
        listTypeKey : 'customer/list/type/media'
    },
    listConfig : {
        domain : 'customer',
        prefix : 'media.'
    }
}, 40);
