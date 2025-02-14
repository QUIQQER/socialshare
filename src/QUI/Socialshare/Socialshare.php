<?php

/**
 * This file contains QUI\Socialshare\Socialshare
 */

namespace QUI\Socialshare;

use QUI;
use QUI\Control;
use QUI\Exception;

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
    public function __construct(array $params = [])
    {
        $this->setAttributes([
            'theme' => 'classic',
            'showLabel' => true,
            'showIcon' => true,
            'showCount' => true,
            'nodeName' => 'a',
            'target' => '_blank',
            'Site' => false,
            'class' => 'quiqqer-socialshare-link'
        ]);

        parent::__construct($params);
    }

    /**
     * ??????
     *
     * @return string
     */
    abstract public function getCountUrl(): string;

    /**
     * Return the counter
     *
     * @return int
     */
    abstract public function getCount(): int;

    /**
     * Define the share url
     *
     * @return string
     */
    abstract public function getShareUrl(): string;

    /**
     * Set the icon (font awesome)
     *
     * @return string
     */
    abstract public function getLogo(): string;

    /**
     * Set the name (label) of a social share button
     *
     * @return string
     */
    abstract public function getLabel(): string;

    /**
     * Set the name (facebook, Twitter, etc.)
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * Create the share button
     *
     * @return string
     */
    public function getBody(): string
    {
        $body = '<span class="quiqqer-socialshare-wrapper">';

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

        $this->addCSSClass($this->getName());


        switch ($this->getAttribute('theme')) {
            case 'flat':
                $this->addCSSClass('quiqqer-socialshare-flat');
                $this->addCSSFile(dirname(__FILE__) . '/Themes/Flat.css');
                break;
            case 'minima':
                $this->addCSSClass('quiqqer-socialshare-minima');
                $this->addCSSFile(dirname(__FILE__) . '/Themes/Minima.css');
                break;
            case 'dark':
                $this->addCSSClass('quiqqer-socialshare-dark');
                $this->addCSSFile(dirname(__FILE__) . '/Themes/Dark.css');
                break;
            case 'classic':
            default:
                $this->addCSSClass('quiqqer-socialshare-classic');
                $this->addCSSFile(dirname(__FILE__) . '/Themes/Classic.css');
                break;
        }

        $body .= '</span>';

        // todo counter implementieren
        /*if ($this->getAttribute('showCount')) {
            $body .= $this->createCount();
        }*/

        return $body;
    }

    /**
     * Create the font awesome icon
     *
     * @return string
     */
    public function createLogo(): string
    {
        return '<span class="quiqqer-socialshare-logo ' . $this->getLogo() . '"></span>';
    }

    /**
     * Create the label
     *
     * @return string
     */
    public function createLabel(): string
    {
        return '<span class="quiqqer-socialshare-label">' . $this->getLabel() . '</span>';
    }

    /**
     * Create the counter
     *
     * @return string
     */
    public function createCount(): string
    {
        if ($this->getCount() != null) {
            return '<span class="quiqqer-socialshare-count"><span class="fa fa-spinner fa-spin"></span></span>';
        }

        return '';
    }

    /**
     * Switch between available themes for the social share
     * Default is 'classic'
     *
     * @param string $theme
     */
    public function setTheme(string $theme): void
    {
        switch ($theme) {
            case 'flat':
            case 'custom':
            case 'classic':
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
    public function showLabel(): void
    {
        $this->setAttribute('showLabel', true);
    }

    /**
     * Hide the label
     *
     * @return void
     */
    public function hideLabel(): void
    {
        $this->setAttribute('showLabel', false);
    }

    /**
     * Show font awesome icon
     *
     * @return void
     */
    public function showIcon(): void
    {
        $this->setAttribute('showIcon', true);
    }

    /**
     * Hide font awesome icon
     *
     * @return void
     */
    public function hideIcon(): void
    {
        $this->setAttribute('showIcon', false);
    }

    public function showCount(): void
    {
        $this->setAttribute('showCount', true);
    }

    public function hideCount(): void
    {
        $this->setAttribute('showCount', false);
    }

    /**
     * Return the site object
     *
     * @return QUI\Interfaces\Projects\Site
     * @throws Exception
     */
    public function getSite(): QUI\Interfaces\Projects\Site
    {
        $Site = $this->getAttribute('Site');

        if ($Site instanceof QUI\Interfaces\Projects\Site) {
            return $Site;
        }

        return QUI::getRewrite()->getSite();
    }
}
