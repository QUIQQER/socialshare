<?php
/**
 * This file contains QUI\Socialshare\Manager
 */

namespace QUI\Socialshare;

use QUI;
use QUI\Control;

/**
 * Social share Manager - helper Class
 *
 * @package quiqqer/socialshare
 */
class Manager extends Control
{
    /**
     * @var array
     */
    private static $availableSocials = array('Facebook', 'Twitter', 'Google', 'Pinterest', 'Mail');

    // defoultsetting
    private static $settings = array(
        'theme'     => 'classic',
        'showLabel' => false,
        'showIcon'  => false,
        'showCount' => false,
        'nodeName'  => 'a'
    );

    /**
     *
     */
    public static function get()
    {
        $Control = new Control();
        $Engine = QUI::getTemplateManager()->getEngine();

        if ($Control->getProject()->getConfig('socialshare.settings.theme')) {
            self::$settings['theme'] = $Control->getProject()->getConfig('socialshare.settings.theme');
        }

        if ($Control->getProject()->getConfig('socialshare.settings.showLabel')) {
            self::$settings['showLabel'] = $Control->getProject()->getConfig('socialshare.settings.showLabel');
        }

        if ($Control->getProject()->getConfig('socialshare.settings.showIcon')) {
            self::$settings['showIcon'] = $Control->getProject()->getConfig('socialshare.settings.showIcon');
        }

        if ($Control->getProject()->getConfig('socialshare.settings.showCount')) {
            self::$settings['showCount'] = $Control->getProject()->getConfig('socialshare.settings.showCount');
        }

        $socialArr = array();
        foreach (self::$availableSocials as $social) {
            $setting = 'socialshare.settings.' . $social;
            if (!$Control->getProject()->getConfig($setting)) {
                continue;
            }

            $class = 'QUI\Socialshare\Shares\\' . $social;
            $Social = new $class(self::$settings);
            array_push($socialArr, $Social);
        };

        $Engine->assign('Socials', $socialArr);

        return $Engine->fetch(dirname(__FILE__) . '/Socialshare.html');
    }
}
