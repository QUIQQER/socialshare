<?php

/**
 * This file contains QUI\Socialshare\Bricks\SocialshareList
 */

namespace QUI\Socialshare\Bricks;

use Exception;
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
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes([
            'class' => 'quiqqer-socialshare-brick',
            'theme' => $this->getAttribute('socialshare.brick.settings.general.theme')
        ]);

        parent::__construct($attributes);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getBody(): string
    {
        $Control = new QUI\Socialshare\Controls\Socialshare([
            'theme' => $this->getAttribute('socialshare.brick.settings.theme'),
            'showLabel' => $this->getAttribute('socialshare.brick.settings.showLabel'),
            'showIcon' => $this->getAttribute('socialshare.brick.settings.showIcon'),
        ]);

        $result = $Control->create();

        $this->addCSSFiles($Control->getCSSFiles());

        return $result;
    }
}
