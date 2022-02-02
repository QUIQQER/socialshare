define('package/quiqqer/socialshare/bin/controls/Pinterest', [

    'qui/QUI',
    'qui/controls/Control'

], function (QUI, QUIControl) {
    "use strict";

    return new Class({

        Extends: QUIControl,
        Type   : 'package/quiqqer/socialshare/bin/controls/Pinterest',

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

                window.open(
                    this.get('href'),
                    'social',
                    'width=750,height=540,location=0, menubar=0, resizeable=0, scrollbars=0, status=0, titlebar=0, toolbar=0'
                );
            });

        }
    });
});