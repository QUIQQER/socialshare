<?php

/**
 * This file contains \QUI\Socialshare\EventHandler
 */

namespace QUI\Socialshare;

use QUI;
use QUI\Socialshare\Socialshare;

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
        $Site = QUI::getRewrite()->getSite();



        $title = $Site->getAttribute('quiqqer.socialshare.title');
        echo $title;
//        $Template->extendHeader('<meta property="og:title" content="' . "DUPA DUPA". '" />', 1);
//echo $Site;
    }
}
