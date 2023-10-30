<?php

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Wordpress class for social share
 *
 * @author  www.pcsg.de (Torsten Fink)
 * @package quiqqer/socialshare
 */
class WordPress extends Socialshare
{
    public function __construct($params = [])
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/WordPress');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName()
    {
        return 'quiqqer-socialshare-wordpress';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLabel
     */
    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-wordpress');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLogo
     */
    public function getLogo()
    {
        return 'fa fa-wordpress';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getShareUrl
     */

    public function getShareUrl()
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];

        return 'https://wordpress.com/wp-admin/press-this.php?u=' . $baseurl;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getCount
     */
    public function getCount()
    {
        return null;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getCountUrl
     */
    public function getCountUrl()
    {
        return null;
    }
}
