<?php

/**
 * This file contains QUI\Socialshare\Shares\Pinterest
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Pinterest class for social share
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
class Pinterest extends Socialshare
{
    /**
     * @param array<string, mixed> $params
     */
    public function __construct(array $params = [])
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Share');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName(): string
    {
        return 'quiqqer-socialshare__link--pinterest';
    }

    /**
     *
     *
     * @return string
     */
    public function getLabel(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-pinterest');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getShareTitle
     */
    public function getShareTitle(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'share-title-pinterest');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLogo
     */
    public function getLogo(): string
    {
        return 'fa-brands fa-pinterest';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getShareUrl
     */
    public function getShareUrl(): string
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];

        return 'https://pinterest.com/pin/create/button/?url=' . $baseurl;
    }
}
