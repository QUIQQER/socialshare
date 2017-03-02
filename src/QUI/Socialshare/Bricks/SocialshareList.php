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
            'theme' => '' // todo brick settings
        ));
        parent::__construct($attributes);
    }

    /**
     * @return string
     */
    public function getBody()
    {
        $Control = new QUI\Socialshare\Controls\Socialshare(array(
            'theme' => 'flat' // todo brick settings
        ));

        return $Control->create();
    }
}
