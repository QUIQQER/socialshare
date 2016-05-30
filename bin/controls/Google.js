define('package/quiqqer/socialshare/bin/controls/Google', [

    'qui/QUI',
    'qui/controls/Control',
    'Ajax'

], function (QUI, QUIControl, Ajax) {
    "use strict";

    return new Class({

        Extends: QUIControl,
        Type   : 'package/quiqqer/socialshare/bin/controls/Google',

        Binds: [
            '$onImport'
        ],

        initialize: function () {
            this.$Count = null;

            this.addEvents({
                               onImport: this.$onImport
                           });
        },

        $onImport: function () {
            this.$Count = this.getElm().getElement('.quiqqer-socialshare-count');

            this.getElm().addEvent('click', function (event) {
                event.stop();
                window.open(this.get('href'), 'social', 'height=700,width=492');
            });

            this.refresh();
        },

        refresh: function () {
            Ajax.get('package_quiqqer_socialshare_ajax_getCount', function (result) {
                this.$Count.set('html', result);
            }.bind(this), {
                         'package': 'quiqqer/socialshare',
                         url      : window.location.toString(),
                         social   : 'Google'
                     });
        }
    });
});
