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
class Manager extends QUI\Control
{
    /**
     * @var array
     */
    private static array $availableSocials = [
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
    private static array $settings = [
        'theme' => 'classic',
        'showLabel' => true,
        'showIcon' => true,
        'showCount' => false,
        'nodeName' => 'a'
    ];

    /**
     * Get socials
     *
     * @param array $settings
     * @return array
     */
    public static function get(array $settings = []): array
    {
        try {
            self::setSocialSettings($settings);
            $Project = QUI::getRewrite()->getProject();
        } catch (QUI\Exception) {
            return [];
        }

        $networks = [];

        foreach (self::$availableSocials as $social) {
            $setting = 'socialshare.settings.' . $social;

            if (!$Project->getConfig($setting)) {
                continue;
            }

            $class = 'QUI\Socialshare\Shares\\' . $social;
            $Social = new $class(self::$settings);

            $networks[] = $Social;
        }

        return $networks;
    }

    /**
     * Get single social
     *
     * @param array $social
     * @return string
     * @throws QUI\Exception
     * @todo - must be implemented
     *
     */
    public static function getSocial(array $social = []): string
    {
        return '';
//        self::setSocialSettings();

//        $Engine = QUI::getTemplateManager()->getEngine();

//        self::setSocialSettings();

        $htmlSocial = "";

        if (!isset(self::$availableSocials[$social])) {
            throw new QUI\Exception('Social class "' . $social . '" not exist. First letter capitalized?', 404);
        }

        $class = 'QUI\Socialshare\Shares\\' . $social;
        $Social = new $class(self::$settings);

        return $Social->create();
    }

    /**
     * Set the settings
     *
     * @param array $settings
     * @throws QUI\Exception
     */
    private static function setSocialSettings(array $settings = []): void
    {
        $Project = QUI::getRewrite()->getProject();

        // set the general settings
        self::$settings['theme'] = $Project->getConfig('socialshare.settings.general.theme');
        self::$settings['showLabel'] = $Project->getConfig('socialshare.settings.general.showLabel');
        self::$settings['showIcon'] = $Project->getConfig('socialshare.settings.general.showIcon');
        self::$settings['showCount'] = $Project->getConfig('socialshare.settings.general.showCount');

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
