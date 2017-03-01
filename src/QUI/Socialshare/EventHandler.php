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
        $Site    = QUI::getRewrite()->getSite();
        $Project = $Site->getProject();
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost();

        /**
         * Site title
         */
        $title = $Site->getAttribute('meta.seotitle');
        if ($Site->getAttribute('quiqqer.socialshare.title')) {
            $title = $Site->getAttribute('quiqqer.socialshare.title');
        }
        $Template->extendHeader('<meta property="og:title" content="' .
            htmlspecialchars($title) . '" />');
        $Template->extendHeader('<meta itemprop="name" content="' .
            htmlspecialchars($title) . '" />');

        /**
         * Site short description
         */
        $description = $Site->getAttribute('short');
        if ($Site->getAttribute('quiqqer.socialshare.description')) {
            $description = $Site->getAttribute('quiqqer.socialshare.description');
        }
        $Template->extendHeader('<meta property="og:description" content="' .
            htmlspecialchars($description) . '" />');
        $Template->extendHeader('<meta itemprop="description" content="' .
            htmlspecialchars($description) . '" />');

        /**
         * Site type, e.g. "website", "article", "movie" etc.
         */
        $type = 'website';
        if ($Site->getAttribute('quiqqer.socialshare.type')) {
            $type = $Site->getAttribute('quiqqer.socialshare.type');
        }
        $Template->extendHeader('<meta property="og:type" content="' .
            htmlspecialchars($type) . '" />');

        /**
         * Site url
         */
        $url = $baseurl . $Site->getUrlRewritten();
        $Template->extendHeader('<meta property="og:url" content="' . $url . '" />');

        /**
         * Site name, e.g. "The New Yor Times"
         * Not the base url
         */
        if ($Project->getAttribute('socialshare.settings.general.siteName')) {
            $Template->extendHeader('<meta property="og:site_name" content="' .
                htmlspecialchars($Project->getAttribute('socialshare.settings.general.siteName')) .
                '" />');
        }

        /**
         * Author
         */
        if ($Site->getAttribute('quiqqer.socialshare.author')) {
            $Template->extendHeader('<meta property="article:author" content="' .
                htmlspecialchars($Site->getAttribute('quiqqer.socialshare.author')) . '" />');
        }

        /**
         * Image
         */
        $image = $Site->getAttribute('image_site');
        if ($Site->getAttribute('quiqqer.socialshare.image')) {
            $image = $Site->getAttribute('quiqqer.socialshare.image');
        }

        try {
            $Image = QUI\Projects\Media\Utils::getImageByUrl($image);
            $image = $Image->getSizeCacheUrl();
        } catch (QUI\Exception $Exception) {
            // @todo Projekt Social Icon definieren
        }

        $Template->extendHeader('<meta property="og:image" content="' . $baseurl . $image . '" />');
        $Template->extendHeader('<meta itemprop="image" content="' . $baseurl . $image . '" />');


        /**
         * Twitter cards
         */
        $card = 'summary';
        if ($Site->getAttribute('quiqqer.socialshare.twitter.card')) {
            $card = $Site->getAttribute('quiqqer.socialshare.twitter.card');
        }
        $Template->extendHeader('<meta name="twitter:card" content="' .
            htmlspecialchars($card) . '" />');
    }
}
