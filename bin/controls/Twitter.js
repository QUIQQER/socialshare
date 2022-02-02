define('package/quiqqer/socialshare/bin/controls/Twitter', [

    'qui/QUI',
    'qui/controls/Control'

], function (QUI, QUIControl) {
    "use strict";

    return new Class({

        Extends: QUIControl,
        Type   : 'package/quiqqer/socialshare/bin/controls/Twitter',

        Binds: [
            '$onImport'
        ],

        initialize: function () {
            this.addEvents({
                onImport: this.$onImport
            });
        },

        $onImport: function () {
            this.getElm().addEvent('click', function (event) {
                event.stop();

                window.open(this.get('href'), 'social', 'width=500,height=400');
            });
        }
    });
});