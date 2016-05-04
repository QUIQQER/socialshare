<?php

/**
 * This file contains QUI\Socialshare\Socialshare
 */

namespace QUI\Socialshare;

use QUI\Control;

/**
 * Social share class
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
abstract class Socialshare extends Control
{
    private $iconLogo;

    public function __construct($params = array())
    {
        $this->setAttributes(array(
            'theme'     => 'classic',
            'showLabel' => true,
            'showCount' => true,
            'showIcon'  => true,
            'nodeName'  => 'a'
        ));

        parent::__construct($params);
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
    public function getBody()
    {
        $body = '';

        $body .= $this->createLogo();
        if ($this->showLabel())
        {
            $body .= $this->createLabel();
        }

        $this->setAttribute('href', $this->getShareUrl());
        $this->setAttribute('target', '_blank');

        $this->addCSSClass('quiqqer-socialshare');

        switch ($this->getAttribute('theme')) {
            case'classic':
                $this->addCSSClass('quiqqer-socialshare-classic');
                $this->addCSSFile('quiqqer-socialshare-classic');
                break;
            case 'flat':
                $this->addCSSClass('quiqqer-socialshare-flat');
                $this->addCSSFile('quiqqer-socialshare-flat');
                break;
        }

        return $body;
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
            case 'custom':
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
     * @return void
     */
    public function showIcon($show)
    {
        if ($show === true) {
            $this->setAttribute('showIcon', true);
        } else {
            $this->setAttribute('showIcon', false);
        }
    }
}
