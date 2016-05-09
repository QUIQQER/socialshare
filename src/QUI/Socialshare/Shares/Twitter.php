<?php

/**
 * This file contains QUI\Socialshare\Shares\Twitter
 */

namespace QUI\Socialshare\Share;

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
    public function getName()
    {
        return 'quiqqer-socialshare-twitter';
    }

    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer-socialshare', 'label-twitter');
    }

    public function getLogo()
    {
        return 'fa-twitter';
    }

    public function getCountUrl()
    {
        // TODO: Implement getCountUrl() method.
    }

    public function getShareUrl()
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];
        echo $baseurl;
        return 'https://twitter.com/home?status=' . $baseurl;
    }

    public function getCount()
    {
        // TODO: Implement getCount() method.
    }
}
