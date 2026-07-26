<?php

/**
 * This file contains QUI\Socialshare\Shares\Xing
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Xing class for social share
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
class Xing extends Socialshare
{
    /**
     * @param array<string, mixed> $params
     */
    public function __construct(array $params = [])
    {
        // todo social share counter
//        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Xing');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName(): string
    {
        return 'quiqqer-socialshare__link--xing';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLabel
     */
    public function getLabel(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-xing');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getShareTitle
     */
    public function getShareTitle(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'share-title-xing');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLogo
     */
    public function getLogo(): string
    {
        return 'fa-brands fa-xing';
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
        $baseurl = urlencode($baseurl . $_SERVER['REQUEST_URI']);

        return 'https://www.xing.com/spi/shares/new?url=' . $baseurl;
    }
}
