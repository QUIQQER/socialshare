define('package/quiqqer/socialshare/bin/controls/Facebook', [

    'qui/QUI',
    'qui/controls/Control',
    'qui/controls/windows/Popup',
    'Ajax'

], function (QUI, QUIControl, QUIPopup, Ajax) {
    "use strict";

    return new Class({

        Extends: QUIControl,
        Type   : 'package/quiqqer/socialshare/bin/controls/Facebook',

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
            var self = this;

            this.$Count = this.getElm().getElement('.quiqqer-socialshare-count');

            this.getElm().addEvent('click', function (event) {
                event.stop();

                // var href = this.get('href');

                window.open(
                    this.get('href'),
                    'social',
                    'width=500,height=400, location=0, menubar=0, scrollbars=0, status=0, titlebar=0, toolbar=0'
                );

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

            this.refresh();
        },

        refresh: function () {
            return;
            Ajax.get('package_quiqqer_socialshare_ajax_getCount', function (result) {
                this.$Count.set('html', result);
            }.bind(this), {                                  // weitere Parameter
                         'package': 'quiqqer/socialshare', // was für ein Package das ist
                         url      : window.location.toString(),
                         social   : 'Facebook',
                         project  : JSON.encode(QUIQQER_PROJECT),
                         siteId   : QUIQQER_SITE.id
                     });
        }

    });
});
