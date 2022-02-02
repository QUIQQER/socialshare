define('package/quiqqer/socialshare/bin/controls/Reddit', [

    'qui/QUI',
    'qui/controls/Control'

], function (QUI, QUIControl) {
    "use strict";

    return new Class({

        Extends: QUIControl,
        Type   : 'package/quiqqer/socialshare/bin/controls/Reddit',

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
                    'width=500,height=400, location=0, menubar=0, scrollbars=0, status=0, titlebar=0, toolbar=0'
                );
            });

            this.refresh();
        },

        refresh: function () {
            return false; // todo
            /*Ajax.get('package_quiqqer_socialshare_ajax_getCount', function (result) {
                this.$Count.set('html', result);
            }.bind(this), {                                  // weitere Parameter
                'package': 'quiqqer/socialshare', // was für ein Package das ist
                url      : window.location.toString(),
                social   : 'Reddit',
                project  : JSON.encode(QUIQQER_PROJECT),
                siteId   : QUIQQER_SITE.id
            });*/
        }
    });
});