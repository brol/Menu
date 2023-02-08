<?php
/**
 * @brief Menu, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugin
 *
 * @author Benoît Grelier and contributors
 *
 * @copyright GPL-2.0 https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
if (!defined('DC_RC_PATH')) { return; }

$this->registerModule(
    'Menu',
    'Manage your menu',
    'Adjaya, Pierre Van Glabeke and contributors',
    '2.0.2',
    [
        'requires'    => [['core', '2.24']],
        'permissions' => dcCore::app()->auth->makePermissions([
            dcAuth::PERMISSION_CONTENT_ADMIN,
        ]),
        'type'       => 'plugin',
        'support'    => 'https://forum.dotclear.org/viewtopic.php?id=32705',
        'details'    => 'https://plugins.dotaddict.org/dc2/details/' . basename(__DIR__),
    ]
);
