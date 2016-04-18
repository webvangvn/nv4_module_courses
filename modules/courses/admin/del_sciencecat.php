<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 09:05:18 GMT
 */

if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$catid = $nv_Request->get_int('catid', 'post', 0);
$contents = 'NO_' . $catid;

list($catid, $parentid, $title) = $db->query('SELECT catid, parentid, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat WHERE catid=' . $catid)->fetch(3);
if ($catid > 0) {
    if ((defined('NV_IS_ADMIN_MODULE') or ($parentid > 0 and isset($array_sciencecat_admin[$admin_id][$parentid]) and $array_sciencecat_admin[$admin_id][$parentid]['admin'] == 1))) {
        $delallcheckss = $nv_Request->get_string('delallcheckss', 'post', '');
        $check_parentid = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat WHERE parentid = ' . $catid)->fetchColumn();
        if (intval($check_parentid) > 0) {
            $contents = 'ERR_CAT_' . sprintf($lang_module['delcat_msg_cat'], $check_parentid);
        } else {
            $check_rows = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_science')->fetchColumn();
            if (intval($check_rows) > 0) {
                if ($delallcheckss == md5($catid . session_id() . $global_config['sitekey'])) {
                    $delcatandrows = $nv_Request->get_string('delcatandrows', 'post', '');
                    $movecat = $nv_Request->get_string('movecat', 'post', '');
                    $catidnews = $nv_Request->get_int('catidnews', 'post', 0);
                    if (empty($delcatandrows) and empty($movecat)) {
                        $sql = 'SELECT catid, title, lev FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat WHERE catid !=' . $catid . ' ORDER BY sort ASC';
                        $result = $db->query($sql);
                        $array_sciencecat_list = array();
                        $array_sciencecat_list[0] = '&nbsp;';
                        while (list($catid_i, $title_i, $lev_i) = $result->fetch(3)) {
                            $xtitle_i = '';
                            if ($lev_i > 0) {
                                $xtitle_i .= '&nbsp;&nbsp;&nbsp;|';
                                for ($i = 1; $i <= $lev_i; ++$i) {
                                    $xtitle_i .= '---';
                                }
                                $xtitle_i .= '>&nbsp;';
                            }
                            $xtitle_i .= $title_i;
                            $array_sciencecat_list[$catid_i] = $xtitle_i;
                        }

                        $xtpl = new XTemplate('del_sciencecat.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
                        $xtpl->assign('LANG', $lang_module);
                        $xtpl->assign('GLANG', $lang_global);
                        $xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
                        $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
                        $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
                        $xtpl->assign('MODULE_NAME', $module_name);
                        $xtpl->assign('OP', $op);
                        $xtpl->assign('CATID', $catid);
                        $xtpl->assign('DELALLCHECKSS', $delallcheckss);

                        $xtpl->assign('TITLE', sprintf($lang_module['delcat_msg_rows_select'], $title, $check_rows));

                        while (list($catid_i, $title_i) = each($array_sciencecat_list)) {
                            $xtpl->assign('CATIDNEWS', array( 'key' => $catid_i, 'title' => $title_i ));
                            $xtpl->parse('main.catidnews');
                        }

                        $xtpl->parse('main');
                        $contents = $xtpl->text('main');
                    } elseif (! empty($delcatandrows)) {
                        nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['delcatandrows'], $title, $admin_info['userid']);

                        $sql = $db->query('SELECT id, catid, listcatid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_science' );
                        while ($row = $sql->fetch()) {
                            if ($row['catid'] == $row['listcatid']) {
                                nv_del_content_module($row['id']);
                            } else {
                                $arr_sciencecatid_old = explode(',', $row['listcatid']);
                                $arr_sciencecatid_i = array( $catid );
                                $arr_sciencecatid_news = array_diff($arr_sciencecatid_old, $arr_sciencecatid_i);
                                if ($catid == $row['catid']) {
                                    $row['catid'] = $arr_sciencecatid_news[0];
                                }
                                foreach ($arr_sciencecatid_news as $catid_i) {
                                    if (isset($global_array_sciencecat[$catid_i])) {
                                        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_science"  . " SET catid=" . $row['catid'] . ", listcatid = '" . implode(',', $arr_sciencecatid_news) . "' WHERE id =" . $row['id']);
                                    }
                                }
                               
                            }
                        }
                        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat WHERE catid=' . $catid);
                        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins WHERE catid=' . $catid);

                        nv_fix_sciencecat_order();
                        $nv_Cache->delMod($module_name);
                        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=sciencecat&parentid=' . $parentid);
                        die();
                    } elseif (! empty($movecat) and $catidnews > 0 and $catidnews != $catid) {
                        list($catidnews, $newstitle) = $db->query('SELECT catid, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat WHERE catid =' . $catidnews)->fetch(3);
                        if ($catidnews > 0) {
                            nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['move'], $title . ' --> ' . $newstitle, $admin_info['userid']);

                            $sql = $db->query('SELECT id, catid, listcatid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_science' );
                            while ($row = $sql->fetch()) {
                                $arr_sciencecatid_old = explode(',', $row['listcatid']);
                                $arr_sciencecatid_i = array( $catid );
                                $arr_sciencecatid_news = array_diff($arr_sciencecatid_old, $arr_sciencecatid_i);
                                if ($catid == $row['catid']) {
                                    $row['catid'] = $catidnews;
                                }
                                foreach ($arr_sciencecatid_news as $catid_i) {
                                    if (isset($global_array_sciencecat[$catid_i])) {
                                        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_science"  . " SET catid=" . $row['catid'] . ", listcatid = '" . implode(',', $arr_sciencecatid_news) . "' WHERE id =" . $row['id']);
                                    }
                                }
                                
                            }
                            $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat WHERE catid=' . $catid);
                            $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins WHERE catid=' . $catid);

                            nv_fix_sciencecat_order();
                            $nv_Cache->delMod($module_name);
                            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=sciencecat&parentid=' . $parentid);
                            die();
                        }
                    }
                } else {
                    $contents = 'ERR_ROWS_' . $catid . '_' . md5($catid . session_id() . $global_config['sitekey']) . '_' . sprintf($lang_module['delcat_msg_rows'], $check_rows);
                }
            }
        }
        if ($contents == 'NO_' . $catid) {
            if ($delallcheckss == md5($catid . session_id())) {
                $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat WHERE catid=' . $catid;
                if ($db->exec($sql)) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['delcatandrows'], $title, $admin_info['userid']);
                    nv_fix_sciencecat_order();
                    
                    $contents = 'OK_' . $parentid;
                }
                $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins WHERE catid=' . $catid);
                $nv_Cache->delMod($module_name);
            } else {
                $contents = 'CONFIRM_' . $catid . '_' . md5($catid . session_id());
            }
        }
    } else {
        $contents = 'ERR_CAT_' . $lang_module['delcat_msg_cat_permissions'];
    }
}

if (defined('NV_IS_AJAX')) {
    include NV_ROOTDIR . '/includes/header.php';
    echo $contents;
    include NV_ROOTDIR . '/includes/footer.php';
} else {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=sciencecat');
    die();
}