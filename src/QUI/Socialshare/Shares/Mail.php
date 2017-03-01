<?php
/**
 * This file contains QUI\Socialshare\Shares\Mail
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Mail class for social share
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
class Mail extends Socialshare
{

    public function __construct($params = array())
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Mail');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getNamew()
     */
    public function getName()
    {
        return 'quiqqer-socialshare-mail';
    }

    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-mail');
    }

    public function getLogo()
    {
        return 'fa fa-at';
    }

    public function getShareUrl()
    {
        $Site      = QUI::getRewrite()->getSite();
        $Request   = QUI::getRequest();
        $baseUrl   = $Request->getScheme() . '://' .
            $Request->getHttpHost() . $Request->getBasePath() . $Site->getUrlRewritten();
        $siteTitle = QUI::getRewrite()->getSite()->getAttribute('title');

        return 'mailto:' . '?subject=' . $siteTitle . '&body=' . $baseUrl;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getCount()
     */
    public function getCount()
    {
        // todo man kann manuel einen Zähler setzten
        return false;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getCountUrl
     */
    public function getCountUrl()
    {
        return false;
    }
}
