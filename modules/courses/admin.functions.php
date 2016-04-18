<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 09:05:18 GMT
 */


if (! defined('NV_ADMIN') or ! defined('NV_MAINFILE') or ! defined('NV_IS_MODADMIN')) {
    die('Stop!!!');
}

if ($NV_IS_ADMIN_MODULE) {
    define('NV_IS_ADMIN_MODULE', true);
}

if ($NV_IS_ADMIN_FULL_MODULE) {
    define('NV_IS_ADMIN_FULL_MODULE', true);
}

$array_viewsciencecat_full = array(
    'viewcat_page_new' => $lang_module['viewcat_page_new'],
    'viewcat_page_old' => $lang_module['viewcat_page_old'],
    'viewcat_list_new' => $lang_module['viewcat_list_new'],
    'viewcat_list_old' => $lang_module['viewcat_list_old'],
    'viewcat_grid_new' => $lang_module['viewcat_grid_new'],
    'viewcat_grid_old' => $lang_module['viewcat_grid_old'],
    'viewcat_main_left' => $lang_module['viewcat_main_left'],
    'viewcat_main_right' => $lang_module['viewcat_main_right'],
    'viewcat_main_bottom' => $lang_module['viewcat_main_bottom'],
    'viewcat_two_column' => $lang_module['viewcat_two_column'],
    'viewcat_none' => $lang_module['viewcat_none']
);
$array_viewcat_nosub = array(
    'viewcat_page_new' => $lang_module['viewcat_page_new'],
    'viewcat_page_old' => $lang_module['viewcat_page_old'],
    'viewcat_list_new' => $lang_module['viewcat_list_new'],
    'viewcat_list_old' => $lang_module['viewcat_list_old'],
    'viewcat_grid_new' => $lang_module['viewcat_grid_new'],
    'viewcat_grid_old' => $lang_module['viewcat_grid_old']
);

$array_allowed_comm = array(
    $lang_global['no'],
    $lang_global['level6'],
    $lang_global['level4']
);

define('NV_IS_FILE_ADMIN', true);
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

 global $global_array_sciencecat;
$global_array_sciencecat = array();
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat ORDER BY sort ASC';
$result = $db_slave->query($sql);
while ($row = $result->fetch()) {
    $global_array_sciencecat[$row['catid']] = $row;
}
 
 
 global $global_array_subjectcat;
$global_array_subjectcat = array();
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat ORDER BY sort ASC';
$result = $db_slave->query($sql);
while ($row = $result->fetch()) {
    $global_array_subjectcat[$row['catid']] = $row;
}
/**
 * nv_fix_sciencecat_order()
 *
 * @param integer $parentid
 * @param integer $order
 * @param integer $lev
 * @return
 */
function nv_fix_sciencecat_order($parentid = 0, $order = 0, $lev = 0)
{
    global $db, $module_data;

    $sql = 'SELECT catid, parentid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat WHERE parentid=' . $parentid . ' ORDER BY weight ASC';
    $result = $db->query($sql);
    $array_sciencecat_order = array();
    while ($row = $result->fetch()) {
        $array_sciencecat_order[] = $row['catid'];
    }
    $result->closeCursor();
    $weight = 0;
    if ($parentid > 0) {
        ++$lev;
    } else {
        $lev = 0;
    }
    foreach ($array_sciencecat_order as $catid_i) {
        ++$order;
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat SET weight=' . $weight . ', sort=' . $order . ', lev=' . $lev . ' WHERE catid=' . intval($catid_i);
        $db->query($sql);
        $order = nv_fix_sciencecat_order($catid_i, $order, $lev);
    }
    $numsubcat = $weight;
    if ($parentid > 0) {
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat SET numsubcat=' . $numsubcat;
        if ($numsubcat == 0) {
            $sql .= ",subcatid=''";
        } else {
            $sql .= ",subcatid='" . implode(',', $array_sciencecat_order) . "'";
        }
        $sql .= ' WHERE catid=' . intval($parentid);
        $db->query($sql);
    }
    return $order;
}


