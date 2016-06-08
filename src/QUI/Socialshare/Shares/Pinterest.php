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
    public function __construct($params = array())
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Pinterest');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getName()
     */
    public function getName()
    {
        return 'quiqqer-socialshare-pinterest';
    }

    /**
     *
     *
     * @return array|string
     */
    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-pinterest');
        // TODO: Implement getCountUrl() method.
        // Warum return array|string und wie besser implementieren

    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getLogo()
     */
    public function getLogo()
    {
        return 'fa fa-pinterest';
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

        return 'https://pinterest.com/pin/create/button/?url=' . $baseurl;
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
        $data     = json_decode($countUrl, true);

        QUI\System\Log::writeRecursive($countUrl);
        QUI\System\Log::writeRecursive('##################################');
        QUI\System\Log::writeRecursive($data);

//        if (!isset($data['count'])) {
//            return 0;
//        }
//
//        $result = number_format($data['count']);
//        QUI\Cache\Manager::set($cacheName, $result, 1800);
//
//        return $result;
        return 0;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getCountUrl
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

//        $url = "http://api.pinterest.com/v1/urls/count.json?callback=&url=";
//        $url .= urlencode('http://www.craftsbycourtney.com/get-pinterest-pin-count/');
//        QUI\System\Log::writeRecursive($url); ."&callback=?"
        $url = "https://api.pinterest.com/v1/urls/count.json?&url=";
        $url .= urlencode('http://www.craftsbycourtney.com/get-pinterest-pin-count/');
echo $url;
        return $url;
    }
}
