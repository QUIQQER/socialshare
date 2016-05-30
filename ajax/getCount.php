<?php

/**
 * This file contains package_quiqqer_socialshare_ajax_getCount
 */

/**
 *
 * @return string
 */
QUI::$Ajax->registerFunction(
    'package_quiqqer_socialshare_ajax_getCount',
    function ($social, $url) {
        $Social = null;

        $str = 'QUI\Socialshare\Shares\\'. $social;

        if (!class_exists($str)) {
            return 0;
        }

        $Social = new $str();

        if (is_null($Social)) {
            return 0;
        }

        return $Social->getCount();
    },
    array('social', 'url'),
    false // Rechte
);




