<?php

/**
 * This file contains QUI\Socialshare\Socialshare
 */

namespace QUI\Socialshare;

use QUI\QDOM;

/**
 * Social share class
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
abstract class Socialshare extends QDOM
{
    public function __construct($params = array())
    {
        $this->setAttributes(array(
            'theme'     => 'classic',
            'showLabel' => true,
            'showCount' => true,
            'showIcon'  => true,
        ));

        $this->setAttributes($params);
    }

    /**
     * ??????
     *
     * @return string
     */
    abstract public function getCountUrl();

    /**
     * ??????
     *
     * @return string
     */
    abstract public function getCount();

    /**
     * Define the share url
     *
     * @return string
     */
    abstract public function getShareUrl();

    /**
     * Set the icon (font awesome)
     *
     * @return string
     */
    abstract public function getLogo();

    /**
     * Set the name (label) of a social share button
     *
     * @return string
     */
    abstract public function getLabel();

    /**
     * Create the share button
     *
     * @return string
     */
    public function create()
    {
        return '<div class="quiqqer-socialshare">' .
        $this->createLogo() .
        $this->createLabel() .
        '</div>';
    }

    /**
     * Create the font awesome icon
     *
     * @return string
     */
    public function createLogo()
    {
        return '<span class="quiqqer-socialshare-logo ' . $this->getLogo() . '"></span>';
    }

    /**
     * Create the label
     *
     * @return string
     */
    public function createLabel()
    {
        return '<span class="quiqqer-socialshare-label">' . $this->getLabel() . '</span>';
    }

    /**
     * Switch between available themes for the social share
     * Default is 'classic'
     *
     * @param string $theme
     *
     * @return string
     */
    public function setTheme($theme)
    {
        switch ($theme) {
            case 'classic':
                $this->setAttribute('theme', $theme);
                break;
            case 'flat':
                $this->setAttribute('theme', $theme);
                break;
            default:
                $this->setAttribute('theme', 'classic');
        }
    }

    /**
     * Setting to show the label
     *
     * @return void
     */
    public function showLabel()
    {
        $this->setAttribute('showLabel', true);
    }

    /**
     * Setting to hide the label
     *
     * @return void
     */
    public function hideLabel()
    {
        $this->setAttribute('showLabel', false);
    }


    /**
     * Show or hide font awesome icon
     *
     * @param bool $show
     *
     * @return ??????
     * das gleich wie oben
     */
    public function showIcon($show)
    {
        if ($show === false) {
            $this->setAttribute('showIcon', false);
        }
    }
}

