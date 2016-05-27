define('package/quiqqer/socialshare/bin/controls/Google', [

    'qui/QUI',
    'qui/controls/Control'

], function (QUI, QUIControl) {
    "use strict";

    return new Class({

        Extends: QUIControl,
        Type   : 'package/quiqqer/socialshare/bin/controls/Google',

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
                var link1 = 'http://t3n.de/news/wirecutter-affiliate-publishing-710067/';
                var link2 = 'http://www.dw.com/de/g7-droht-russland-mit-weiteren-sanktionen/a-19285537';
                var link3 = 'http://technowinki.onet.pl/militaria/uss-zumwalt-amerykanska-marynarka-wprowadza-do-sluzby-niezwykly-okret/719erw';
                var link4 = 'http://www.sueddeutsche.de/wissen/regierung-in-der-kritik-australien-streicht-verweise-auf-klimaschaeden-in-un-bericht-1.3008012'
                var href = 'https://plus.google.com/share?url=' + link4;
                window.open(href, 'social', 'height=700,width=492');
                console.log('href');
            });
        }
    });
});