<?php
/**
 * This file contains QUI\Socialshare\Shares\Pinterest
 */

namespace QUI\Socialshare\Shares;

use QUI\QDOM;
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
        

        $shareUrl = "ich will die URL von aktueler Seite";
        return 'https://facebook.com/sharer/sharer.php?u=' . $shareUrl;
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
