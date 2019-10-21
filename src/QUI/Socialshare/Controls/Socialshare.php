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
            'class'     => 'quiqqer-socialshare',
            'theme'     => 'classic',
            'showLabel' => true,
            'showIcon'  => true,
            'showCount' => false
        ));

        parent::__construct($params);

        $this->addCSSFile(dirname(__FILE__) . '/Socialshare.css');
    }


    public function getBody()
    {
        $Engine  = QUI::getTemplateManager()->getEngine();

        $socials = QUI\Socialshare\Manager::get(array(
            'theme'     => $this->getAttribute('theme'),
            'showLabel' => $this->getAttribute('showLabel'),
            'showIcon'  => $this->getAttribute('showIcon'),
            'showCount' => $this->getAttribute('showCount'),
        ));

        $Engine->assign(array(
            'this'    => $this,
            'socials' => $socials
        ));

        return $Engine->fetch(dirname(__FILE__) . '/Socialshare.html');
    }
}
