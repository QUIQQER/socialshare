<?php

/**
 * this file contains QUI\Socialshare\Shares\Telegram
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Telegram class for social share
 *
 * @author  www.pcsg.de (Henning Leutz)
 * @package quiqqer/socialshare
 */
class Telegram extends Socialshare
{
    public function __construct(array $params = [])
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Telegram');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName(): string
    {
        return 'quiqqer-socialshare-telegram';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLabel
     */
    public function getLabel(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-telegram');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLogo
     */
    public function getLogo(): string
    {
        return 'fa fa-telegram';
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

        return 'https://telegram.me/share/url?url=' . $baseurl;
    }

    public function getCount(): int
    {
        return 0;
    }

    public function getCountUrl(): string
    {
        return '';
    }
}
