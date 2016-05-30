<?php
/**
 * This file contains QUI\Socialshare\Shares\Mail
 */

namespace QUI\Socialshare\Shares;

use QUI;
use QUI\Socialshare\Socialshare;

/**
 * Mail class for social share
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */

class Mail extends Socialshare {

    public function __construct($params = array())
    {
        $this->setAttribute('data-qui', 'package/quiqqer/socialshare/bin/controls/Mail');
        parent::__construct($params);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Socialshare\Socialshare::getNamew()
     */
    public function getName()
    {
        return 'quiqqer-socialshare-mail';
    }

    public function getLabel()
    {
        return QUI::getLocale()->get('quiqqer/socialshare', 'label-mail');
    }

    public function getLogo()
    {
        return 'fa fa-at';
    }

    public function getShareUrl()
    {
        $Request = QUI::getRequest();
        $baseUrl = $Request->getScheme() . '://' . $Request->getHttpHost() . $Request->getBasePath();
        $subject = "thema";
        $mail = "test@mail.de";

        $siteTitle = QUI::getRewrite()->getSite()->getAttribute('title');

        return 'mailto:' . $mail . '?subject=' . $siteTitle . '&body=' . $baseUrl;
    }

    public function getCount()
    {
        // TODO: Implement getCount() method.
    }

    public function getCountUrl()
    {
        // TODO: Implement getCountUrl() method.
    }
}