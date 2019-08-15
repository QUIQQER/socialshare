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
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
class Twitter extends Socialshare
{
    public function __construct($params = array())
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Twitter');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getName()
     */
    public function getName()
    {
        return 'quiqqer-socialshare-twitter';
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getLabel()
     */
    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-tweeter');
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getLogo()
     */
    public function getLogo()
    {
        return 'fa fa-twitter';
    }

    /**
     * (non-PHPdoc)
     *
     * @return string
     */
    public function getShareUrl()
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];

        return 'https://twitter.com/intent/tweet?text=' . $baseurl;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getCount()
     * (no Twitter count)
     */
    public function getCount()
    {
        return;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getCountUrl()
     * (no Twitter count)
     */
    public function getCountUrl()
    {
        return;
    }
}
