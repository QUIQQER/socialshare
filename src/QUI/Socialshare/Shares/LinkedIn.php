<?php

/**
 * This file contains QUI\Socialshare\Shares\LinkedIn
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Exception;
use QUI\Socialshare\Socialshare;

/**
 * LinkedIn class for social share
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
class LinkedIn extends Socialshare
{
    /**
     * @param array<string, mixed> $params
     */
    public function __construct(array $params = [])
    {
        // todo social share counter
//        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/LinkedIn');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName(): string
    {
        return 'quiqqer-socialshare__link--linkedin';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLabel
     */
    public function getLabel(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-linkedin');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getShareTitle
     */
    public function getShareTitle(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'share-title-linkedin');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLogo
     */
    public function getLogo(): string
    {
        return 'fa-brands fa-linkedin';
    }

    /**
     * (non-PHPdoc)
     *
     * @throws Exception
     * @see Socialshare::getShareUrl
     */

    public function getShareUrl(): string
    {
        $Site = $this->getSite();
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = urlencode($baseurl . $_SERVER['REQUEST_URI']);

        $title = 'title=' . urlencode($Site->getAttribute('title'));
        $summary = 'summary=' . urlencode($Site->getAttribute('desc'));

        return 'https://www.linkedin.com/shareArticle?mini=true&url=' . $baseurl . '&' . $title . '&' . $summary;
    }
}
