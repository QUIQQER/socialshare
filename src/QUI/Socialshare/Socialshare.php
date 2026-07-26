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
     * Map of theme names to their BEM modifier suffix. The suffix is appended
     * to the "quiqqer-socialshare__link--" element base; note the "link" theme
     * maps to the "linkColored" modifier because "quiqqer-socialshare__link" is
     * already the element class on every button. The released legacy theme
     * names (classic, flat, minima, dark) are kept as aliases so existing
     * project and brick configurations keep working.
     *
     * @var array<string, string>
     */
    private const THEMES = [
        'button-classic' => 'buttonClassic',
        'button' => 'button',
        'button-outline' => 'buttonOutline',
        'link' => 'linkColored',
        'link-muted' => 'linkMuted',
        'custom' => 'custom',
        // legacy aliases (released names)
        'classic' => 'buttonClassic',
        'flat' => 'button',
        'minima' => 'linkColored',
        'dark' => 'linkMuted'
    ];

    /**
     * Default theme name, used when no theme is set or an unknown value is
     * given.
     */
    private const DEFAULT_THEME = 'button-classic';

    /**
     * Socialshare constructor.
     * @param array<string, mixed> $params
     */
    public function __construct(array $params = [])
    {
        $this->setAttributes([
            'theme' => self::DEFAULT_THEME,
            'showLabel' => true,
            'showIcon' => true,
            'showCount' => true,
            'nodeName' => 'a',
            'target' => '_blank',
            'Site' => false,
            'class' => 'quiqqer-socialshare__link'
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
     * Descriptive name of the share action, naming the network. Unlike the
     * visible label (which is just the action, e.g. "Teilen"), this reads
     * "Auf Facebook teilen". Used as the title tooltip when the label is
     * visible and as the aria-label when only the icon is shown.
     *
     * @return string
     */
    abstract public function getShareTitle(): string;

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
        $this->addCSSFile(dirname(__FILE__) . '/Controls/Socialshare.css');

        $body = '';

        if ($this->getAttribute('showIcon')) {
            $body .= $this->createLogo();
        }

        // The network is named via getShareTitle() ("Auf Facebook teilen"),
        // because the visible label is only the action ("Teilen") and the icon
        // is decorative. When the label is visible it becomes the title tooltip;
        // in icon-only mode it becomes the aria-label (the accessible name).
        if ($this->getAttribute('showLabel')) {
            $body .= $this->createLabel();
            $this->setAttribute('title', $this->getShareTitle());
        } else {
            $this->setAttribute('aria-label', $this->getShareTitle());
            $this->addCSSClass('quiqqer-socialshare__link--iconOnly');
        }

        $this->setAttribute('href', $this->getShareUrl());
        $this->setAttribute('target', '_blank');
        $this->setAttribute('rel', 'noopener noreferrer');

        // ride the template's shared .btn component (layout, radius, hover swap)
        $this->addCSSClass('btn');
        $this->addCSSClass($this->getName());
        $this->addCSSClass('quiqqer-socialshare__link--' . $this->getThemeClass());

        // todo counter implementieren
        /*if ($this->getAttribute('showCount')) {
            $body .= $this->createCount();
        }*/

        return $body;
    }

    /**
     * Return the BEM modifier suffix for the current theme (without the
     * "quiqqer-socialshare__link--" prefix). Falls back to the default theme
     * for unknown or legacy values.
     */
    private function getThemeClass(): string
    {
        $theme = strtolower((string)$this->getAttribute('theme'));

        return self::THEMES[$theme] ?? self::THEMES[self::DEFAULT_THEME];
    }

    /**
     * Create the font awesome icon
     *
     * @return string
     */
    public function createLogo(): string
    {
        return '<span class="quiqqer-socialshare__logo ' . $this->getLogo() . '" aria-hidden="true"></span>';
    }

    /**
     * Create the label
     *
     * @return string
     */
    public function createLabel(): string
    {
        return '<span class="quiqqer-socialshare__label">' . $this->getLabel() . '</span>';
    }

    /**
     * The share link is rendered directly as this control's <a> node (an
     * unusual case for a QUIControl), so it needs a couple of attributes the
     * default whitelist does not allow: aria-label for the icon-only
     * accessible name and rel for the target="_blank" link. Kept local to this
     * control so every other QUIControl keeps the default whitelist.
     *
     * @param string $attribute
     */
    protected function isAllowedAttribute($attribute): bool
    {
        if ($attribute === 'aria-label' || $attribute === 'rel') {
            return true;
        }

        return parent::isAllowedAttribute($attribute);
    }

    /**
     * Create the counter
     *
     * @return string
     */
    public function createCount(): string
    {
        if ($this->getCount() > 0) {
            return '<span class="quiqqer-socialshare__count"><span class="fa-solid fa-spinner fa-spin"></span></span>';
        }

        return '';
    }

    /**
     * Switch between available themes for the social share.
     * Accepts the current names (button-classic, button, button-outline, link,
     * link-muted, custom) as well as the released legacy names (classic, flat,
     * minima, dark). Default is 'button-classic'.
     *
     * @param string $theme
     */
    public function setTheme(string $theme): void
    {
        $theme = strtolower($theme);

        $this->setAttribute('theme', isset(self::THEMES[$theme]) ? $theme : self::DEFAULT_THEME);
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

        $Site = QUI::getRewrite()->getSite();

        if ($Site === null) {
            throw new Exception('No site available for social sharing.');
        }

        return $Site;
    }

    /**
     * Decode a social count API response
     *
     * @return array<string|int, mixed>
     */
    protected function decodeCountResponse(string | bool $response): array
    {
        if (!is_string($response)) {
            return [];
        }

        $data = json_decode($response, true);

        return is_array($data) ? $data : [];
    }
}
