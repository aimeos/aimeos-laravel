/*!
 * Copyright (c) Metaways Infosystems GmbH, 2014
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

Ext.ns('MShop');

MShop.I18n = {

    lang : 'en',
    tx : {},

    init : function(content, lang) {

        this.lang = lang;
        this.tx = content;
    },

    dt : function(domain, string) {

        if(this.tx[domain] && this.tx[domain][string]) {

            if(this.tx[domain][string][0] && typeof this.tx[domain][string] === 'object') {
                return this.tx[domain][string][0];
            }

            if(typeof this.tx[domain][string] === 'string') {
                return this.tx[domain][string];
            }
        }

        return string;
    },

    dn : function(domain, singular, plural, num) {

        var index = this.getPluralIndex(num, this.lang);

        if(this.tx[domain] && this.tx[domain][singular]) {

            if(this.tx[domain][singular][index] && typeof this.tx[domain][singular] === 'object') {
                return this.tx[domain][singular][index];
            }

        } else {

            if(index > 0) {
                return plural;
            }
        }

        return singular;
    },

    getPluralIndex : function(num, lang) {

        num = Math.abs(Number(num));

        if(lang === 'pt_BR') {
            lang = 'xbr'; // temporary set a lang for brasilian
        }

        if(lang.length > 3) {
            lang = lang.replace(/_.+/g, '');
        }

        switch(lang) {

            case 'af':
            case 'az':
            case 'bn':
            case 'bg':
            case 'ca':
            case 'da':
            case 'de':
            case 'el':
            case 'en':
            case 'eo':
            case 'es':
            case 'et':
            case 'eu':
            case 'fa':
            case 'fi':
            case 'fo':
            case 'fur':
            case 'fy':
            case 'gl':
            case 'gu':
            case 'ha':
            case 'he':
            case 'hu':
            case 'is':
            case 'it':
            case 'ku':
            case 'lb':
            case 'ml':
            case 'mn':
            case 'mr':
            case 'nah':
            case 'nb':
            case 'ne':
            case 'nl':
            case 'nn':
            case 'no':
            case 'om':
            case 'or':
            case 'pa':
            case 'pap':
            case 'ps':
            case 'pt':
            case 'so':
            case 'sq':
            case 'sv':
            case 'sw':
            case 'ta':
            case 'te':
            case 'tk':
            case 'ur':
            case 'zu':
                return (num === 1) ? 0 : 1;

            case 'am':
            case 'bh':
            case 'fil':
            case 'fr':
            case 'gun':
            case 'hi':
            case 'ln':
            case 'mg':
            case 'nso':
            case 'xbr':
            case 'ti':
            case 'wa':
                return ((num === 0) || (num === 1)) ? 0 : 1;

            case 'be':
            case 'bs':
            case 'hr':
            case 'ru':
            case 'sr':
            case 'uk':
                return ((num % 10 === 1) && (num % 100 !== 11)) ? 0 : (((num % 10 >= 2) && (num % 10 <= 4) && ((num % 100 < 10) || (num % 100 >= 20))) ? 1 : 2);

            case 'cs':
            case 'sk':
                return (num === 1) ? 0 : (((num >= 2) && (num <= 4)) ? 1 : 2);

            case 'ar':
                return (num === 0) ? 0 : ((num === 1) ? 1 : ((num === 2) ? 2 : (((num >= 3) && (num <= 10)) ? 3 : (((num >= 11) && (num <= 99)) ? 4 : 5))));

            case 'cy':
                return (num === 1) ? 0 : ((num === 2) ? 1 : (((num === 8) || (num === 11)) ? 2 : 3));

            case 'ga':
                return (num === 1) ? 0 : ((num === 2) ? 1 : 2);

            case 'lt':
                return ((num % 10 === 1) && (num % 100 !== 11)) ? 0 : (((num % 10 >= 2) && ((num % 100 < 10) || (num % 100 >= 20))) ? 1 : 2);

            case 'lv':
                return (num === 0) ? 0 : (((num % 10 === 1) && (num % 100 !== 11)) ? 1 : 2);

            case 'mk':
                return (num % 10 === 1) ? 0 : 1;

            case 'mt':
                return (num === 1) ? 0 : (((num === 0) || ((num % 100 > 1) && (num % 100 < 11))) ? 1 : (((num % 100 > 10) && (num % 100 < 20)) ? 2 : 3));

            case 'pl':
                return (num === 1) ? 0 : (((num % 10 >= 2) && (num % 10 <= 4) && ((num % 100 < 12) || (num % 100 > 14))) ? 1 : 2);

            case 'ro':
                return (num === 1) ? 0 : (((num === 0) || ((num % 100 > 0) && (num % 100 < 20))) ? 1 : 2);

            case 'sl':
                return (num % 100 === 1) ? 0 : ((num % 100 === 2) ? 1 : (((num % 100 === 3) || (num % 100 === 4)) ? 2 : 3));

            default:
                return 0;
        }
    }
};
