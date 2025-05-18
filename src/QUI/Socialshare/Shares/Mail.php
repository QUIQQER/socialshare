<?php

/**
 * This file contains QUI\Socialshare\Shares\Mail
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Exception;
use QUI\Socialshare\Socialshare;

/**
 * Mail class for social share
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
class Mail extends Socialshare
{
    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Socialshare::getNamew
     */
    public function getName(): string
    {
        return 'quiqqer-socialshare-mail';
    }

    public function getLabel(): string
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-mail');
    }

    public function getLogo(): string
    {
        return 'fa fa-at';
    }

    /**
     * @throws Exception
     */
    public function getShareUrl(): string
    {
        $Site = QUI::getRewrite()->getSite();
        $Request = QUI::getRequest();
        $baseUrl = $Request->getScheme() . '://' .
            $Request->getHttpHost() . $Request->getBasePath() . $Site->getUrlRewritten();
        $siteTitle = QUI::getRewrite()->getSite()->getAttribute('title');

        return 'mailto:' . '?subject=' . $siteTitle . '&body=' . $baseUrl;
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
