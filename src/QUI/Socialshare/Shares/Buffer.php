<?php

/**
 * this file contains QUI\Socialshare\Shares\Buffer
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Buffer class for social share
 *
 * @author  www.pcsg.de (Torsten Fink)
 * @package quiqqer/socialshare
 */
class Buffer extends Socialshare
{
    public function __construct($params = [])
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Buffer');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getName()
     */
    public function getName()
    {
        return 'quiqqer-socialshare-buffer';
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getLabel()
     */
    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-buffer');
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getLogo()
     */
    public function getLogo()
    {
        return 'fa fa-share-square-o';
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

        return 'https://buffer.com/add?url=' . $baseurl;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getCount()
     */
    public function getCount()
    {
        $cacheName = 'quiqqer/socialshare/' . md5($this->getCountUrl());

        try {
            return QUI\Cache\Manager::get($cacheName);
        } catch (QUI\Cache\Exception $Exception) {
        }

        $countUrl = QUI\Utils\Request\Url::get($this->getCountUrl());
        $data = json_decode($countUrl, true);

        if (!isset($data['data'])) {
            return 0;
        }

        if (!isset($data['data'][0])) {
            return 0;
        }

        if (!isset($data['data'][0]['total_count'])) {
            return 0;
        }

        $result = number_format($data['data'][0]['total_count']);
        QUI\Cache\Manager::set($cacheName, $result, 1800);

        return $result;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getCountUrl()
     */
    public function getCountUrl()
    {
        $Site = $this->getSite();
        $Request = QUI::getRequest();

        // @todo warten auf URL Site Objekt, damit kein Request mehr verwendet wird
        // hier ist sonst noch ein fehler mit den vhosts
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost();
        $baseurl = $baseurl . $Site->getUrlRewritten();
        $encoded = urlencode($baseurl);

        $url = "https://api.bufferapp.com/1/links/shares.json?url=";
        $url .= http_build_query([
            'q' => "SELECT total_count FROM link_stat WHERE url='{$encoded}'"
        ]);

//        $url .= QUI::getRewrite()->getUrlFromSite(array(
//            'site' => $Site
//        ));
//        echo $url;
        return $url;
    }
}
