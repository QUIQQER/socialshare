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
        $shareUrl = "brauche die URL von aktueler Seite";
        return '' . $shareUrl;
    }

    public function getLogo()
    {
        return 'fa pinterest';
    }

    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-pinterest');
    }
}
