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
$mod = $nv_Request->get_string('mod', 'post', '');
$new_vid = $nv_Request->get_int('new_vid', 'post', 0);
$content = 'NO_' . $catid;

list($catid, $parentid, $numsubcat) = $db->query('SELECT catid, parentid, numsubcat FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat WHERE catid=' . $catid)->fetch(3);
if ($catid > 0) {
    if ($mod == 'weight' and $new_vid > 0 and (defined('NV_IS_ADMIN_MODULE') or ($parentid > 0 and isset($array_subjectcat_admin[$admin_id][$parentid]) and $array_subjectcat_admin[$admin_id][$parentid]['admin'] == 1))) {
        $sql = 'SELECT catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat WHERE catid!=' . $catid . ' AND parentid=' . $parentid . ' ORDER BY weight ASC';
        $result = $db->query($sql);

        $weight = 0;
        while ($row = $result->fetch()) {
            ++$weight;
            if ($weight == $new_vid) {
                ++$weight;
            }
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat SET weight=' . $weight . ' WHERE catid=' . $row['catid'];
            $db->query($sql);
        }

        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat SET weight=' . $new_vid . ' WHERE catid=' . $catid ;
        $db->query($sql);

        nv_fix_subjectcat_order();
        $content = 'OK_' . $parentid;
    } elseif (defined('NV_IS_ADMIN_MODULE') or (isset($array_subjectcat_admin[$admin_id][$catid]) and $array_subjectcat_admin[$admin_id][$catid]['add_content'] == 1)) {
        if ($mod == 'inhome' and ($new_vid == 0 or $new_vid == 1)) {
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat SET inhome=' . $new_vid . ' WHERE catid=' . $catid ;
            $db->query($sql);
            $content = 'OK_' . $parentid;
        } elseif ($mod == 'numlinks' and $new_vid >= 0 and $new_vid <= 20) {
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat SET numlinks=' . $new_vid . ' WHERE catid=' . $catid ;
            $db->query($sql);
            $content = 'OK_' . $parentid;
        } elseif ($mod == 'newday' and $new_vid >= 0 and $new_vid <= 10) {
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat SET newday=' . $new_vid . ' WHERE catid=' . $catid ;
            $db->query($sql);
            $content = 'OK_' . $parentid;
        } elseif ($mod == 'viewcat' and $nv_Request->isset_request('new_vid', 'post')) {
            $viewcat = $nv_Request->get_title('new_vid', 'post');
            $array_viewcat = ($numsubcat > 0) ? $array_viewcat_full : $array_viewcat_nosub;
            if (! array_key_exists($viewcat, $array_viewcat)) {
                $viewcat = 'viewcat_page_new';
            }
            $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subjectcat SET viewcat= :viewcat WHERE catid=' . $catid);
            $stmt->bindParam(':viewcat', $viewcat, PDO::PARAM_STR);
            $stmt->execute();
            $content = 'OK_' . $parentid;
        }
    }
    $nv_Cache->delMod($module_name);
}

include NV_ROOTDIR . '/includes/header.php';
echo $content;
include NV_ROOTDIR . '/includes/footer.php';