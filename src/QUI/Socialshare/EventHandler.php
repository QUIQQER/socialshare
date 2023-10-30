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

        $Template->extendHeader('<meta property="og:title" content="' . \htmlspecialchars($title) . '" />');
        $Template->extendHeader('<meta itemprop="name" content="' . \htmlspecialchars($title) . '" />');

        /**
         * Site short description
         */
        $description = $Site->getAttribute('short');

        if ($Site->getAttribute('quiqqer.socialshare.description')) {
            $description = $Site->getAttribute('quiqqer.socialshare.description');
        }

        $Template->extendHeader('<meta property="og:description" content="' . \htmlspecialchars($description) . '" />');
        $Template->extendHeader('<meta itemprop="description" content="' . \htmlspecialchars($description) . '" />');

        /**
         * Site type, e.g. "website", "article", "movie" etc.
         */
        $type = 'website';

        if ($Site->getAttribute('quiqqer.socialshare.type')) {
            $type = $Site->getAttribute('quiqqer.socialshare.type');
        }

        $Template->extendHeader('<meta property="og:type" content="' . \htmlspecialchars($type) . '" />');

        // itemscope itemtype="http://schema.org/WebPage"
        switch ($type) {
            case 'blog':
                $Site->setAttribute('meta.itemscope', 'http://schema.org/BlogPosting');
                break;

            case 'product':
                $Site->setAttribute('meta.itemscope', 'http://schema.org/Product');
                break;

            case 'movie':
                $Site->setAttribute('meta.itemscope', 'http://schema.org/Movie');
                break;

            case 'article':
                $Site->setAttribute('meta.itemscope', 'http://schema.org/Article');
                break;

            default:
            case 'website':
                $Site->setAttribute('meta.itemscope', 'http://schema.org/WebPage');
        }

        /**
         * Site url
         */
        if ($Site->getAttribute('quiqqer.socialshare.url')) {
            $url = $Site->getAttribute('quiqqer.socialshare.url');
        } else {
            $url = $baseurl . $Site->getUrlRewritten();
        }

        $Template->extendHeader('<meta property="og:url" content="' . $url . '" />');

        /**
         * Site name, e.g. "The New Yor Times"
         * Not the base url
         */
        if ($Project->getConfig('socialshare.settings.general.siteName')) {
            $Template->extendHeader(
                '<meta property="og:site_name" content="' .
                \htmlspecialchars($Project->getConfig('socialshare.settings.general.siteName')) . '" />'
            );
        }

        /**
         * Author
         */
        if ($Site->getAttribute('quiqqer.socialshare.author')) {
            $Template->extendHeader(
                '<meta property="article:author" content="' .
                \htmlspecialchars($Site->getAttribute('quiqqer.socialshare.author')) . '" />'
            );
        }

        /**
         * Image
         */
        $image = false;

        if ($Site->getAttribute('image_site')) {
            $image = $Site->getAttribute('image_site');
        }

        if ($Site->getAttribute('quiqqer.socialshare.image')) {
            $image = $Site->getAttribute('quiqqer.socialshare.image');
        }

        if (!$image) {
            $image = $Project->getConfig('socialshare.settings.general.standardImage');
        }

        try {
            $Image = QUI\Projects\Media\Utils::getImageByUrl($image);
            $image = $Image->getSizeCacheUrl();

            if (\strpos($image, '.svg') !== false) {
                $pngImage = $image . '.png';

                if (\file_exists(CMS_DIR . $pngImage)) {
                    $image = $baseurl . $pngImage;
                } elseif (\class_exists('\Imagick')) {
                    $svg = \file_get_contents(CMS_DIR . $image);

                    try {
                        $im = new \Imagick();
                        $im->readImageBlob($svg);
                        $im->setImageBackgroundColor(new \ImagickPixel('transparent'));
                        $im->setImageFormat("png24");
                        $im->writeImage(CMS_DIR . $pngImage);
                        $im->clear();
                        $im->destroy();

                        $image = $baseurl . $pngImage;
                    } catch (\Exception $Exception) {
                    }
                }
            }
        } catch (QUI\Exception $Exception) {
            // @todo Projekt Social Icon definieren
        }

        if (
            \strpos($image, 'http') !== 0 &&
            !QUI\Projects\Media\Utils::isMediaUrl($image)
        ) {
            $image = $baseurl . $image;
        }

        $Template->extendHeader('<meta property="og:image" content="' . $image . '" />');
        $Template->extendHeader('<meta itemprop="twitter:image" content="' . $image . '" />');
        $Template->extendHeader('<meta itemprop="image" content="' . $image . '" />');

        if (\strpos($image, 'https://') !== false) {
            $Template->extendHeader('<meta itemprop="og:image:secure" content="' . $image . '" />');
            $Template->extendHeader('<meta itemprop="og:image:secure_url" content="' . $image . '" />');
            $Template->extendHeader('<meta property="image:secure" content="' . $image . '" />');
            $Template->extendHeader('<meta property="image:secure_url" content="' . $image . '" />');
        }

        /**
         * Twitter cards
         */
        $card = 'summary';

        if ($Site->getAttribute('quiqqer.socialshare.twitter.card')) {
            $card = $Site->getAttribute('quiqqer.socialshare.twitter.card');
        }

        $Template->extendHeader('<meta name="twitter:card" content="' . \htmlspecialchars($card) . '" />');
    }
}
