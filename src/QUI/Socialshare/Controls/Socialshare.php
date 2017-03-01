<?php

/**
 * This file contains QUI\Socialshare\Controls\Socialshare
 */

namespace QUI\Socialshare\Controls;

use QUI;
use QUI\Control;

/**
 * Social share class
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
class Socialshare extends Control
{
    /**
     * Socialshare constructor.
     * @param array $params
     */
    public function __construct($params = array())
    {
        parent::__construct($params);
    }


    public function getBody()
    {
        $Engine      = QUI::getTemplateManager()->getEngine();
        $Socialshare = new QUI\Socialshare\Manager();

        $Engine->assign(array(
            'socialshare' => $Socialshare->get()
        ));

        return $Engine->fetch(dirname(__FILE__) . 'Socialshare.html');
    }
}
