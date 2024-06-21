<?php

/**
 * this file contains QUI\Socialshare\Shares\Digg
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Digg class for social share
 *
 * @author  www.pcsg.de (Torsten Fink)
 * @package quiqqer/socialshare
 */
class Digg extends Socialshare
{
    public function __construct(array $params = [])
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Digg');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName(): string
    {
        return 'quiqqer-socialshare-digg';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLabel
     */
    public function getLabel(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-digg');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLogo
     */
    public function getLogo(): string
    {
        return 'fa fa-digg';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getShareUrl
     */

    public function getShareUrl(): string
    {
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];

        return 'http://digg.com/submit?url=' . $baseurl;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getCount
     */
    public function getCount(): int
    {
        return 0;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getCountUrl
     */
    public function getCountUrl(): string
    {
        return '';
    }
}
