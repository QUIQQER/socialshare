<?php

/**
 * This file contains QUI\Socialshare\Shares\LinkedIn
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Exception;
use QUI\Socialshare\Socialshare;

/**
 * LinkedIn class for social share
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
class LinkedIn extends Socialshare
{
    public function __construct(array $params = [])
    {
        // todo social share counter
//        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/LinkedIn');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName(): string
    {
        return 'quiqqer-socialshare-linkedin';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLabel
     */
    public function getLabel(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-linkedin');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLogo
     */
    public function getLogo(): string
    {
        return 'fa fa-linkedin';
    }

    /**
     * (non-PHPdoc)
     *
     * @throws Exception
     * @see Socialshare::getShareUrl
     */

    public function getShareUrl(): string
    {
        $Site = $this->getSite();
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $baseurl = urlencode($baseurl . $_SERVER['REQUEST_URI']);

        $title = 'title=' . urlencode($Site->getAttribute('title'));
        $summary = 'summary=' . urlencode($Site->getAttribute('desc'));

        return 'https://www.linkedin.com/shareArticle?mini=true&url=' . $baseurl . '&' . $title . '&' . $summary;
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

        return 'https://www.linkedin.com/countserv/count/share?url=' . $encoded;
    }
}
