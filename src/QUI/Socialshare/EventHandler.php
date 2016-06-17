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
        $Site = QUI::getRewrite()->getSite();
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost();

//        var_dump($Site->getAttributes());

        /**
         * Site title
         */
        $title = $Site->getAttribute('quiqqer.socialshare.title');
        if (!$title) {
            $title = $Site->getAttribute('title');
        }
        $Template->extendHeader('<meta property="og:title" content="' . $title . '" />');
        $Template->extendHeader('<meta itemprop="name" content="' . $title . '" />');

        /**
         * Site short description
         */
        $description = $Site->getAttribute('quiqqer.socialshare.description');
        if (!$description) {
            $description = $Site->getAttribute('short');
        }
        $Template->extendHeader('<meta property="og:description" content="' . $description . '" />');
        $Template->extendHeader('<meta itemprop="description" content="' . $description . '" />');

        /**
         * Site type, e.g. "website", "article", "movie" etc.
         */
        $type = $Site->getAttribute('quiqqer.socialshare.type');
        $Template->extendHeader('<meta property="og:type" content="' . $type . '" />');

        /**
         * Site url
         */
        $url = $baseurl . $Site->getUrlRewritten();
        $Template->extendHeader('<meta property="og:url" content="' . $url . '" />');

        /**
         * Site name, e.g. "The New Yor Times"
         * Not the base url
         */
//        $sitename = $Site->
//        echo $sitename;

        /**
         * Author
         */
        $author = $Site->getAttribute('quiqqer.socialshare.author');
        if ($author != null) {
            $Template->extendHeader('<meta property="og:author" content="' . $author . '" />');
        }

        /**
         * Image
         */
        $image = $Site->getAttribute('quiqqer.socialshare.image');
        if (!$image) {
            $image = $Site->getAttribute('image_site');
        }
        $image = $baseurl . '/' . $image;
        $Template->extendHeader('<meta property="og:image" content="' . $image . '" />');
        $Template->extendHeader('<meta itemprop="image" content="' . $image . '" />');

        /**
         * Twitter cards
         */
        $card = $Site->getAttribute('quiqqer.socialshare.twitter.card');
        $Template->extendHeader('<meta name="twitter:card" content="' . $card . '" />');

        /**
         * Twitter user
         */
        $user = $Site->getAttribute('quiqqer.socialshare.twitter.site');
        if ($user != null) {
            $Template->extendHeader('<meta name="twitter:site" content="@' . $user . '" />');
            $Template->extendHeader('<meta name="twitter:creator" content="@' . $user . '" />');
        }
    }
}
