/**
 * Generic social share button.
 *
 * Opens the share target of the control's <a> element in a centered popup
 * window instead of navigating away from the current page. The same control
 * is used for every network; the network-specific data (url, icon, label) is
 * rendered server-side, so no per-network JavaScript is needed.
 *
 * @module package/quiqqer/socialshare/bin/controls/Share
 */
define('package/quiqqer/socialshare/bin/controls/Share', [

    'qui/controls/Control'

], function (QUIControl) {
    "use strict";

    const POPUP_WIDTH = 600;
    const POPUP_HEIGHT = 500;

    return new Class({

        Extends: QUIControl,
        Type: 'package/quiqqer/socialshare/bin/controls/Share',

        Binds: [
            '$onImport',
            '$onClick'
        ],

        initialize: function () {
            this.addEvents({
                onImport: this.$onImport
            });
        },

        $onImport: function () {
            this.getElm().addEventListener('click', this.$onClick);
        },

        /**
         * @param {Event} event
         */
        $onClick: function (event) {
            const href = this.getElm().getAttribute('href');

            if (!href) {
                return;
            }

            event.preventDefault();

            const left = window.screenX + Math.max(0, (window.outerWidth - POPUP_WIDTH) / 2);
            const top = window.screenY + Math.max(0, (window.outerHeight - POPUP_HEIGHT) / 2);

            const features = 'width=' + POPUP_WIDTH +
                ',height=' + POPUP_HEIGHT +
                ',left=' + left +
                ',top=' + top +
                ',location=0,menubar=0,scrollbars=0,status=0,titlebar=0,toolbar=0';

            const ShareWindow = window.open(href, 'socialshare', features);

            if (ShareWindow) {
                ShareWindow.focus();
            }
        }
    });
});