/**
 * nv_fix_subjectcat_order()
 *
 * @param integer $parentid
 * @param integer $order
 * @param integer $lev
 * @return
 */
function nv_fix_subjectcat_order($parentid = 0, $order = 0, $lev = 0)
{
    global $db, $module_data;

    $sql = 'SELECT catid, parentid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat WHERE parentid=' . $parentid . ' ORDER BY weight ASC';
    $result = $db->query($sql);
    $array_subjectcat_order = array();
    while ($row = $result->fetch()) {
        $array_subjectcat_order[] = $row['catid'];
    }
    $result->closeCursor();
    $weight = 0;
    if ($parentid > 0) {
        ++$lev;
    } else {
        $lev = 0;
    }
    foreach ($array_subjectcat_order as $catid_i) {
        ++$order;
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat SET weight=' . $weight . ', sort=' . $order . ', lev=' . $lev . ' WHERE catid=' . intval($catid_i);
        $db->query($sql);
        $order = nv_fix_subjectcat_order($catid_i, $order, $lev);
    }
    $numsubcat = $weight;
    if ($parentid > 0) {
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat SET numsubcat=' . $numsubcat;
        if ($numsubcat == 0) {
            $sql .= ",subcatid=''";
        } else {
            $sql .= ",subcatid='" . implode(',', $array_subjectcat_order) . "'";
        }
        $sql .= ' WHERE catid=' . intval($parentid);
        $db->query($sql);
    }
    return $order;
}


/**
 * nv_fix_topic()
 *
 * @return
 */
