<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 09:05:18 GMT
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$module_version = array(
	'name' => 'Courses',
	'modfuncs' => 'main,detail,search,rss,Sitemap,viewcat',
	'change_alias' => 'main,detail,search,rss,Sitemap,viewcat',
	'submenu' => 'main,detail,search,rss,Sitemap,viewcat',
	'is_sysmod' => 0,
	'virtual' => 1,
	'version' => '4.0.00',
	'date' => 'Wed, 6 Apr 2016 09:05:19 GMT',
	'author' => 'webvang (hoang.nguyen@webvang.vn)',
	'uploads_dir' => array($module_name),
	'note' => 'Module Quản lý khóa học'
);