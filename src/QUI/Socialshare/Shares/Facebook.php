<?php
/**
 * This file contains QUI\Socialshare\Shares\Facebook
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Facebook class for social share
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
class Facebook extends Socialshare
{
    public function getCountUrl()
    {
        // TODO: Implement getCountUrl() method.
    }

    public function getCount()
    {
        // TODO: Implement getCount() method.
    }

    public function getShareUrl()
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];

        return 'https://facebook.com/sharer/sharer.php?u=' . $baseurl;
    }

    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-facebook');
    }

    public function getLogo()
    {
        return 'fa fa-facebook';
    }
}
