<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
# This file is part of Menu, a plugin for Dotclear 2.
#
# Copyright (c) 2009-2018 Benoît Grelier and contributors
# Licensed under the GPL version 2.0 license.
# See LICENSE file or
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
#
# -- END LICENSE BLOCK ------------------------------------
if (!defined('DC_CONTEXT_ADMIN')) { return; }

$core->addBehavior('adminDashboardFavorites','menuDashboardFavorites');

function menuDashboardFavorites($core,$favs)
{
	$favs->register('menu', array(
		'title' => __('Menu'),
		'url' => 'plugin.php?p=menu',
		'small-icon' => 'index.php?pf=menu/icon.png',
		'large-icon' => 'index.php?pf=menu/icon-big.png',
		'permissions' => 'usage,contentadmin'
	));
}

$_menu['Blog']->addItem(__('Menu'),'plugin.php?p=menu','index.php?pf=menu/icon.png',
                preg_match('/plugin.php\?p=menu(&.*)?$/',$_SERVER['REQUEST_URI']),
                $core->auth->check('usage,contentadmin',$core->blog->id));

$core->auth->setPermissionType('menu',__('manage menu'));

require dirname(__FILE__).'/_widgets.php';

# Enregistrement des fonctions d'exportation
$core->addBehavior('exportFull',array('menuClass','exportFull'));
$core->addBehavior('exportSingle',array('menuClass','exportSingle'));
$core->addBehavior('importInit',array('menuClass','importInit'));
$core->addBehavior('importFull',array('menuClass','importFull'));
$core->addBehavior('importSingle',array('menuClass','importSingle'));

class menuClass
{
	# Full export behavior
	public static function exportFull($core,$exp)
	{
		$exp->exportTable('menu');
	}

	# Single blog export behavior
	public static function exportSingle($core,$exp,$blog_id)
	{
		$exp->export('menu',
			'SELECT * '.
			'FROM '.$core->prefix.'menu '.
			'WHERE blog_id = "'.$blog_id.'"'
		);
	}

	# importInit behavior
	public static function importInit($bk,$core)
	{
		$strReq =
		'TRUNCATE TABLE '.$core->prefix.'menu';
		$core->con->execute($strReq);

		$bk->cur_menu = $core->con->openCursor($core->prefix.'menu');
	}

	# Full blog import behavior
	public static function importFull($line,$bk,$core)
	{
        if ($line->__name == 'menu') {

        $bk->cur_menu->clean();
        $bk->cur_menu->link_id   = (integer) $line->link_id;
  			$bk->cur_menu->blog_id   = (string) $line->blog_id;
  			$bk->cur_menu->link_href   = (string) $line->link_href;
  			$bk->cur_menu->link_title   = (string) $line->link_title;
  			$bk->cur_menu->link_desc   = (string) $line->link_desc;
  			$bk->cur_menu->link_lang   = (string) $line->link_lang;
  			$bk->cur_menu->link_class   = (string) $line->link_class;
        $bk->cur_menu->link_position   = (integer) $line->link_position;
        $bk->cur_menu->link_level   = (integer) $line->link_level;
        $bk->cur_menu->link_auto   = (integer) $line->link_auto;
  			$bk->cur_menu->link_limit   = (integer) $line->link_limit;

        $bk->cur_menu->insert();
        }
    }

  # Single blog import behavior
  	public static function importSingle($line,$bk,$core)
  	{
        if ($line->__name == 'menu') {

        $bk->cur_menu->clean();
        $bk->cur_menu->link_id   = (integer) $line->link_id;
  			$bk->cur_menu->blog_id   = (string) $core->blog->id;
  			$bk->cur_menu->link_href   = (string) $line->link_href;
  			$bk->cur_menu->link_title   = (string) $line->link_title;
  			$bk->cur_menu->link_desc   = (string) $line->link_desc;
  			$bk->cur_menu->link_lang   = (string) $line->link_lang;
  			$bk->cur_menu->link_class   = (string) $line->link_class;
        $bk->cur_menu->link_position   = (integer) $line->link_position;
        $bk->cur_menu->link_level   = (integer) $line->link_level;
        $bk->cur_menu->link_auto   = (integer) $line->link_auto;
  			$bk->cur_menu->link_limit   = (integer) $line->link_limit;

        $bk->cur_menu->insert();
        }
    }
}