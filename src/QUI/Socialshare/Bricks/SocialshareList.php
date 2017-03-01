<?php

/**
 * This file contains QUI\Socialshare\Bricks\SocialshareList
 */
namespace QUI\Socialshare\Bricks;

use QUI;

/**
 * Class Team
 *
 * @author  www.pcsg.de (Michael Danielczok)
 */
class SocialshareList extends QUI\Control
{
    /**
     * TeamList constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {

        parent::__construct($attributes);
    }

    /**
     * @inheritdoc
     * @return string
     */
    public function getBody()
    {
        $Engine = QUI::getTemplateManager()->getEngine();

        $Control = new QUI\Socialshare\Manager();

        return $Engine->fetch(dirname(__FILE__) . $template);

    }
}
