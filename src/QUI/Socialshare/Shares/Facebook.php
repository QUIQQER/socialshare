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
    public function __construct($params = array())
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Facebook' );
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \QUI\Socialshare\Socialshare::getName()
     */
    public function getName()
    {
        return 'quiqqer-socialshare-facebook';
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \QUI\Socialshare\Socialshare::getLabel()
     */
    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-facebook');
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \QUI\Socialshare\Socialshare::getLogo()
     */
    public function getLogo()
    {
        return 'fa fa-facebook';
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \QUI\Socialshare\Socialshare::getShareUrl()
     */

    public function getShareUrl()
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];

        return 'https://facebook.com/sharer/sharer.php?u=' . $baseurl;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \QUI\Socialshare\Socialshare::getCount()
     */
    public function getCount()
    {
        return '123'; // Test zuerst
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
