<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang.vn (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang.vn. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Mon, 04 Apr 2016 02:24:16 GMT
 */

if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$title = $nv_Request->get_title('title', 'post', '');
$alias = change_alias($title);
if ($module_config[$module_name]['alias_lower']) {
    $alias = strtolower($alias);
}

$id = $nv_Request->get_int('id', 'post', 0);
$mod = $nv_Request->get_string('mod', 'post', '');

if ($mod == 'sciencecat') {
    $tab = NV_PREFIXLANG . '_' . $module_data . '_sciencecat';
    $stmt = $db_slave->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE catid!=' . $id . ' AND alias= :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();
    $nb = $stmt->fetchColumn();
    if (! empty($nb)) {
        $nb = $db_slave->query('SELECT MAX(catid) FROM ' . $tab)->fetchColumn();

        $alias .= '-' . (intval($nb) + 1);
    }
} elseif ($mod == 'subjectscat') {
    $tab = NV_PREFIXLANG . '_' . $module_data . '_subjectscat';
    $stmt = $db_slave->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE catid!=' . $id . ' AND alias= :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();
    $nb = $stmt->fetchColumn();
    if (! empty($nb)) {
        $nb = $db_slave->query('SELECT MAX(topicid) FROM ' . $tab)->fetchColumn();

        $alias .= '-' . (intval($nb) + 1);
    }
} 

include NV_ROOTDIR . '/includes/header.php';
echo $alias;
include NV_ROOTDIR . '/includes/footer.php';
