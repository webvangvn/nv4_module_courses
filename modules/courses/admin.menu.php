<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 09:05:18 GMT
 */


if (! defined('NV_ADMIN')) {
    die('Stop!!!');
}

if (! function_exists('nv_news_array_cat_admin')) {
    /**
     * nv_news_array_cat_admin()
     *
     * @return
     */
    function nv_news_array_cat_admin($module_data)
    {
        global $db_slave;

        $array_cat_admin = array();
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins ORDER BY userid ASC';
        $result = $db_slave->query($sql);

        while ($row = $result->fetch()) {
            $array_cat_admin[$row['userid']][$row['catid']] = $row;
        }

        return $array_cat_admin;
    }
}

$is_refresh = false;
$array_cat_admin = nv_news_array_cat_admin($module_data);

if (! empty($module_info['admins'])) {
    $module_admin = explode(',', $module_info['admins']);
    foreach ($module_admin as $userid_i) {
        if (! isset($array_cat_admin[$userid_i])) {
            $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_admins (userid, catid, admin, add_content, pub_content, edit_content, del_content) VALUES (' . $userid_i . ', 0, 1, 1, 1, 1, 1)');
            $is_refresh = true;
        }
    }
}
if ($is_refresh) {
    $array_cat_admin = nv_news_array_cat_admin($module_data);
}

$admin_id = $admin_info['admin_id'];
$NV_IS_ADMIN_MODULE = false;
$NV_IS_ADMIN_FULL_MODULE = false;
if (defined('NV_IS_SPADMIN')) {
    $NV_IS_ADMIN_MODULE = true;
    $NV_IS_ADMIN_FULL_MODULE = true;
} else {
    if (isset($array_cat_admin[$admin_id][0])) {
        $NV_IS_ADMIN_MODULE = true;
        if (intval($array_cat_admin[$admin_id][0]['admin']) == 2) {
            $NV_IS_ADMIN_FULL_MODULE = true;
        }
    }
}

$menu_list = array();
$menu_list['student'] = $lang_module['student'];
$menu_list['list'] = $lang_module['add_student'];
/* $menu_teacher = array();
$menu_teacher['teacher'] = $lang_module['list_teacher'];
$menu_teacher['add_teacher'] = $lang_module['add_teacher']; */




$submenu['courses'] = $lang_module['courses'];
$submenu['sciencecat'] = $lang_module['sciencecat'];
$submenu['subjectcat'] = $lang_module['subjectcat'];
$submenu['teacher']=$lang_module['teacher'];
/* $submenu['teacher'] = array('title'=>$lang_module['teacher'],'submenu'=>$menu_teacher); */
$submenu['student'] = array('title'=>$lang_module['list'],'submenu'=>$menu_list);
$submenu['admins'] = $lang_module['admins'];
$submenu['setting'] = $lang_module['setting'];
$submenu['tabs'] = $lang_module['tabs'];



$allow_func = array( 'main', 'setting', 'tabs', 'courses', 'list', 'alias', 'group', 'science', 'sciencecat', 'subject', 'subjectcat', 'teacher', 'student', 'admins', 'add_group', 'del_group', 'list_group', 'change_group', 'add_science', 'del_science', 'list_science', 'add_sciencecat', 'del_sciencecat', 'list_sciencecat', 'change_sciencecat', 'add_subjects', 'del_subjects', 'list_subjects', 'add_subjectscat', 'del_subjectscat', 'list_subjectcat', 'change_subjectcat', 'add_teacher', 'del_teacher', 'list_teacher', 'add_student', 'del_student', 'list_student');


/* if ($NV_IS_ADMIN_MODULE) {


}
 */