function nv_fix_topic()
{
    global $db, $module_data;
    $sql = 'SELECT topicid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_topics ORDER BY weight ASC';
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_topics SET weight=' . $weight . ' WHERE topicid=' . intval($row['topicid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_fix_block_sciencecat()
 *
 * @return
 */
function nv_fix_block_sciencecat()
{
    global $db, $module_data;
    $sql = 'SELECT bid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_sciencecat ORDER BY weight ASC';
    $weight = 0;
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block_sciencecat SET weight=' . $weight . ' WHERE bid=' . intval($row['bid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_fix_source()
 *
 * @return
 */
function nv_fix_source()
{
    global $db, $module_data;
    $sql = 'SELECT sourceid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources ORDER BY weight ASC';
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sources SET weight=' . $weight . ' WHERE sourceid=' . intval($row['sourceid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_news_fix_block()
 *
 * @param mixed $bid
 * @param bool $repairtable
 * @return
 */
function nv_news_fix_block($bid, $repairtable = true)
{
    global $db, $module_data;
    $bid = intval($bid);
    if ($bid > 0) {
        $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $bid . ' ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch()) {
            ++$weight;
            if ($weight <= 100) {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block SET weight=' . $weight . ' WHERE bid=' . $bid . ' AND id=' . $row['id'];
            } else {
                $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE bid=' . $bid . ' AND id=' . $row['id'];
            }
            $db->query($sql);
        }
        $result->closeCursor();
        if ($repairtable) {
            $db->query('OPTIMIZE TABLE ' . NV_PREFIXLANG . '_' . $module_data . '_block');
        }
    }
}

/**
 * nv_show_sciencecat_list()
 *
 * @param integer $parentid
 * @return
 */
function nv_show_sciencecat_list($parentid = 0)
{
    global $db, $lang_module, $lang_global, $module_name, $module_data, $array_viewcat_full, $array_viewcat_nosub, $array_sciencecat_admin, $global_array_sciencecat, $admin_id, $global_config, $module_file;

    $xtpl = new XTemplate('list_sciencecat.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);

    // Cac chu de co quyen han
    $array_sciencecat_check_content = array();
    foreach ($global_array_sciencecat as $catid_i => $array_value) {
        if (defined('NV_IS_ADMIN_MODULE')) {
            $array_sciencecat_check_content[] = $catid_i;
        } elseif (isset($array_sciencecat_admin[$admin_id][$catid_i])) {
            if ($array_sciencecat_admin[$admin_id][$catid_i]['admin'] == 1) {
                $array_sciencecat_check_content[] = $catid_i;
            } elseif ($array_sciencecat_admin[$admin_id][$catid_i]['add_content'] == 1) {
                $array_sciencecat_check_content[] = $catid_i;
            } elseif ($array_sciencecat_admin[$admin_id][$catid_i]['pub_content'] == 1) {
                $array_sciencecat_check_content[] = $catid_i;
            } elseif ($array_sciencecat_admin[$admin_id][$catid_i]['edit_content'] == 1) {
                $array_sciencecat_check_content[] = $catid_i;
            }
        }
    }

    // Cac chu de co quyen han
    if ($parentid > 0) {
        $parentid_i = $parentid;
        $array_sciencecat_title = array();
        while ($parentid_i > 0) {
            $array_sciencecat_title[] = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=sciencecat&amp;parentid=" . $parentid_i . "\"><strong>" . $global_array_sciencecat[$parentid_i]['title'] . "</strong></a>";
            $parentid_i = $global_array_sciencecat[$parentid_i]['parentid'];
        }
        sort($array_sciencecat_title, SORT_NUMERIC);

        $xtpl->assign('CAT_TITLE', implode(' &raquo; ', $array_sciencecat_title));
        $xtpl->parse('main.cat_title');
    }

    $sql = 'SELECT catid, parentid, title, weight, viewcat, numsubcat, inhome, numlinks, newday FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat WHERE parentid = ' . $parentid . ' ORDER BY weight ASC';
    $rowall = $db->query($sql)->fetchAll(3);
    $num = sizeof($rowall);
    $a = 1;
    $array_inhome = array(
        $lang_global['no'],
        $lang_global['yes']
    );

    foreach ($rowall as $row) {
        list($catid, $parentid, $title, $weight, $viewcat, $numsubcat, $inhome, $numlinks, $newday) = $row;
        if (defined('NV_IS_ADMIN_MODULE')) {
            $check_show = 1;
        } else {
            $array_sciencecat = GetCatidInParent($catid);
            $check_show = array_intersect($array_sciencecat, $array_sciencecat_check_content);
        }

        if (! empty($check_show)) {
            $array_viewcat = ($numsubcat > 0) ? $array_viewcat_full : $array_viewcat_nosub;
            if (! array_key_exists($viewcat, $array_viewcat)) {
                $viewcat = 'viewcat_page_new';
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sciencecat SET viewcat= :viewcat WHERE catid=' . intval($catid));
                $stmt->bindParam(':viewcat', $viewcat, PDO::PARAM_STR);
                $stmt->execute();
            }

            $admin_funcs = array();
            $weight_disabled = $func_sciencecat_disabled = true;
            if (defined('NV_IS_ADMIN_MODULE') or ($parentid > 0 and isset($array_sciencecat_admin[$admin_id][$parentid]) and $array_sciencecat_admin[$admin_id][$parentid]['admin'] == 1)) {
                $func_sciencecat_disabled = false;
                $admin_funcs[] = "<em class=\"fa fa-edit fa-lg\">&nbsp;</em> <a class=\"\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=sciencecat&amp;catid=" . $catid . "&amp;parentid=" . $parentid . "#edit\">" . $lang_global['edit'] . "</a>\n";
            }
            if (defined('NV_IS_ADMIN_MODULE') or ($parentid > 0 and isset($array_sciencecat_admin[$admin_id][$parentid]) and $array_sciencecat_admin[$admin_id][$parentid]['admin'] == 1)) {
                $weight_disabled = false;
                $admin_funcs[] = "<em class=\"fa fa-trash-o fa-lg\">&nbsp;</em> <a href=\"javascript:void(0);\" onclick=\"nv_del_sciencecat(" . $catid . ")\">" . $lang_global['delete'] . "</a>";
            }

            $xtpl->assign('ROW', array(
                'catid' => $catid,
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=sciencecat&amp;parentid=' . $catid,
                'title' => $title,
                'adminfuncs' => implode('&nbsp;-&nbsp;', $admin_funcs)
            ));

            if ($weight_disabled) {
                $xtpl->assign('STT', $a);
                $xtpl->parse('main.data.loop.stt');
            } else {
                for ($i = 1; $i <= $num; ++$i) {
                    $xtpl->assign('WEIGHT', array(
                        'key' => $i,
                        'title' => $i,
                        'selected' => $i == $weight ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.weight.loop');
                }
                $xtpl->parse('main.data.loop.weight');
            }

            if ($func_sciencecat_disabled) {
                $xtpl->assign('INHOME', $array_inhome[$inhome]);
                $xtpl->parse('main.data.loop.disabled_inhome');

                $xtpl->assign('VIEWCAT', $array_viewcat[$viewcat]);
                $xtpl->parse('main.data.loop.disabled_viewcat');

                $xtpl->assign('NUMLINKS', $numlinks);
                $xtpl->parse('main.data.loop.title_numlinks');

                $xtpl->assign('NEWDAY', $newday);
                $xtpl->parse('main.data.loop.title_newday');
            } else {
                foreach ($array_inhome as $key => $val) {
                    $xtpl->assign('INHOME', array(
                        'key' => $key,
                        'title' => $val,
                        'selected' => $key == $inhome ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.inhome.loop');
                }
                $xtpl->parse('main.data.loop.inhome');

                foreach ($array_viewcat as $key => $val) {
                    $xtpl->assign('VIEWCAT', array(
                        'key' => $key,
                        'title' => $val,
                        'selected' => $key == $viewcat ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.viewcat.loop');
                }
                $xtpl->parse('main.data.loop.viewcat');

                for ($i = 0; $i <= 20; ++$i) {
                    $xtpl->assign('NUMLINKS', array(
                        'key' => $i,
                        'title' => $i,
                        'selected' => $i == $numlinks ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.numlinks.loop');
                }
                $xtpl->parse('main.data.loop.numlinks');

                for ($i = 0; $i <= 10; ++$i) {
                    $xtpl->assign('NEWDAY', array(
                        'key' => $i,
                        'title' => $i,
                        'selected' => $i == $newday ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.newday.loop');
                }
                $xtpl->parse('main.data.loop.newday');
            }

            if ($numsubcat) {
                $xtpl->assign('NUMSUBCAT', $numsubcat);
                $xtpl->parse('main.data.loop.numsubcat');
            }

            $xtpl->parse('main.data.loop');
            ++$a;
        }
    }

    if ($num > 0) {
        $xtpl->parse('main.data');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    return $contents;
}

/**
 * nv_show_subjectcat_list()
 *
 * @param integer $parentid
 * @return
 */
function nv_show_subjectcat_list($parentid = 0)
{
    global $db, $lang_module, $lang_global, $module_name, $module_data, $array_viewcat_full, $array_viewcat_nosub, $array_subjectcat_admin, $global_array_subjectcat, $admin_id, $global_config, $module_file;

    $xtpl = new XTemplate('list_subjectcat.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);

    // Cac chu de co quyen han
    $array_subjectcat_check_content = array();
    foreach ($global_array_subjectcat as $catid_i => $array_value) {
        if (defined('NV_IS_ADMIN_MODULE')) {
            $array_subjectcat_check_content[] = $catid_i;
        } elseif (isset($array_subjectcat_admin[$admin_id][$catid_i])) {
            if ($array_subjectcat_admin[$admin_id][$catid_i]['admin'] == 1) {
                $array_subjectcat_check_content[] = $catid_i;
            } elseif ($array_subjectcat_admin[$admin_id][$catid_i]['add_content'] == 1) {
                $array_subjectcat_check_content[] = $catid_i;
            } elseif ($array_subjectcat_admin[$admin_id][$catid_i]['pub_content'] == 1) {
                $array_subjectcat_check_content[] = $catid_i;
            } elseif ($array_subjectcat_admin[$admin_id][$catid_i]['edit_content'] == 1) {
                $array_subjectcat_check_content[] = $catid_i;
            }
        }
    }

    // Cac chu de co quyen han
    if ($parentid > 0) {
        $parentid_i = $parentid;
        $array_subjectcat_title = array();
        while ($parentid_i > 0) {
            $array_subjectcat_title[] = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=subjectcat&amp;parentid=" . $parentid_i . "\"><strong>" . $global_array_subjectcat[$parentid_i]['title'] . "</strong></a>";
            $parentid_i = $global_array_subjectcat[$parentid_i]['parentid'];
        }
        sort($array_subjectcat_title, SORT_NUMERIC);

        $xtpl->assign('CAT_TITLE', implode(' &raquo; ', $array_subjectcat_title));
        $xtpl->parse('main.cat_title');
    }

    $sql = 'SELECT catid, parentid, title, weight, viewcat, numsubcat, inhome, numlinks, newday FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat WHERE parentid = ' . $parentid . ' ORDER BY weight ASC';
    $rowall = $db->query($sql)->fetchAll(3);
    $num = sizeof($rowall);
    $a = 1;
    $array_inhome = array(
        $lang_global['no'],
        $lang_global['yes']
    );

    foreach ($rowall as $row) {
        list($catid, $parentid, $title, $weight, $viewcat, $numsubcat, $inhome, $numlinks, $newday) = $row;
        if (defined('NV_IS_ADMIN_MODULE')) {
            $check_show = 1;
        } else {
            $array_subjectcat = GetCatidInParent2($catid);
            $check_show = array_intersect($array_subjectcat, $array_subjectcat_check_content);
        }

        if (! empty($check_show)) {
            $array_viewcat = ($numsubcat > 0) ? $array_viewcat_full : $array_viewcat_nosub;
            if (! array_key_exists($viewcat, $array_viewcat)) {
                $viewcat = 'viewcat_page_new';
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat SET viewcat= :viewcat WHERE catid=' . intval($catid));
                $stmt->bindParam(':viewcat', $viewcat, PDO::PARAM_STR);
                $stmt->execute();
            }

            $admin_funcs = array();
            $weight_disabled = $func_subjectcat_disabled = true;
            if (defined('NV_IS_ADMIN_MODULE') or ($parentid > 0 and isset($array_subjectcat_admin[$admin_id][$parentid]) and $array_subjectcat_admin[$admin_id][$parentid]['admin'] == 1)) {
                $func_subjectcat_disabled = false;
                $admin_funcs[] = "<em class=\"fa fa-edit fa-lg\">&nbsp;</em> <a class=\"\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=subjectcat&amp;catid=" . $catid . "&amp;parentid=" . $parentid . "#edit\">" . $lang_global['edit'] . "</a>\n";
            }
            if (defined('NV_IS_ADMIN_MODULE') or ($parentid > 0 and isset($array_subjectcat_admin[$admin_id][$parentid]) and $array_subjectcat_admin[$admin_id][$parentid]['admin'] == 1)) {
                $weight_disabled = false;
                $admin_funcs[] = "<em class=\"fa fa-trash-o fa-lg\">&nbsp;</em> <a href=\"javascript:void(0);\" onclick=\"nv_del_subjectcat(" . $catid . ")\">" . $lang_global['delete'] . "</a>";
            }

            $xtpl->assign('ROW', array(
                'catid' => $catid,
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=subjectcat&amp;parentid=' . $catid,
                'title' => $title,
                'adminfuncs' => implode('&nbsp;-&nbsp;', $admin_funcs)
            ));

            if ($weight_disabled) {
                $xtpl->assign('STT', $a);
                $xtpl->parse('main.data.loop.stt');
            } else {
                for ($i = 1; $i <= $num; ++$i) {
                    $xtpl->assign('WEIGHT', array(
                        'key' => $i,
                        'title' => $i,
                        'selected' => $i == $weight ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.weight.loop');
                }
                $xtpl->parse('main.data.loop.weight');
            }

            if ($func_subjectcat_disabled) {
                $xtpl->assign('INHOME', $array_inhome[$inhome]);
                $xtpl->parse('main.data.loop.disabled_inhome');

                $xtpl->assign('VIEWCAT', $array_viewcat[$viewcat]);
                $xtpl->parse('main.data.loop.disabled_viewcat');

                $xtpl->assign('NUMLINKS', $numlinks);
                $xtpl->parse('main.data.loop.title_numlinks');

                $xtpl->assign('NEWDAY', $newday);
                $xtpl->parse('main.data.loop.title_newday');
            } else {
                foreach ($array_inhome as $key => $val) {
                    $xtpl->assign('INHOME', array(
                        'key' => $key,
                        'title' => $val,
                        'selected' => $key == $inhome ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.inhome.loop');
                }
                $xtpl->parse('main.data.loop.inhome');

                foreach ($array_viewcat as $key => $val) {
                    $xtpl->assign('VIEWCAT', array(
                        'key' => $key,
                        'title' => $val,
                        'selected' => $key == $viewcat ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.viewcat.loop');
                }
                $xtpl->parse('main.data.loop.viewcat');

                for ($i = 0; $i <= 20; ++$i) {
                    $xtpl->assign('NUMLINKS', array(
                        'key' => $i,
                        'title' => $i,
                        'selected' => $i == $numlinks ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.numlinks.loop');
                }
                $xtpl->parse('main.data.loop.numlinks');

                for ($i = 0; $i <= 10; ++$i) {
                    $xtpl->assign('NEWDAY', array(
                        'key' => $i,
                        'title' => $i,
                        'selected' => $i == $newday ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.newday.loop');
                }
                $xtpl->parse('main.data.loop.newday');
            }

            if ($numsubcat) {
                $xtpl->assign('NUMSUBCAT', $numsubcat);
                $xtpl->parse('main.data.loop.numsubcat');
            }

            $xtpl->parse('main.data.loop');
            ++$a;
        }
    }

    if ($num > 0) {
        $xtpl->parse('main.data');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    return $contents;
}

/**
 * nv_show_block_sciencecat_list()
 *
 * @return
 */
function nv_show_block_sciencecat_list()
{
    global $db_slave, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $global_config, $module_info;

    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_sciencecat ORDER BY weight ASC';
    $_array_block_sciencecat = $db_slave->query($sql)->fetchAll();
    $num = sizeof($_array_block_sciencecat);

    if ($num > 0) {
        $array_adddefault = array(
            $lang_global['no'],
            $lang_global['yes']
        );

        $xtpl = new XTemplate('blockcat_lists.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('GLANG', $lang_global);

        foreach ($_array_block_sciencecat as $row) {
            $numnews = $db_slave->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $row['bid'])->fetchColumn();

            $xtpl->assign('ROW', array(
                'bid' => $row['bid'],
                'title' => $row['title'],
                'numnews' => $numnews,
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=block&amp;bid=' . $row['bid'],
                'linksite' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'] . '/' . $row['alias'],
                'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;bid=' . $row['bid'] . '#edit'
            ));

            for ($i = 1; $i <= $num; ++$i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }

            foreach ($array_adddefault as $key => $val) {
                $xtpl->assign('ADDDEFAULT', array(
                    'key' => $key,
                    'title' => $val,
                    'selected' => $key == $row['adddefault'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.adddefault');
            }

            for ($i = 1; $i <= 30; ++$i) {
                $xtpl->assign('NUMBER', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['numbers'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.number');
            }

            $xtpl->parse('main.loop');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }

    return $contents;
}

/**
 * nv_show_sources_list()
 *
 * @return
 */
function nv_show_sources_list()
{
    global $db_slave, $lang_module, $lang_global, $module_name, $module_data, $nv_Request, $module_file, $global_config;

    $num = $db_slave->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources')->fetchColumn();
    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_data . '&amp;' . NV_OP_VARIABLE . '=sources';
    $num_items = ($num > 1) ? $num : 1;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'get', 1);

    $xtpl = new XTemplate('sources_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);

    if ($num > 0) {
        $db_slave->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_sources')
            ->order('weight')
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);

        $result = $db_slave->query($db_slave->sql());
        while ($row = $result->fetch()) {
            $xtpl->assign('ROW', array(
                'sourceid' => $row['sourceid'],
                'title' => $row['title'],
                'link' => $row['link'],
                'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=sources&amp;sourceid=' . $row['sourceid'] . '#edit'
            ));

            for ($i = 1; $i <= $num; ++$i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }

            $xtpl->parse('main.loop');
        }
        $result->closeCursor();

        $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
        if (! empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main.generate_page');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }

    return $contents;
}

/**
 * nv_show_block_list()
 *
 * @param mixed $bid
 * @return
 */
function nv_show_block_list($bid)
{
    global $db_slave, $lang_module, $lang_global, $module_name, $module_data, $op, $global_array_sciencecat, $module_file, $global_config;

    $xtpl = new XTemplate('block_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('BID', $bid);

    $global_array_sciencecat[0] = array( 'alias' => 'Other' );

    $sql = 'SELECT t1.id, t1.catid, t1.title, t1.alias, t2.weight FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_block t2 ON t1.id = t2.id WHERE t2.bid= ' . $bid . ' AND t1.status=1 ORDER BY t2.weight ASC';
    $array_block = $db_slave->query($sql)->fetchAll();

    $num = sizeof($array_block);
    if ($num > 0) {
        foreach ($array_block as $row) {
            $xtpl->assign('ROW', array(
                'id' => $row['id'],
                'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_sciencecat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'],
                'title' => $row['title']
            ));

            for ($i = 1; $i <= $num; ++$i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }

            $xtpl->parse('main.loop');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }
    return $contents;
}

/**
 * GetCatidInParent()
 *
 * @param mixed $catid
 * @return
 */
function GetCatidInParent($catid)
{
    global $global_array_sciencecat;
    $array_sciencecat = array();
    $array_sciencecat[] = $catid;
    $subcatid = explode(',', $global_array_sciencecat[$catid]['subcatid']);
    if (! empty($subcatid)) {
        foreach ($subcatid as $id) {
            if ($id > 0) {
                if ($global_array_sciencecat[$id]['numsubcat'] == 0) {
                    $array_sciencecat[] = $id;
                } else {
                    $array_sciencecat_temp = GetCatidInParent($id);
                    foreach ($array_sciencecat_temp as $catid_i) {
                        $array_sciencecat[] = $catid_i;
                    }
                }
            }
        }
    }
    return array_unique($array_sciencecat);
}


/**
 * GetCatidInParent()
 *
 * @param mixed $catid
 * @return
 */
function GetCatidInParent2($catid)
{
    global $global_array_subjectcat;
    $array_subjectcat = array();
    $array_subjectcat[] = $catid;
    $subcatid = explode(',', $global_array_subjectcat[$catid]['subcatid']);
    if (! empty($subcatid)) {
        foreach ($subcatid as $id) {
            if ($id > 0) {
                if ($global_array_subjectcat[$id]['numsubcat'] == 0) {
                    $array_subjectcat[] = $id;
                } else {
                    $array_subjectcat_temp = GetCatidInParent($id);
                    foreach ($array_subjectcat_temp as $catid_i) {
                        $array_subjectcat[] = $catid_i;
                    }
                }
            }
        }
    }
    return array_unique($array_subjectcat);
}

/**
 * redriect()
 *
 * @param string $msg1
 * @param string $msg2
 * @param mixed $nv_redirect
 * @return
 */
function redriect($msg1 = '', $msg2 = '', $nv_redirect, $autoSaveKey = '', $go_back = '')
{
    global $global_config, $module_file, $module_name;
    $xtpl = new XTemplate('redriect.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

    if (empty($nv_redirect)) {
        $nv_redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
    }
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('NV_REDIRECT', $nv_redirect);
    $xtpl->assign('MSG1', $msg1);
    $xtpl->assign('MSG2', $msg2);

    if (! empty($autoSaveKey)) {
        $xtpl->assign('AUTOSAVEKEY', $autoSaveKey);
        $xtpl->parse('main.removelocalstorage');
    }

    if ($go_back) {
        $xtpl->parse('main.go_back');
    } else {
        $xtpl->parse('main.meta_refresh');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}
