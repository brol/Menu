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
if (!defined('DC_RC_PATH')) {
    return;
}

dcCore::app()->resources['help']['menu'] = __DIR__ . '/help/menu.html';