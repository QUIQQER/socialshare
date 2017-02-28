<?php
/**
 * This file contains QUI\Socialshare\Manager
 */

namespace QUI\Socialshare;

use QUI;
use QUI\Control;

/**
 * Social share Manager
 *
 * @package quiqqer/socialshare
 */
class Manager extends Control
{
    /**
     * @var array
     */
    private $availableSocials = array('facebook', 'twitter', 'google');

    /**
     * Manager constructor.
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
     *
     */
    public static function getSocials($params = array())
    {
        foreach ($params as $item => $value) {
            if (isset($item, $availableSocials)) {
                $social = strtolower($item);
                $social = upfirst($social);

                $social = new QUI\Socialshare\Shares\ . $social . ();
            }
        }
    }
}
