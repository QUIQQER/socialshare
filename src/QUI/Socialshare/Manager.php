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
class Manager extends QUI\Controls\Control
{
    /**
     * @var array
     */
    private static $availableSocials = array(
        'Baidu',
        'MoiMir',
        'Livejornal',
        'Liveinternet',
        'Line',
        'Delicious',
        'Viber',
        'StumbleUpon',
        'Evernote',
        'Instapaper',
        'Buffer',
        'Blogger',
        'Digg',
        'Tumblr',
        'WorldPress',
        'Facebook',
        'Reddit',
        'Telegram',
        'Weibo',
        'Twitter',
        'Google',
        'Pinterest',
        'Mail',
        'Whatsapp',
        'LinkedIn',
        'Xing'
    );

    // default settings
    private static $settings = array(
        'theme'     => 'classic',
        'showLabel' => true,
        'showIcon'  => true,
        'showCount' => false,
        'nodeName'  => 'a'
    );

    /**
     * Get socials
     *
     * @param array $settings
     * @return string
     * @throws QUI\Exception
     */
    public static function get($settings = array())
    {
        self::setSocialSettings($settings);

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
     * Get single social
     *
     * @todo - must be implemented
     *
     * @param $social
     * @return string
     * @throws QUI\Exception
     */
    public static function getSocial($social = array())
    {
        return;
//        self::setSocialSettings();

//        $Engine = QUI::getTemplateManager()->getEngine();

//        self::setSocialSettings();

        $htmlSocial = "";
        if (!isset(self::$availableSocials[$social])) {
            throw new QUI\Exception('Social class "' . $social . '" not exist. First letter capitalized?', 404);
        }

        $class      = 'QUI\Socialshare\Shares\\' . $social;
        $Social     = new $class(self::$settings);
        $htmlSocial = $Social->create();
//        $Engine->assign('htmlSocial', $htmlSocial);

//        return $Engine->fetch(dirname(__FILE__) . '/Socialshare.html');
        return $htmlSocial;
    }

    /**
     * Set the settings
     *
     * @param array $settings
     * @throws QUI\Exception
     */
    private static function setSocialSettings($settings = array())
    {
        // set the general settings
        self::$settings['theme']     = QUI::getRewrite()->getProject()->getConfig('socialshare.settings.general.theme');
        self::$settings['showLabel'] = QUI::getRewrite()->getProject()->getConfig('socialshare.settings.general.showLabel');
        self::$settings['showIcon']  = QUI::getRewrite()->getProject()->getConfig('socialshare.settings.general.showIcon');
        self::$settings['showCount'] = QUI::getRewrite()->getProject()->getConfig('socialshare.settings.general.showCount');


        // todo - at the moment brick / control settings can't override general setting, if "false"
        // overwrite the general setting...
        foreach ($settings as $key => $value) {
            // ...if the setting is available in brick
            if (!$value) {
                continue;
            }
            self::$settings[$key] = $value;
        }
    }
}
