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
    private static $availableSocials = [
        'Baidu',
        'VK',
        'Surfingbird',
        'RenRen',
        'Pocket',
        'Readability',
        'Odnoklassniki',
        'MoiMir',
        'Livejournal',
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
    ];

    // default settings
    private static $settings = [
        'theme'     => 'classic',
        'showLabel' => true,
        'showIcon'  => true,
        'showCount' => false,
        'nodeName'  => 'a'
    ];

    /**
     * Get socials
     *
     * @param array $settings
     * @return array
     */
    public static function get($settings = [])
    {
        try {
            self::setSocialSettings($settings);
            $Project = QUI::getRewrite()->getProject();
        } catch (QUI\Exception $Exception) {
            return [];
        }

        $networks = [];

        foreach (self::$availableSocials as $social) {
            $setting = 'socialshare.settings.'.$social;

            if (!$Project->getConfig($setting)) {
                continue;
            }

            $class  = 'QUI\Socialshare\Shares\\'.$social;
            $Social = new $class(self::$settings);

            $networks[] = $Social;
        }

        return $networks;
    }

    /**
     * Get single social
     *
     * @param $social
     * @return string
     * @throws QUI\Exception
     * @todo - must be implemented
     *
     */
    public static function getSocial($social = [])
    {
        return;
//        self::setSocialSettings();

//        $Engine = QUI::getTemplateManager()->getEngine();

//        self::setSocialSettings();

        $htmlSocial = "";
        if (!isset(self::$availableSocials[$social])) {
            throw new QUI\Exception('Social class "'.$social.'" not exist. First letter capitalized?', 404);
        }

        $class      = 'QUI\Socialshare\Shares\\'.$social;
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
    private static function setSocialSettings($settings = [])
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
