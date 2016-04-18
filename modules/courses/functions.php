<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 09:05:18 GMT
 */

if ( ! defined( 'NV_SYSTEM' ) ) die( 'Stop!!!' );

define( 'NV_IS_MOD_COURSES', true );

if (! in_array($op, array( 'viewcat', 'detail' ))) {
    define('NV_IS_MOD_NEWS', true);
}
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

global $global_array_sciencecat;
$global_array_sciencecat = array();
$catid = 0;
$parentid = 0;
$alias_sciencecat_url = isset($array_op[0]) ? $array_op[0] : '';
$array_mod_title = array();

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat ORDER BY sort ASC';
$list = $nv_Cache->db($sql, 'catid', $module_name);
foreach ($list as $l) {
    $global_array_sciencecat[$l['catid']] = $l;
    $global_array_sciencecat[$l['catid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
    if ($alias_sciencecat_url == $l['alias']) {
        $catid = $l['catid'];
        $parentid = $l['parentid'];
    }
}

//Xac dinh RSS
if ($module_info['rss']) {
    $rss[] = array(
        'title' => $module_info['custom_title'],
        'src' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['rss']
    );
}

foreach ($global_array_sciencecat as $catid_i => $array_sciencecat_i) {
    if ($catid_i > 0 and $array_sciencecat_i['parentid'] == 0) {
        $act = 0;
        $submenu = array();
        if ($catid_i == $catid or $catid_i == $parentid) {
            $act = 1;
            if (! empty($global_array_sciencecat[$catid_i]['subcatid'])) {
                $array_sciencecatid = explode(',', $global_array_sciencecat[$catid_i]['subcatid']);
                foreach ($array_sciencecatid as $sub_sciencecatid_i) {
                    $array_sub_sciencecat_i = $global_array_sciencecat[$sub_sciencecatid_i];
                    $sub_act = 0;
                    if ($sub_sciencecatid_i == $catid) {
                        $sub_act = 1;
                    }
                    $submenu[] = array( $array_sub_sciencecat_i['title'], $array_sub_sciencecat_i['link'], $sub_act );
                }
            }
        }
        $nv_vertical_menu[] = array( $array_sciencecat_i['title'], $array_sciencecat_i['link'], $act, 'submenu' => $submenu );
    }

    //Xac dinh RSS
    if ($catid_i and $module_info['rss']) {
        $rss[] = array(
            'title' => $module_info['custom_title'] . ' - ' . $array_sciencecat_i['title'],
            'src' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['rss'] . '/' . $array_sciencecat_i['alias']
        );
    }
}
unset($result, $catid_i, $parentid_i, $title_i, $alias_i);


$row = array();
$error = array();

$global_array_courses = array();
$_sql = 'SELECT * FROM nv4_vi_courses_courses';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$global_array_courses[$_row['id']] = $_row;
}

$global_array_students = array();
$_sql = 'SELECT * FROM nv4_vi_courses_students';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$global_array_students[$_row['id']] = $_row;
}

$global_array_teacher = array();
$_sql = 'SELECT * FROM nv4_vi_courses_teacher';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$global_array_teacher[$_row['id']] = $_row;
}



$module_info['submenu'] = 0;

$page = 1;
$per_page = $module_config[$module_name]['per_page'];
$st_links = $module_config[$module_name]['st_links'];
$count_op = sizeof($array_op);
if (! empty($array_op) and $op == 'main') {
    $op = 'main';
    if ($count_op == 1 or substr($array_op[1], 0, 5) == 'page-') {
        if ($count_op > 1 or $catid > 0) {
            $op = 'viewcat';
            if( isset($array_op[1]) and substr($array_op[1], 0, 5) == 'page-' ){
                $page = intval(substr($array_op[1], 5));   
            }
        }
        elseif ($catid == 0) {
            $contents = $lang_module['nocatpage'] . $array_op[0];       
            if (isset($array_op[0]) and substr($array_op[0], 0, 5) == 'page-') {
                $page = intval(substr($array_op[0], 5));
            }
        }
    } elseif ($count_op == 2) {
        $array_page = explode('-', $array_op[1]);
        $id = intval(end($array_page));
        $number = strlen($id) + 1;
        $alias_url = substr($array_op[1], 0, -$number);
        if ($id > 0 and $alias_url != '') {
            if ($catid > 0) {
				$op = 'detail';
			} else {
				//muc tieu neu xoa chuyen muc cu hoac doi ten alias chuyen muc thi van rewrite duoc bai viet
				$_row = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_courses WHERE id = ' . $id )->fetch();
				if (!empty($_row) and isset($global_array_sciencecat[$_row['sciencecat']])) {
    				$url_Permanently = nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_sciencecat[$_row['sciencecat']]['alias'] . '/' . $_row['alias'] . '-' . $_row['id'] . $global_config['rewrite_exturl'], true );
    				header( "HTTP/1.1 301 Moved Permanently" );
    				header( 'Location:' . $url_Permanently );
    				exit();
				}
			}
        }
    }
    $parentid = $catid;
    while ($parentid > 0) {
        $array_sciencecat_i = $global_array_sciencecat[$parentid];
        $array_mod_title[] = array(
            'catid' => $parentid,
            'title' => $array_sciencecat_i['title'],
            'link' => $array_sciencecat_i['link']
        );
        $parentid = $array_sciencecat_i['parentid'];
    }
    sort($array_mod_title, SORT_NUMERIC);
}





/**
 * nv_custom_tpl()
 *
 * @param mixed $name_file
 * @param mixed $array_custom
 * @param mixed $array_custom_lang
 * @param mixed $idtemplate
 * @return
 */
function nv_listcourse_tpl($news_contents)
{
    global $module_data, $module_info, $module_name, $module_file, $lang_module, $db_config, $db, $global_config, $global_array_sciencecat, $global_array_courses, $global_array_students, $global_array_teacher, $op;

    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_list where cid=' . $news_contents ['id'];
    $result = $db->query($sql);

    $html ='';
    $xtpl = new XTemplate('student_list.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
	$xtpl->assign( 'LANG', $lang_module );
	$number =1;
    while ($view = $result->fetch()) {
       $view['number'] = $number++;
		$view['scid'] = $global_array_sciencecat[$view['scid']]['title'];
		$view['cid'] = $global_array_courses[$view['cid']]['name_courses'];
		$view['fname'] = $global_array_students[$view['sid']]['fname'];
		$view['lname'] = $global_array_students[$view['sid']]['lname'];
		$view['phone'] = $global_array_students[$view['sid']]['phone'];
		$view['email'] = $global_array_students[$view['sid']]['email'];
		$view['address'] = $global_array_students[$view['sid']]['address'];
		$view['id_student'] = $global_array_students[$view['sid']]['id_student'];
		
		$xtpl->assign( 'VIEW', $view );
		$xtpl->parse( 'main.view.loop' );
    }
	$xtpl->parse( 'main.view' );
	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );
    

    return $contents;
}


