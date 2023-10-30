<?php

/**
 * This file contains package_quiqqer_socialshare_ajax_getCount
 */

/**
 *
 * @param string $social - social name
 * @param string $url - url
 *
 * @return string
 */
QUI::$Ajax->registerFunction(
    'package_quiqqer_socialshare_ajax_getCount',
    function ($social, $url, $project, $siteId) {
        return 0;

        // wird später implimentiert
        $Social = null;
        $Project = QUI::getProjectManager()->decode($project);
        $Site = $Project->get($siteId);

        $str = 'QUI\Socialshare\Shares\\' . $social;

        if (!class_exists($str)) {
            return 0;
        }

        /* @var $Social QUI\Socialshare\Socialshare */
        $Social = new $str();
        $Social->setAttribute('Site', $Site);

        if (is_null($Social)) {
            return 0;
        }

        return $Social->getCount();
    },
    ['social', 'url', 'project', 'siteId'],
    false // Rechte
);
