<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 09:05:18 GMT
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_courses";

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_sciencecat";

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectscat";

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_students";

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags";

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags_id";

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs";

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_admins";


$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_courses (
  id tinyint(4) NOT NULL AUTO_INCREMENT,
  id_courses varchar(11) NOT NULL COMMENT 'mã khóa học',
  alias varchar(50) NOT NULL,
  name_courses varchar(100) NOT NULL COMMENT 'tên khóa học',
  schedule varchar(20) NOT NULL COMMENT 'lịch học',
  duration tinyint(4) NOT NULL COMMENT 'thời lượng học',
  fee int(11) NOT NULL COMMENT 'học phí',
  total tinyint(4) NOT NULL COMMENT 'sl học viên',
  time_start date NOT NULL COMMENT 'thời gian bắt đầu',
  time_end date NOT NULL COMMENT 'thời gian kết thúc',
  note text NOT NULL COMMENT 'ghi chú khác ',
  status tinyint(4) NOT NULL COMMENT 'trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_sciencecat (
  catid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	  parentid smallint(5) unsigned NOT NULL DEFAULT '0',
	  title varchar(250) NOT NULL,
	  titlesite varchar(250) DEFAULT '',
	  alias varchar(250) NOT NULL DEFAULT '',
	  description text,
	  descriptionhtml text,
	  image varchar(255) DEFAULT '',
	  viewdescription tinyint(2) NOT NULL DEFAULT '0',
	  weight smallint(5) unsigned NOT NULL DEFAULT '0',
	  sort smallint(5) NOT NULL DEFAULT '0',
	  lev smallint(5) NOT NULL DEFAULT '0',
	  viewcat varchar(50) NOT NULL DEFAULT 'viewcat_page_new',
	  numsubcat smallint(5) NOT NULL DEFAULT '0',
	  subcatid varchar(255) DEFAULT '',
	  inhome tinyint(1) unsigned NOT NULL DEFAULT '0',
	  numlinks tinyint(2) unsigned NOT NULL DEFAULT '3',
	  newday tinyint(2) unsigned NOT NULL DEFAULT '2',
	  featured int(11) NOT NULL DEFAULT '0',
	  keywords text,
	  admins text,
	  add_time int(11) unsigned NOT NULL DEFAULT '0',
	  edit_time int(11) unsigned NOT NULL DEFAULT '0',
	  groups_view varchar(255) DEFAULT '',
	  idsite int(11) NOT NULL DEFAULT '0',
	  PRIMARY KEY (catid),
	  UNIQUE KEY alias (alias),
	  KEY parentid (parentid)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectscat (
  catid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	  parentid smallint(5) unsigned NOT NULL DEFAULT '0',
	  title varchar(250) NOT NULL,
	  titlesite varchar(250) DEFAULT '',
	  alias varchar(250) NOT NULL DEFAULT '',
	  description text,
	  descriptionhtml text,
	  image varchar(255) DEFAULT '',
	  viewdescription tinyint(2) NOT NULL DEFAULT '0',
	  weight smallint(5) unsigned NOT NULL DEFAULT '0',
	  sort smallint(5) NOT NULL DEFAULT '0',
	  lev smallint(5) NOT NULL DEFAULT '0',
	  viewcat varchar(50) NOT NULL DEFAULT 'viewcat_page_new',
	  numsubcat smallint(5) NOT NULL DEFAULT '0',
	  subcatid varchar(255) DEFAULT '',
	  inhome tinyint(1) unsigned NOT NULL DEFAULT '0',
	  numlinks tinyint(2) unsigned NOT NULL DEFAULT '3',
	  newday tinyint(2) unsigned NOT NULL DEFAULT '2',
	  featured int(11) NOT NULL DEFAULT '0',
	  keywords text,
	  admins text,
	  add_time int(11) unsigned NOT NULL DEFAULT '0',
	  edit_time int(11) unsigned NOT NULL DEFAULT '0',
	  groups_view varchar(255) DEFAULT '',
	  idsite int(11) NOT NULL DEFAULT '0',
	  PRIMARY KEY (catid),
	  UNIQUE KEY alias (alias),
	  KEY parentid (parentid)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_students (
  id int(11) NOT NULL AUTO_INCREMENT,
  id_student varchar(11) NOT NULL,
  alias varchar(50) NOT NULL,
  fname varchar(50) NOT NULL,
  fname varchar(50) NOT NULL,
  email varchar(30) NOT NULL,
  phone varchar(11) NOT NULL,
  address varchar(255) NOT NULL,
  note varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags (
	 tid mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	 numnews mediumint(8) NOT NULL DEFAULT '0',
	 alias varchar(250) NOT NULL DEFAULT '',
	 image varchar(255) DEFAULT '',
	 description text,
	 keywords varchar(255) DEFAULT '',
	 idsite int(11) NOT NULL DEFAULT '0',
	 PRIMARY KEY (tid),
	 UNIQUE KEY alias (alias)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags_id (
	 id int(11) NOT NULL,
	 tid mediumint(9) NOT NULL,
	 keyword varchar(65) NOT NULL,
	 idsite int(11) NOT NULL DEFAULT '0',
	 UNIQUE KEY id_tid (id,tid),
	 KEY tid (tid)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs (
	 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	 sid mediumint(8) NOT NULL DEFAULT '0',
	 userid mediumint(8) unsigned NOT NULL DEFAULT '0',
	 status tinyint(4) NOT NULL DEFAULT '0',
	 note varchar(255) NOT NULL,
	 set_time int(11) unsigned NOT NULL DEFAULT '0',
	 idsite int(11) NOT NULL DEFAULT '0',
	 PRIMARY KEY (id),
	 KEY sid (sid),
	 KEY userid (userid)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_admins (
userid mediumint(8) unsigned NOT NULL default '0',
	 catid smallint(5) NOT NULL default '0',
	 admin tinyint(4) NOT NULL default '0',
	 add_content tinyint(4) NOT NULL default '0',
	 pub_content tinyint(4) NOT NULL default '0',
	 edit_content tinyint(4) NOT NULL default '0',
	 del_content tinyint(4) NOT NULL default '0',
	 app_content tinyint(4) NOT NULL default '0',
	 idsite int(11) NOT NULL DEFAULT '0',
	 UNIQUE KEY userid (userid,catid)
) ENGINE=MyISAM;";