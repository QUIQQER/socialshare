<?php

/**
 * This file contains QUI\Socialshare\Bricks\SocialshareList
 */
namespace QUI\Socialshare\Bricks;

use QUI;

/**
 * Class SocialshareList
 *
 * @author  www.pcsg.de (Michael Danielczok)
 */
class SocialshareList extends QUI\Control
{
    /**
     * SocialshareList constructor.
     * @param array $attributes
     */
    public function __construct($attributes = array())
    {

        $this->setAttributes(array(
            'class' => 'quiqqer-socialshare-brick',
            'theme' => $this->getAttribute('socialshare.brick.settings.general.theme')
        ));
        parent::__construct($attributes);
    }

    /**
     * @return string
     */
    public function getBody()
    {
        echo $this->getAttribute('socialshare.brick.settings.showIcon');
        $Control = new QUI\Socialshare\Controls\Socialshare(array(
            'theme'     => $this->getAttribute('socialshare.brick.settings.theme'),
            'showLabel' => $this->getAttribute('socialshare.brick.settings.showLabel'),
            'showIcon'  => $this->getAttribute('socialshare.brick.settings.showIcon'),
            'showCount' => $this->getAttribute('socialshare.brick.settings.showCount'),
        ));

        return $Control->create();
    }
}
