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
    public function __construct($params = [])
    {
        $this->setAttributes([
            'class'     => 'quiqqer-socialshare',
            'theme'     => 'classic',
            'showLabel' => true,
            'showIcon'  => true,
            'showCount' => false
        ]);

        parent::__construct($params);

        $this->addCSSFile(dirname(__FILE__).'/Socialshare.css');
    }

    /**
     * @return string
     */
    public function getBody()
    {
        try {
            $Engine = QUI::getTemplateManager()->getEngine();
        } catch (QUI\Exception $Exception) {
            return '';
        }

        $socials = QUI\Socialshare\Manager::get([
            'theme'     => $this->getAttribute('theme'),
            'showLabel' => $this->getAttribute('showLabel'),
            'showIcon'  => $this->getAttribute('showIcon'),
            'showCount' => $this->getAttribute('showCount'),
        ]);

        $html = '';

        /* @var $Social QUI\Socialshare\Socialshare */
        foreach ($socials as $Social) {
            $html .= $Social->create();
            $this->addCSSFiles($Social->getCSSFiles());
        }

        $Engine->assign([
            'this'    => $this,
            'socials' => $socials
        ]);

        return $Engine->fetch(dirname(__FILE__).'/Socialshare.html');
    }
}
