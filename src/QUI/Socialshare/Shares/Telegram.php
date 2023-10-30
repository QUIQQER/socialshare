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
    public function __construct($params = [])
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Telegram');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName()
    {
        return 'quiqqer-socialshare-telegram';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLabel
     */
    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-telegram');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLogo
     */
    public function getLogo()
    {
        return 'fa fa-telegram';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getShareUrl
     */

    public function getShareUrl()
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];

        return 'https://telegram.me/share/url?url=' . $baseurl;
    }

    /**
     * (non-PHPdoc)
     *
     * @return null
     * @see Socialshare::getCount
     */
    public function getCount()
    {
        return null;
    }

    /**
     * (non-PHPdoc)
     *
     * @return null
     * @see Socialshare::getCountUrl
     */
    public function getCountUrl()
    {
        return null;
    }
}
