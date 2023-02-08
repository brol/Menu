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
if (!defined('DC_CONTEXT_ADMIN')) { return; }

// Admin dashbaord favorite
dcCore::app()->addBehavior('adminDashboardFavoritesV2', function ($favs) {
    $favs->register(basename(__DIR__), [
        'title'       => __('Menu'),
        'url'         => dcCore::app()->adminurl->get('admin.plugin.' . basename(__DIR__)),
        'small-icon'  => dcPage::getPF(basename(__DIR__) . '/icon.png'),
        'large-icon'  => dcPage::getPF(basename(__DIR__) . '/icon-big.png'),
        'permissions' => dcCore::app()->auth->makePermissions([
            dcAuth::PERMISSION_USAGE,
            dcAuth::PERMISSION_CONTENT_ADMIN,
        ]),
    ]);
});

// Admin sidebar menu
dcCore::app()->menu[dcAdmin::MENU_BLOG]->addItem(
    __('Menu'),
    dcCore::app()->adminurl->get('admin.plugin.' . basename(__DIR__)),
    dcPage::getPF(basename(__DIR__) . '/icon.png'),
    preg_match(
        '/' . preg_quote(dcCore::app()->adminurl->get('admin.plugin.' . basename(__DIR__))) . '(&.*)?$/',
        $_SERVER['REQUEST_URI']
    ),
    dcCore::app()->auth->check(dcCore::app()->auth->makePermissions([
        dcAuth::PERMISSION_USAGE,
        dcAuth::PERMISSION_CONTENT_ADMIN,
    ]), dcCore::app()->blog->id)
);

dcCore::app()->auth->setPermissionType('menu',__('manage menu'));

require dirname(__FILE__).'/_widgets.php';

# Enregistrement des fonctions d'exportation
dcCore::app()->addBehavior('exportFull',array('menuClass','exportFull'));
dcCore::app()->addBehavior('exportSingle',array('menuClass','exportSingle'));
dcCore::app()->addBehavior('importInit',array('menuClass','importInit'));
dcCore::app()->addBehavior('importFull',array('menuClass','importFull'));
dcCore::app()->addBehavior('importSingle',array('menuClass','importSingle'));

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
			'FROM '.dcCore::app()->prefix.'menu '.
			'WHERE blog_id = "'.$blog_id.'"'
		);
	}

	# importInit behavior
	public static function importInit($bk,$core)
	{
		$strReq =
		'TRUNCATE TABLE '.dcCore::app()->prefix.'menu';
		dcCore::app()->con->execute($strReq);

		$bk->cur_menu = dcCore::app()->con->openCursor(dcCore::app()->prefix.'menu');
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
  			$bk->cur_menu->blog_id   = (string) dcCore::app()->blog->id;
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