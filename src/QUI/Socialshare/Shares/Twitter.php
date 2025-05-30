<?php

/**
 * This file contains QUI\Socialshare\Shares\Twitter
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Twitter class for social share
 *
 * Please note: Twitter was rebranded to X in April 2023
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
class Twitter extends Socialshare
{
    public function __construct(array $params = [])
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Twitter');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName(): string
    {
        return 'quiqqer-socialshare-twitter quiqqer-socialshare-x';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLabel
     */
    public function getLabel(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-tweeter');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLogo
     */
    public function getLogo(): string
    {
        return 'fa-brands fa-x-twitter';
    }

    /**
     * (non-PHPdoc)
     *
     * @return string
     */
    public function getShareUrl(): string
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];

        return 'https://twitter.com/intent/tweet?text=' . $baseurl;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getCount
     * (no Twitter count)
     */
    public function getCount(): int
    {
        return 0;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getCountUrl
     * (no Twitter count)
     */
    public function getCountUrl(): string
    {
        return '';
    }
}
