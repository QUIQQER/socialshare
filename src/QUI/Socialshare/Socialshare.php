<?php

/**
 * This file contains QUI\Socialshare\Socialshare
 */

namespace QUI\Socialshare;

use QUI;
use QUI\Control;

/**
 * Social share class
 *
 * @author  www.pcsg.de (Michael Danielczok)
 * @package quiqqer/socialshare
 */
abstract class Socialshare extends Control
{
    /**
     * Socialshare constructor.
     * @param array $params
     */
    public function __construct($params = array())
    {
        $this->setAttributes(array(
            'theme'     => 'classic',
            'showLabel' => true,
            'showIcon'  => true,
            'showCount' => true,
            'nodeName'  => 'a',
            'Site'      => false
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
     * Return the counter
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
     * Set the name (facebook, twitter, etc.)
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Create the share button
     *
     * @return string
     */
    public function getBody()
    {
        $body = '<span class="quiqqer-socialshare-container">';

        if ($this->getAttribute('showIcon')) {
            $body .= $this->createLogo();
        }
        if ($this->getAttribute('showLabel')) {
            if ($this->getAttribute('showIcon')) {
                $this->addCSSClass('quiqqer-socialshare-icon-spacing');
            }
            $body .= $this->createLabel();
        }

        $this->setAttribute('href', $this->getShareUrl());
        $this->setAttribute('target', '_blank');

        $this->addCSSClass('quiqqer-socialshare ' . $this->getName());
        $this->addCSSFile(dirname(__FILE__) . '/Socialshare.css');


        switch ($this->getAttribute('theme')) {
            case 'classic':
                $this->addCSSClass('quiqqer-socialshare-classic');
                $this->addCSSFile(dirname(__FILE__) . '/Themes/Classic.css');
                break;
            case 'flat':
                $this->addCSSClass('quiqqer-socialshare-flat');
                $this->addCSSFile(dirname(__FILE__) . '/Themes/Flat.css');
                break;
            case 'minima':
                $this->addCSSClass('quiqqer-socialshare-minima');
                $this->addCSSFile(dirname(__FILE__) . '/Themes/Minima.css');
                break;
            default:
                $this->addCSSClass('quiqqer-socialshare-classic');
                $this->addCSSFile(dirname(__FILE__) . '/Themes/Classic.css');
                break;
        }
        $body .= '</span>';

        if ($this->getAttribute('showCount')) {
            $body .= $this->createCount();
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
     * Create the counter
     *
     * @return string
     */
    public function createCount()
    {
        if ($this->getCount() != null) {
            return '<span class="quiqqer-socialshare-count"><span class="fa fa-spinner fa-spin"></span></span>';
        }
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
     * Show the label
     *
     * @return void
     */
    public function showLabel()
    {
        $this->setAttribute('showLabel', true);
    }

    /**
     * Hide the label
     *
     * @return void
     */
    public function hideLabel()
    {
        $this->setAttribute('showLabel', false);
    }

    /**
     * Show font awesome icon
     *
     * @return void
     */
    public function showIcon()
    {
        $this->setAttribute('showIcon', true);
    }

    /**
     * Hide font awesome icon
     *
     * @return void
     */
    public function hideIcon()
    {
        $this->setAttribute('showIcon', false);
    }

    public function showCount()
    {
        $this->setAttribute('showCount', true);
    }

    public function hideCount()
    {
        $this->setAttribute('showCount', false);
    }

    /**
     * Return the site object
     *
     * @return QUI\Projects\Site
     */
    public function getSite()
    {
        if ($this->getAttribute('Site')) {
            return $this->getAttribute('Site');
        }

        return QUI::getRewrite()->getSite();
    }
}
