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
        $this->setAttributes(array(
            'class' => 'quiqqer-socialshare'
//            'theme' => 'flat' // todo brick settings
        ));

        parent::__construct($params);

        $this->addCSSFile(dirname(__FILE__) . '/Socialshare.css');
    }


    public function getBody()
    {
        $Engine  = QUI::getTemplateManager()->getEngine();
        $Social  = new QUI\Socialshare\Manager();
        $socials = $Social->get();

        $Engine->assign(array(
            'this'    => $this,
            'socials' => $socials
        ));

        return $Engine->fetch(dirname(__FILE__) . '/Socialshare.html');
    }
}
