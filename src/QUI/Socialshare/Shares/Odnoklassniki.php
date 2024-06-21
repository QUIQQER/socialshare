<?php

/**
 * this file contains QUI\Socialshare\Shares\Odnoklassniki
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Exception;
use QUI\Socialshare\Socialshare;

/**
 * Odnoklassniki class for social share
 *
 * @author  www.pcsg.de (Torsten Fink)
 * @package quiqqer/socialshare
 */
class Odnoklassniki extends Socialshare
{
    public function __construct(array $params = [])
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Odnoklassniki');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName(): string
    {
        return 'quiqqer-socialshare-odnoklassniki';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLabel
     */
    public function getLabel(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-odnoklassniki');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLogo
     */
    public function getLogo(): string
    {
        return 'fa fa-odnoklassniki';   // new Logo Icon <i class="fab fa-odnoklassniki"></i>
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

        return 'https://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=' . $baseurl;
    }

    /**
     * (non-PHPdoc)
     *
     * @throws Exception
     * @see Socialshare::getCount
     */
    public function getCount(): int
    {
        $cacheName = 'quiqqer/socialshare/' . md5($this->getCountUrl());

        try {
            return QUI\Cache\Manager::get($cacheName);
        } catch (QUI\Cache\Exception) {
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
     * @throws Exception
     * @see Socialshare::getCountUrl
     */
    public function getCountUrl(): string
    {
        $Site = $this->getSite();
        $Request = QUI::getRequest();

        // @todo warten auf URL Site Objekt, damit kein Request mehr verwendet wird
        // hier ist sonst noch ein fehler mit den vhosts
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost();
        $baseurl = $baseurl . $Site->getUrlRewritten();
        $encoded = urlencode($baseurl);

        $url = "https://connect.ok.ru/dk?st.cmd=extLike&uid=1&ref=";
        $url .= http_build_query([
            'q' => "SELECT total_count FROM link_stat WHERE url='$encoded'"
        ]);

//        $url .= QUI::getRewrite()->getUrlFromSite(array(
//            'site' => $Site
//        ));
//        echo $url;
        return $url;
    }
}
