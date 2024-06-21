<?php

/**
 * this file contains QUI\Socialshare\Shares\Livejournal
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Exception;
use QUI\Socialshare\Socialshare;

/**
 * Livejournal class for social share
 *
 * @author  www.pcsg.de (Torsten Fink)
 * @package quiqqer/socialshare
 */
class Livejournal extends Socialshare
{
    public function __construct(array $params = [])
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Livejournal');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName(): string
    {
        return 'quiqqer-socialshare-livejournal';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLabel
     */
    public function getLabel(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-livejournal');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLogo
     */
    public function getLogo(): string
    {
        return 'fa fa-share-square-o';
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

        return 'https://livejournal.com/update.bml?event=' . $baseurl;
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
     * @see Socialshare::getCountUrl
     */
    public function getCountUrl(): string
    {
        return '';
    }
}
