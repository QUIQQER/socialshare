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
    public function getName()
    {
        return 'quiqqer-socialshare-pinterest';
    }

    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-pinterest');
    }

    public function getLogo()
    {
        return 'fa fa-pinterest';
    }
    
    public function getShareUrl()
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];

        return 'https://pinterest.com/pin/create/button/?url=' . $baseurl;
    }
    
    public function getCount()
    {
        return "5,4k";
        // TODO: Implement getCount() method.
    }

    public function getCountUrl()
    {
        // TODO: Implement getCountUrl() method.
    }
}
