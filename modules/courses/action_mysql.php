<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Fri, 08 Apr 2016 07:18:41 GMT
 */

if ( ! defined( 'NV_IS_FILE_MODULES' ) ) die( 'Stop!!!' );

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_admins";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_courses";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_list";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_science";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_sciencecat";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_students";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subject";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags_id";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_teacher";

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_admins(
  userid mediumint(8) unsigned NOT NULL DEFAULT '0',
  catid smallint(5) NOT NULL DEFAULT '0',
  admin tinyint(4) NOT NULL DEFAULT '0',
  add_content tinyint(4) NOT NULL DEFAULT '0',
  pub_content tinyint(4) NOT NULL DEFAULT '0',
  edit_content tinyint(4) NOT NULL DEFAULT '0',
  del_content tinyint(4) NOT NULL DEFAULT '0',
  app_content tinyint(4) NOT NULL DEFAULT '0',
  idsite int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY userid (userid,catid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post(
  group_id smallint(5) NOT NULL,
  addcontent tinyint(4) NOT NULL,
  postcontent tinyint(4) NOT NULL,
  editcontent tinyint(4) NOT NULL,
  delcontent tinyint(4) NOT NULL,
  PRIMARY KEY (group_id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_courses(
  id tinyint(4) NOT NULL AUTO_INCREMENT,
  id_courses varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'mã khóa học',
  sciencecat varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Thuộc khóa học',
  alias varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  name_courses varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'tên khóa học',
  schedule varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'lịch học',
  duration tinyint(4) NOT NULL COMMENT 'thời lượng học',
  fee int(11) NOT NULL COMMENT 'học phí',
  total tinyint(4) NOT NULL COMMENT 'sl học viên',
  time_start date NOT NULL COMMENT 'thời gian bắt đầu',
  time_end date NOT NULL COMMENT 'thời gian kết thúc',
  note text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ghi chú khác ',
  status tinyint(4) NOT NULL COMMENT 'trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_list(
  id int(11) NOT NULL AUTO_INCREMENT,
  cid varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  sid varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  tid varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs(
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  sid mediumint(8) NOT NULL DEFAULT '0',
  userid mediumint(8) unsigned NOT NULL DEFAULT '0',
  status tinyint(4) NOT NULL DEFAULT '0',
  note varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  set_time int(11) unsigned NOT NULL DEFAULT '0',
  idsite int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY sid (sid),
  KEY userid (userid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_science(
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  catid smallint(5) unsigned NOT NULL DEFAULT '0',
  listcatid varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  topicid smallint(5) unsigned NOT NULL DEFAULT '0',
  admin_id mediumint(8) unsigned NOT NULL DEFAULT '0',
  author varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT '',
  sourceid mediumint(8) NOT NULL DEFAULT '0',
  addtime int(11) unsigned NOT NULL DEFAULT '0',
  edittime int(11) unsigned NOT NULL DEFAULT '0',
  status tinyint(4) NOT NULL DEFAULT '1',
  publtime int(11) unsigned NOT NULL DEFAULT '0',
  exptime int(11) unsigned NOT NULL DEFAULT '0',
  archive tinyint(1) unsigned NOT NULL DEFAULT '0',
  title varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  alias varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  hometext text COLLATE utf8mb4_unicode_ci NOT NULL,
  homeimgfile varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  homeimgalt varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  homeimgthumb tinyint(4) NOT NULL DEFAULT '0',
  inhome tinyint(1) unsigned NOT NULL DEFAULT '0',
  allowed_comm varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  allowed_rating tinyint(1) unsigned NOT NULL DEFAULT '0',
  hitstotal mediumint(8) unsigned NOT NULL DEFAULT '0',
  hitscm mediumint(8) unsigned NOT NULL DEFAULT '0',
  total_rating int(11) NOT NULL DEFAULT '0',
  click_rating int(11) NOT NULL DEFAULT '0',
  idsite int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY catid (catid),
  KEY topicid (topicid),
  KEY admin_id (admin_id),
  KEY author (author),
  KEY title (title),
  KEY addtime (addtime),
  KEY publtime (publtime),
  KEY exptime (exptime),
  KEY status (status)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_sciencecat(
  catid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  parentid smallint(5) unsigned NOT NULL DEFAULT '0',
  title varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  titlesite varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT '',
  alias varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  description text COLLATE utf8mb4_unicode_ci,
  descriptionhtml text COLLATE utf8mb4_unicode_ci,
  image varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  viewdescription tinyint(2) NOT NULL DEFAULT '0',
  weight smallint(5) unsigned NOT NULL DEFAULT '0',
  sort smallint(5) NOT NULL DEFAULT '0',
  lev smallint(5) NOT NULL DEFAULT '0',
  viewcat varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'viewcat_page_new',
  numsubcat smallint(5) NOT NULL DEFAULT '0',
  subcatid varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  inhome tinyint(1) unsigned NOT NULL DEFAULT '0',
  numlinks tinyint(2) unsigned NOT NULL DEFAULT '3',
  newday tinyint(2) unsigned NOT NULL DEFAULT '2',
  featured int(11) NOT NULL DEFAULT '0',
  keywords text COLLATE utf8mb4_unicode_ci,
  admins text COLLATE utf8mb4_unicode_ci,
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  edit_time int(11) unsigned NOT NULL DEFAULT '0',
  groups_view varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  subjectcat varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  idsite int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (catid),
  UNIQUE KEY alias (alias),
  KEY parentid (parentid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_students(
  id int(11) NOT NULL AUTO_INCREMENT,
  id_student varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  alias varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  fname varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  lname varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  email varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  phone varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  address varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  note varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subject(
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  catid smallint(5) unsigned NOT NULL DEFAULT '0',
  listcatid varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  topicid smallint(5) unsigned NOT NULL DEFAULT '0',
  admin_id mediumint(8) unsigned NOT NULL DEFAULT '0',
  author varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT '',
  sourceid mediumint(8) NOT NULL DEFAULT '0',
  addtime int(11) unsigned NOT NULL DEFAULT '0',
  edittime int(11) unsigned NOT NULL DEFAULT '0',
  status tinyint(4) NOT NULL DEFAULT '1',
  publtime int(11) unsigned NOT NULL DEFAULT '0',
  exptime int(11) unsigned NOT NULL DEFAULT '0',
  archive tinyint(1) unsigned NOT NULL DEFAULT '0',
  title varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  alias varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  hometext text COLLATE utf8mb4_unicode_ci NOT NULL,
  homeimgfile varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  homeimgalt varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  homeimgthumb tinyint(4) NOT NULL DEFAULT '0',
  inhome tinyint(1) unsigned NOT NULL DEFAULT '0',
  allowed_comm varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  allowed_rating tinyint(1) unsigned NOT NULL DEFAULT '0',
  hitstotal mediumint(8) unsigned NOT NULL DEFAULT '0',
  hitscm mediumint(8) unsigned NOT NULL DEFAULT '0',
  total_rating int(11) NOT NULL DEFAULT '0',
  click_rating int(11) NOT NULL DEFAULT '0',
  idsite int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY catid (catid),
  KEY topicid (topicid),
  KEY admin_id (admin_id),
  KEY author (author),
  KEY title (title),
  KEY addtime (addtime),
  KEY publtime (publtime),
  KEY exptime (exptime),
  KEY status (status)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat(
  catid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  parentid smallint(5) unsigned NOT NULL DEFAULT '0',
  title varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  titlesite varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT '',
  alias varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  description text COLLATE utf8mb4_unicode_ci,
  descriptionhtml text COLLATE utf8mb4_unicode_ci,
  image varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  viewdescription tinyint(2) NOT NULL DEFAULT '0',
  weight smallint(5) unsigned NOT NULL DEFAULT '0',
  sort smallint(5) NOT NULL DEFAULT '0',
  lev smallint(5) NOT NULL DEFAULT '0',
  viewcat varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'viewcat_page_new',
  numsubcat smallint(5) NOT NULL DEFAULT '0',
  subcatid varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  inhome tinyint(1) unsigned NOT NULL DEFAULT '0',
  numlinks tinyint(2) unsigned NOT NULL DEFAULT '3',
  newday tinyint(2) unsigned NOT NULL DEFAULT '2',
  featured int(11) NOT NULL DEFAULT '0',
  keywords text COLLATE utf8mb4_unicode_ci,
  admins text COLLATE utf8mb4_unicode_ci,
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  edit_time int(11) unsigned NOT NULL DEFAULT '0',
  groups_view varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  idsite int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (catid),
  UNIQUE KEY alias (alias),
  KEY parentid (parentid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags(
  tid mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  numnews mediumint(8) NOT NULL DEFAULT '0',
  alias varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  image varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  description text COLLATE utf8mb4_unicode_ci,
  keywords varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  idsite int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (tid),
  UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags_id(
  id int(11) NOT NULL,
  tid mediumint(9) NOT NULL,
  keyword varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  idsite int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY id_tid (id,tid),
  KEY tid (tid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_teacher(
  id int(11) NOT NULL AUTO_INCREMENT,
  id_student varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  alias varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  fname varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  lname varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  email varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  phone varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  address varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  note varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM";


$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post (group_id, addcontent, postcontent, editcontent, delcontent) VALUES('1', '0', '0', '0', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post (group_id, addcontent, postcontent, editcontent, delcontent) VALUES('2', '0', '0', '0', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post (group_id, addcontent, postcontent, editcontent, delcontent) VALUES('3', '0', '0', '0', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post (group_id, addcontent, postcontent, editcontent, delcontent) VALUES('4', '0', '0', '0', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post (group_id, addcontent, postcontent, editcontent, delcontent) VALUES('7', '0', '0', '0', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post (group_id, addcontent, postcontent, editcontent, delcontent) VALUES('5', '0', '0', '0', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post (group_id, addcontent, postcontent, editcontent, delcontent) VALUES('10', '0', '0', '0', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post (group_id, addcontent, postcontent, editcontent, delcontent) VALUES('11', '0', '0', '0', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post (group_id, addcontent, postcontent, editcontent, delcontent) VALUES('12', '0', '0', '0', '0')";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_courses (id, id_courses, sciencecat, alias, name_courses, schedule, duration, fee, total, time_start, time_end, note, status) VALUES('1', 'IBKG4/4/2016', '1', 'Internet-Business-Kinh-doanh-tren-internet-KG-4-4', 'Internet Business - Kinh doanh trên internet - KG 4/4/2016', '1', '18', '3600000', '30', '0000-00-00', '0000-00-00', '', '1')";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_list (id, cid, sid, tid) VALUES('1', '1', '1', '1')";



$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_sciencecat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, subjectcat, idsite) VALUES('1', '0', 'Internet Business - Kinh doanh trên internet', '', 'Internet-Business-Kinh-doanh-tren-internet', '', 'Gồm 6 môn học', '', '0', '1', '1', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460024006', '1460028149', '6', '1,2,3,4,5,6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_sciencecat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, subjectcat, idsite) VALUES('2', '0', 'Xây dựng &amp; Thiết kế web doanh nghiệp bằng Joomla', '', 'Xay-dung-Thiet-ke-web-doanh-nghiep-bang-Joomla', '', '', '', '0', '2', '2', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460028814', '1460028814', '6', '7,10', '0')";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_students (id, id_student, alias, fname, lname, email, phone, address, note) VALUES('1', '', '', 'Nguyễn Thanh', 'Hoàng', 'adminwmt@gmail.com', '0988455066', '12/3D Đường 06, P.Linh Xuân, Thủ Đức TPHCM', '')";


$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('1', '0', 'Online maketting', '', 'Online-maketting', '', '', '', '0', '1', '1', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460022345', '1460022345', '6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('2', '0', 'Email maketting', '', 'Email-maketting', '', '', '', '0', '2', '2', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460022365', '1460022365', '6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('3', '0', 'Seo website', '', 'Seo-website', '', '', '', '0', '3', '3', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460022384', '1460022384', '6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('4', '0', 'Video maketting', '', 'Video-maketting', '', '', '', '0', '4', '4', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460022399', '1460022399', '6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('5', '0', 'Picture maketting', '', 'Picture-maketting', '', '', '', '0', '5', '5', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460022424', '1460022424', '6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('6', '0', 'Thiết kế website', '', 'Thiet-ke-website', '', '', '', '0', '6', '6', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460022451', '1460022451', '6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('7', '0', 'Joomla căn bản', '', 'Joomla-can-ban', '', '', '', '0', '7', '7', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460023126', '1460023126', '6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('8', '0', 'Wordpress căn bản', '', 'Wordpress-can-ban', '', '', '', '0', '8', '8', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460023144', '1460023144', '6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('9', '0', 'Opencart căn bản', '', 'Opencart-can-ban', '', '', '', '0', '9', '9', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460023178', '1460023178', '6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('10', '0', 'Joomla nâng cao', '', 'Joomla-nang-cao', '', '', '', '0', '10', '10', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460023191', '1460023191', '6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('11', '0', 'Wordpress nâng cao', '', 'Wordpress-nang-cao', '', '', '', '0', '11', '11', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460023216', '1460023216', '6', '0')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectcat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, featured, keywords, admins, add_time, edit_time, groups_view, idsite) VALUES('12', '0', 'Opencart nâng cao', '', 'Opencart-nang-cao', '', '', '', '0', '12', '12', '0', 'viewcat_page_new', '0', '', '1', '3', '2', '0', '', '', '1460023233', '1460023233', '6', '0')";



$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_teacher (id, id_student, alias, fname, lname, email, phone, address, note) VALUES('1', '', '', 'Nguyễn Thanh', 'Hoàng', 'adminwmt@gmail.com', '0988455066', '12/3D Đường 06, P.Linh Xuân, Thủ Đức TPHCM', '')";

$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'indexfile', 'viewcat_main_right')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'per_page', '20')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'st_links', '10')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'homewidth', '100')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'homeheight', '150')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'blockwidth', '70')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'blockheight', '75')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'imagefull', '460')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'copyright', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'showtooltip', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'tooltip_position', 'bottom')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'tooltip_length', '150')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'showhometext', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'timecheckstatus', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'config_source', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'show_no_image', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'allowed_rating_point', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'facebookappid', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'socialbutton', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'alias_lower', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'tags_alias', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'auto_tags', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'tags_remind', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'structure_upload', 'Ym')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'imgposition', '2')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'auto_postcomm', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'allowed_comm', '-1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'view_comm', '6')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'setcomm', '4')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'activecomm', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'emailcomm', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'adminscomm', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'sortcomm', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'captcha', '1')";