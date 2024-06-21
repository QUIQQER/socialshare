<?php

/**
 * this file contains QUI\Socialshare\Shares\Liveinternet
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Liveinternet class for social share
 *
 * @author  www.pcsg.de (Torsten Fink)
 * @package quiqqer/socialshare
 */
class Liveinternet extends Socialshare
{
    public function __construct(array $params = [])
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Liveinternet');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getName
     */
    public function getName(): string
    {
        return 'quiqqer-socialshare-liveinternet';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getLabel
     */
    public function getLabel(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-liveinternet');
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

        return 'http://www.liveinternet.ru/journal_post.php?action=n_add&cnurl=' . $baseurl;
    }

    /**
     * (non-PHPdoc)
     *
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
