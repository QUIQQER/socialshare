<?php

/**
 * This file contains \QUI\Socialshare\EventHandler
 */

namespace QUI\Socialshare;

use QUI;

/**
 * Class Events
 *
 * @author www.pcsg.de (Michael Danielczok)
 */
class EventHandler
{
    /**
     * @param \QUI\Template $Template
     */
    public static function onTemplateGetHeader($Template)
    {
        // Pinterest type
//        $Site = getSite();
//        $pinType = $Site->getAttribute('quiqqer.pin.type');
//        $Template->extendHeader('<meta property="og:type" content="' . $pinType . '" />', 1);
    }
}
