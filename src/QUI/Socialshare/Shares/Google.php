<?php
/**
 * This file contains QUI\Socialshare\Shares\Google
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Google class for social share
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */

class Google extends Socialshare
{
    public function getName()
    {
        return 'quiqqer-socialshare-google';
    }

    public function getLabel()
    {
        $label = '+1';
        /*if (QUI::getLocale()->get('quiqqer-socialshare', 'label-google'))
        {
            $label = QUI::getLocale()->get('quiqqer-socialshare', 'label-google');
        }*/
        return $label;
    }

    public function getLogo()
    {
        return 'fa fa-google';
    }

    public function getShareUrl()
    {
        // TODO: Implement getShareUrl() method.
    }

    public function getCount()
    {
        // TODO: Implement getCount() method.
    }

    public function getCountUrl()
    {
        // TODO: Implement getCountUrl() method.
    }
}