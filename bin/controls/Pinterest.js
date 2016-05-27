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
            this.addEvents({
                               onImport: this.$onImport
                           });
        },

        $onImport: function () {
            var self = this;

            this.getElm().addEvent('click', function (event) {
                event.stop();

                // var href = this.get('href');

                window.open(this.get('href'), 'social', 'width=750,height=540');

                // var Popup = new QUIPopup({
                //     title : 'huhu',
                //     icon  : 'fa fa-trash',
                //     events: {
                //         onOpen: function (Win) {
                //             new Element('iframe', {
                //                 styles: {},
                //                 src   : href
                //             }).inject(Win.getContent());
                //         }
                //     }
                // });
                //
                // Popup.open();
                //
                // (function() {
                //     Popup.setAttribute('maxWidth', 200);
                //     Popup.setAttribute('maxHeight', 200);
                //     Popup.resize();
                // }).delay(3000);
            });

        }
    });

});