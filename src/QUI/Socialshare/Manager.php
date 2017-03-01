<?php
/**
 * This file contains QUI\Socialshare\Manager
 */

namespace QUI\Socialshare;

use QUI;

/**
 * Social share Manager - help class
 *
 * @package quiqqer/socialshare
 */
class Manager
{
    /**
     * @var array
     */
    private static $availableSocials = array(
        'Facebook',
        'Twitter',
        'Google',
        'Pinterest',
        'Mail',
        'Whatsapp'
    );

    // defoultsetting
    private static $settings = array(
        'theme'     => 'classic',
        'showLabel' => true,
        'showIcon'  => true,
        'showCount' => false,
        'nodeName'  => 'a'
    );

    /**
     * Get social
     *
     * @return string
     */
    public static function get()
    {
        self::setSocialSettings();

        $htmlSocial = "";

        foreach (self::$availableSocials as $social) {
            $setting = 'socialshare.settings.' . $social;
            if (!QUI::getRewrite()->getProject()->getConfig($setting)) {
                continue;
            }

            $class  = 'QUI\Socialshare\Shares\\' . $social;
            $Social = new $class(self::$settings);

            $htmlSocial .= $Social->create();
        };

        return $htmlSocial;
    }

    /**
     * Get only one social
     *
     * @param $social
     * @return string
     * @throws QUI\Exception
     */
    public static function getSocial($social)
    {

        $Engine = QUI::getTemplateManager()->getEngine();

        self::setSocialSettings();

        $htmlSocial = "";

        if (!isset($availableSocials[$social])) {
            throw new QUI\Exception('Social Klasse ' . $social . 'existiert nicht', 404);
        }

        $class      = 'QUI\Socialshare\Shares\\' . $social;
        $Social     = new $class(self::$settings);
        $htmlSocial = $Social->create();

        $Engine->assign('htmlSocial', $htmlSocial);

        return $Engine->fetch(dirname(__FILE__) . '/Socialshare.html');
    }

    /**
     * Set the settings
     */
    private static function setSocialSettings()
    {
        self::$settings['theme']     = QUI::getRewrite()->getProject()->getConfig('socialshare.settings.general.theme');
        self::$settings['showLabel'] = QUI::getRewrite()->getProject()->getConfig('socialshare.settings.general.showLabel');
        self::$settings['showIcon']  = QUI::getRewrite()->getProject()->getConfig('socialshare.settings.general.showIcon');
        self::$settings['showCount'] = QUI::getRewrite()->getProject()->getConfig('socialshare.settings.general.showCount');
    }
}
