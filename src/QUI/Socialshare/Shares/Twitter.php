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
    public function getName()
    {
        return 'quiqqer-socialshare-twitter';
    }

    public function getLabel()
    {
        $label = "Tweet";
        /*if (QUI::getLocale()->get('quiqqer-socialshare', 'label-twitter'))
        {
            $label = QUI::getLocale()->get('quiqqer-socialshare', 'label-twitter');
            echo $label;
        }*/
        return $label;
    }

    public function getLogo()
    {
        return 'fa fa-twitter';
    }
    
    public function getShareUrl()
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];
        
        return 'https://twitter.com/home?status=' . $baseurl;
    }

    // No counter for Twitter
    public function getCount()
    {
        return;
    }

    public function getCountUrl()
    {
        // TODO: Implement getCountUrl() method.
    }
}
