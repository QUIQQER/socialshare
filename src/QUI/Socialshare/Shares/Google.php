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
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-google');
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
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = $baseurl . $_SERVER['REQUEST_URI'];

        $nowyUrl = 'http://www.allesuebergoogleplus.de/googleplus-tipps/google-beitraege-richtig-teilen-hinweise-und-tipps/';

        return 'https://plus.google.com/share?url=' . $baseurl;
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

        $countUrl = $this->getCountUrl();
        $curl     = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . rawurldecode($countUrl) . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        $curl_results = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($curl_results, true);

        if (!isset($data['0'])) {
            return 0;
        }

        if (!isset($data['0']['result'])) {
            return 0;
        }

        if (!isset($data['0']['result']['metadata'])) {
            return 0;
        }

        if (!isset($data['0']['result']['metadata']['globalCounts'])) {
            return 0;
        }

        if (!isset($data['0']['result']['metadata']['globalCounts']['count'])) {
            return 0;
        }

        $result = isset($data[0]['result']['metadata']['globalCounts']['count']) ? intval($data[0]['result']['metadata']['globalCounts']['count']) : 0;
        QUI\Cache\Manager::set($cacheName, $result, 30);

        return $result;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getCountUrl()
     */
    public function getCountUrl()
    {
        $Site    = $this->getSite();
        $Request = QUI::getRequest();

        // @todo warten auf URL Site Objekt, damit kein Request mehr verwendet wird
        // hier ist sonst noch ein fehler mit den vhosts
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost();
        $baseurl .= $Site->getUrlRewritten();

        return $baseurl;
    }
}
