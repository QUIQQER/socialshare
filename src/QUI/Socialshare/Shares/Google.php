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
    public function __construct($params = array())
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Google');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \QUI\Socialshare\Socialshare::getName()
     */
    public function getName()
    {
        return 'quiqqer-socialshare-google';
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \QUI\Socialshare\Socialshare::getLabel()
     */
    public function getLabel()
    {
        $label = '+1';
        /*if (QUI::getLocale()->get('quiqqer-socialshare', 'label-google'))
        {
            $label = QUI::getLocale()->get('quiqqer-socialshare', 'label-google');
        }*/
        return $label;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \QUI\Socialshare\Socialshare::getLogo()
     */
    public function getLogo()
    {
        return 'fa fa-google';
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \QUI\Socialshare\Socialshare::getShareUrl()
     */
    public function getShareUrl()
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme(). '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];

        return 'https://plus.google.com/share?url=' . $baseurl;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \QUI\Socialshare\Socialshare::getCount()
     */
    public function getCount()
    {
        return '500k';
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \QUI\Socialshare\Socialshare::getCountUrl()
     */
    public function getCountUrl()
    {
        // TODO: Implement getCountUrl() method.
    }
}
