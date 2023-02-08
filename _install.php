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

$version = dcCore::app()->plugins->moduleInfo('menu','version');

if (version_compare(dcCore::app()->getVersion('menu'),$version,'>=')) {
	return;
}

/* Database schema
-------------------------------------------------------- */
$s = new dbStruct(dcCore::app()->con,dcCore::app()->prefix);

$s->menu
	->link_id		('bigint',	0,		false)
	->blog_id		('varchar',	32,		false)
	->link_href		('varchar',	255,	false)
	->link_title	('varchar',	255,	false)
	->link_desc		('varchar',	255,	true)
	->link_lang		('varchar',	5,		true)
	->link_class 	('varchar',	32, 	true)
	->link_position	('integer',	0,	false, 0)
	->link_level	('smallint', 0,	false, 0)
	->link_auto		('smallint', 0,	false, 0)
	->link_limit	('smallint', 0,	false, 0)
	
	->primary('pk_menu','link_id')
	;

$s->menu->index('idx_menu_blog_id','btree','blog_id');
$s->menu->reference('fk_menu_blog','blog_id','blog','blog_id','cascade','cascade');

# Schema installation
$si = new dbStruct(dcCore::app()->con,dcCore::app()->prefix);
$changes = $si->synchronize($s);

dcCore::app()->setVersion('menu',$version);
return true;